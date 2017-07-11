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
//            'standard' => '{<div id="twisterContainer"(?:.|\n)*?<form id="twister"(?:.|\n)*?<div class="a-row">[\s\n]*<label>[\s\n]*(.+?)[\s\n]*</label>[\s\n]*<span class="selection">[\s\n]*(.+?)[\s\n]*</span>[\s\n]*</div>}',  // TODO
            'standard' => '{<div id="twisterContainer".*?<form id="twister".*?<div class="a-row">[\s\n]*?<label>[\s\n]*(.+?)[\s\n]*?</label>[\s\n]*?<span class="selection">[\s\n]*(.+?)[\s\n]*?</span>[\s\n]*?</div>}s',  // TODO
            'product_type' => '',
            'sale_start_date' => '',
            'image' => '{<div id="main-image-container"(?:.|\n)*?<li class=".*?itemNo0.*?selected.*?"(?:.|\n)*?<div id="imgTagWrapperId"(?:.|\n)*?<img .*? src="(.*?)" .*?>}',
            'stock' => '{<div id="availability".*?<span.*?>[\s\n]*(.+?)[\s\n]*?</span>(?=[\s\n]*?<span.*?在庫状況</a>について</span>)}s',
            'description' => '{<div id="productDescription".*?<p>(.*?)[\n\t\s]*?</p>}s',
            'info' => [
                '{<div class="column col\d+ ">.*?<div class="section techD">[\s\n]*?<div class="secHeader">[\s\n]*?<span>(.*?)</span>.*?(<table.*?>.*?</table>)(?:(?!<div id="prodDetails">).)*?(?=<div class="column col\d+ ">|<h2)(?!.*<div id="prodDetails">)}s',
                '{<tr.*?>[\s\n]*?<td class=[\'"]label[\'"]>(.+?)</td>[\s\n]*?<td class=[\'"]value[\'"]>(.+?)</td>[\s\n]*?</tr>}s'
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

        // 商品情报
        $product_info = [];
        foreach ($this->_extract($html, 'info') as $type => $info) {
            $product_info_type = TableRegistry::get('ProductInfoTypes')->find('active')->where(['name' => $type])->first();
            if (is_null($product_info_type)) {
                $product_info_type = TableRegistry::get('ProductInfoTypes')->newEntity(['name' => $type]);
                $this->Data->completion($product_info_type);
            }

            foreach ($info as $label => $content) {
                $product_info[] = [
                    'label' => $label,
                    'content' => $content,
                    'product_info_type' => $product_info_type->toArray()
                ];
            }
        }

        $product->product_images = [];  // TODO
        $product->product_info = TableRegistry::get('ProductInfo')->newEntities($product_info); //TODO


        $this->Data->completion($product);
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
        preg_match_all(((array)$this->getConfig("pattern.{$part}"))[0], $html, $matches);

        switch ($part) {
            case 'price':
                $result = @$matches[1][0];
                if (!is_null($result)) {
                    $result = (int)preg_replace('/,/', '', $result);
                }
                break;
            case 'standard':
                if (empty($matches[0])) {
                    $result = null;
                } else {
                    $result = @"{$matches[1][0]} {$matches[2][0]}";
                }
                break;
            case 'info':
                $result = [];
                if (($c = count($matches[1])) === count($matches[2])) {
                    for ($i = 0; $i < $c; $i++) {
                        preg_match_all($this->getConfig("pattern.info")[1], $matches[2][$i], $info);
                        $result[$matches[1][$i]] = @array_combine($info[1], $info[2]);

                        foreach (self::AMAZON_IGNORE_INFO as $ignore) {
                            if (array_key_exists($ignore, $result[$matches[1][$i]])) {
                                unset($result[$matches[1][$i]][$ignore]);
                            }
                        }
                    }
                }
                break;
            default:
                $result = @$matches[1][0];
        }
//if ($part === 'info') {
//    dump($matches);exit;
//}
        return $result;
    }
}
