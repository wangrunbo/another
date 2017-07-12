<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Amazon component
 *
 * @property \App\Controller\Component\DataComponent $Data
 */
class AmazonComponent extends Component
{

    /** 商品无法购买的情况 */
    const AMAZON_PRODUCT_SOLD_OUT = ['在庫切れ。'];

    /** 不提取的商品信息 */
    const AMAZON_IGNORE_INFO = ['おすすめ度', 'Amazon 売れ筋ランキング'];

    /**
     * The other component used
     *
     * @var array
     */
    public $components = ['Data'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'pattern' => [
            '404' => '{<title>404 - ドキュメントが見つかりません。</title>}',
            'name' => '{^<title>Amazon \| (.+?) \|.*</title>$}m',
            'price' => '{<span id="priceblock_ourprice" class="a-size-medium a-color-price">￥ (\d+,?[0-9,]+)</span>}',
            'standard' => '{<div id="twisterContainer".*?<form id="twister".*?<div class="a-row">[\s\n]*?<label>[\s\n]*(.+?)[\s\n]*?</label>[\s\n]*?<span class="selection">[\s\n]*(.+?)[\s\n]*?</span>[\s\n]*?</div>}s',  // TODO
            'product_type' => '',
            'sale_start_date' => '',
            'image' => '{<div id="main-image-container"(?:.|\n)*?<li class=".*?itemNo0.*?selected.*?"(?:.|\n)*?<div id="imgTagWrapperId"(?:.|\n)*?<img .*? src="(.*?)" .*?>}',
            'stock' => '{<div id="availability".*?<span.*?>[\s\n]*(.+?)[\s\n]*?</span>(?=[\s\n]*?<span.*?在庫状況</a>について</span>)}s',
            'description' => '{<div id="productDescription".*?<p>(.*?)[\n\t\s]*?</p>}s',
            'images' => [
                'container' => '{<script type="text/javascript">[\s\n]*maintainHeight = function\(\)\{.*?P\.when\(\'A\'\)\.register\("ImageBlockATF", function\(A\)\{[\s\n]*var data = \{[\s\n]*\'colorImages\': \{ \'initial\': \[(.*?)\]\},[\s\n]*\'colorToAsin\'.*?</script>}s'
            ],
            'info' => [
                'container' => [
                    '{<div id="prodDetails">.*?<h2>商品の情報</h2>.*?<h2}s',
                    '{<div id="technicalSpecifications_feature_div".*?<h2>商品の詳細</h2>.*?<h2}s',
                    '{<div id="detail_bullets_id">.*?</table>.*?<h2}s'
                ],
                'section' => [
                    '{<div class="column col\d+ ">.*?<div class="section techD">[\s\n]*?<div class="secHeader">[\s\n]*?<span>(.*?)</span>.*?(<table.*?>.*?</table>)}s',
                    '{<div class="a-column.*?<h5.*?>(.*?)</h5>.*?(<table id="technicalSpecifications_section_\d+".*?</table>)}s',
                    '{<table.*?<h2>(登録情報)[\r\s\n]*?</h2>.*?<div class="content">.*?<ul>(.*?)</ul>.*?</table>}s'
                ],
                'detail' => [
                    '{<tr.*?>[\s\n]*?<td class=[\'"]label[\'"]>(.+?)</td>[\s\n]*?<td class=[\'"]value[\'"]>(.+?)</td>[\s\n]*?</tr>}s',
                    '{<tr>[\s\n]*<th.*?>[\s\n]*(.*?)[\s\n]*</th>[\s\n]*<td.*?>[\s\n]*(.*?)[\s\n]*</td>[\s\n]*</tr>}s',
                    '{<li><b>\s*(.*?)\s*(?:：|:)\s*</b>\s*(.*?)\s*</li>}s'
                ]
            ]
        ]
    ];

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);
    }

    /**
     * 使用ASIN CODE获取Amazon商品
     *
     * @param string $asin
     * @return \App\Model\Entity\Product|null
     */
    public function get($asin)
    {
        $html = $this->_curl($asin);

        // 404 Not Found
        if (!$html || preg_match($this->getConfig('pattern.404'), $html)) {
            return null;
        }
//        dump($html);exit;
        /** @var \App\Model\Entity\Product $product */
        $product = TableRegistry::get('Products')->newEntity();

        $product->asin = $asin;  // ASIN CODE
        $product->name = $this->_extract($html, 'name');  // 商品名
        $product->price = $this->_extract($html, 'price');  // 商品价格
        $product->standard = $this->_extract($html, 'standard');  // 商品规格
        $product->product_type_id = 1; // TODO 商品类型
        $product->sale_start_date = null; // TODO 开始贩卖日
        $product->stock_flg = !in_array($this->_extract($html, 'stock'), self::AMAZON_PRODUCT_SOLD_OUT);  // 是否在库
        $product->description = $this->_extract($html, 'description');  // 商品介绍

        // 商品图像
        $this->_extract($html, 'images');

        // 商品情报
        $product_info = [];
        $ProductInfoTypesTable = TableRegistry::get('ProductInfoTypes');
        foreach ($this->_extract($html, 'info') as $type => $info) {
            $product_info_type = $ProductInfoTypesTable->find('active')->where(['name' => $type])->first();
            if (is_null($product_info_type)) {
                $product_info_type = $ProductInfoTypesTable->newEntity(['name' => $type]);
                $this->Data->completion($product_info_type);

                $ProductInfoTypesTable->save($product_info_type);
            }

            foreach ($info as $label => $content) {
                $product_info[] = [
                    'label' => $label,
                    'content' => $content,
                    'product_info_type_id' => $product_info_type->id
                ];
            }
        }

        $product->product_images = [];  // TODO
        $product->product_info = TableRegistry::get('ProductInfo')->newEntities($product_info); //TODO

        $this->Data->completion($product);
//        dump(TableRegistry::get('Products')->save($product));exit;
        dump($product);exit;
        return $product;
    }

    /**
     * 使用ASIN CODE抓取Amazon商品页面
     *
     * @param string|array $asins
     * @return string|array
     */
    protected function _curl($asins)
    {
        $curl = [];
        $html = [];

        $mh = curl_multi_init();

        foreach ((array)$asins as $asin) {
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => AMAZON_PRODUCT_PAGE_1.$asin.AMAZON_PRODUCT_PAGE_2,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_COOKIEFILE => AMAZON_COOKIE
            ]);
            if (!file_exists(AMAZON_COOKIE)) {
                curl_setopt($ch, CURLOPT_COOKIEJAR, AMAZON_COOKIE);
            }

            curl_multi_add_handle ($mh, $ch);

            $curl[$asin] = $ch;
        }

        $active = null;
        do {
            curl_multi_exec($mh, $active);
        } while ($active);

        foreach ($curl as $asin => $ch) {
            if (is_array($asins)) {
                $html[$asin] = curl_multi_getcontent($ch);
            } else {
                $html = curl_multi_getcontent($ch);
            }

            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }

        curl_multi_close($mh);

        return $html;
    }

    /**
     * 从html中提取商品信息
     *
     * @param string $html
     * @param string $part
     * @return string|array
     */
    protected function _extract($html, $part)
    {
        switch ($part) {
            case 'price':
                preg_match_all($this->getConfig("pattern.price"), $html, $matches);

                $result = @$matches[1][0];
                if (!is_null($result)) {
                    $result = (int)preg_replace('/,/', '', $result);
                }
                break;
            case 'standard':
                preg_match_all($this->getConfig("pattern.standard"), $html, $matches);

                if (empty($matches[0])) {
                    $result = null;
                } else {
                    $result = @"{$matches[1][0]} {$matches[2][0]}";
                }
                break;
            case 'images':
                preg_match_all($this->getConfig("pattern.images.container"), $html, $matches);

                break;
            case 'info':
                $result = [];
                for ($index = 0; $index < count($this->getConfig("pattern.info.container")); $index++) {
                    $match = preg_match($this->getConfig("pattern.info.container")[$index], $html, $container);
                    if ($match) {
                        $match = preg_match_all($this->getConfig("pattern.info.section")[$index], $container[0], $sections);
                        for ($i = 0; $i < $match; $i++) {
                            preg_match_all($this->getConfig("pattern.info.detail")[$index], $sections[2][$i], $info);
                            $result[$sections[1][$i]] = array_combine($info[1], $info[2]);

                            foreach (self::AMAZON_IGNORE_INFO as $ignore) {
                                if (array_key_exists($ignore, $result[$sections[1][$i]])) {
                                    unset($result[$sections[1][$i]][$ignore]);
                                }
                            }
                        }
                    }
                }
                break;
            default:
                preg_match_all($this->getConfig("pattern.{$part}"), $html, $matches);

                $result = @$matches[1][0];
        }
if ($part === 'images') {
    dump($matches);exit;
}
        return $result;
    }
}
