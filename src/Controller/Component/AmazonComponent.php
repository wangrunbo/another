<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;
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
    protected $_defaultConfig = [];

    /**
     * Amazon Element Pattern
     *
     * @var array
     */
    protected $_pattern = [
        '404' => '{<title>404 - ドキュメントが見つかりません。</title>}',
        'name' => '{<h1 id="title" .*?<span id="productTitle" .*?>[\s\n]*(.*?)[\s\n]*</span>.*?</h1>}s',
        'price' => [
            '{<span id="priceblock_ourprice" class="a-size-medium a-color-price">￥ (\d+,?[0-9,]+)</span>}',
            '{<div id="buybox".*?<span class=".*?offer-price.*?">￥ (\d+,?[0-9,]+)</span>}s'
        ],
        'standard' => '{<div id="twisterContainer".*?<form id="twister".*?<div class="a-row">[\s\n]*?<label>[\s\n]*(.+?)[\s\n]*?</label>[\s\n]*?<span class="selection">[\s\n]*(.+?)[\s\n]*?</span>[\s\n]*?</div>}s',
        'product_type' => [
            'add-on' => '{<div id="addOnItem_feature_div".*?<i class="a-icon a-icon-addon">あわせ買い対象商品</i>}s',
            'pre-sell' => '{<input id="add-to-cart-button".*?value="予約注文する".*?>}s'
        ],
        'sale_start_date' => '{<div id="availability".*?<span.*?>[\s\n]*発売予定日は(\d+年\d+月\d+日)です。[\s\n]*?</span>(?=[\s\n]*?<span.*?在庫状況</a>について</span>)}s',
        'image' => '{<div id="main-image-container"(?:.|\n)*?<li class=".*?itemNo0.*?selected.*?"(?:.|\n)*?<div id="imgTagWrapperId"(?:.|\n)*?<img .*? src="(.*?)" .*?>}',
        'stock' => '{<div id="availability".*?<span.*?>[\s\n]*(.+?)[\s\n]*?</span>(?=[\s\n]*?<span.*?在庫状況</a>について</span>)}s',
        'description' => '{<div id="productDescription".*?<p>(.*?)[\n\t\s]*?</p>}s',
        'images' => [
            [
                'container' => '{<script type="text/javascript">.*?P\.when\(\'A\'\)\.register\("ImageBlockATF", function\(A\)\{[\s\n]*var data = \{[\s\n]*\'colorImages\': \{ \'initial\': \[(.*?)\]\},[\s\n]*\'colorToAsin\'.*?</script>}s',
                'hiRes' => '/"hiRes":"?(.*?|null)"?(?=,(?=".*?":)|})/',
                'thumb' => '/"thumb":"?(.*?|null)"?(?=,(?=".*?":)|})/',
                'large' => '/"large":"?(.*?|null)"?(?=,(?=".*?":)|})/',
                'main' => '/"main":({.*?}|null)(?=,(?=".*?":)|})/',
                'pixels' => '/(?<={|,)"(.*?)":(\[\d+,\d+\])(?=,(?=".*?":)|})/'
            ],
            [
                'container' => '{<script type="text/javascript">.*?P\.when\(\'A\'\)\.register\("ImageBlockATF", function\(A\)\{.*?var data = \{.*?\'imageGalleryData\' : \[(.*?)\],[\s\n]*\'centerColMargin\'.*?</script>}s',
                'main' => '/"mainUrl":"?(.*?|null)"?(?=,(?=".*?":)|})/',
                'thumb' => '/"thumbUrl":"?(.*?|null)"?(?=,(?=".*?":)|})/'
            ]
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
        $curl = $this->_curl($asin);
        $http_code = $curl['http_code'];
        $html = $curl['html'];

        // 404 Not Found
        if ($http_code !== 200 || !$html || preg_match($this->_pattern['404'], $html)) {
            return null;
        }

        $product_data = [
            'asin' => $asin,  // ASIN CODE
            'name' => $this->_extract($html, 'name'),  // 商品名
            'price' => $this->_extract($html, 'price'),  // 商品价格
            'standard' => $this->_extract($html, 'standard'),  // 商品规格
            'product_type_id' => $this->_extract($html, 'product_type'), // 商品类型
            'sale_start_date' => $this->_extract($html, 'sale_start_date'), // 开始贩卖日
            'stock_flg' => !in_array($this->_extract($html, 'stock'), self::AMAZON_PRODUCT_SOLD_OUT),  // 是否在库
            'description' => $this->_extract($html, 'description'),  // 商品介绍
        ];

        // 商品图像
        $product_data['product_images'] = [];
        $src = $this->_extract($html, 'images');
        for ($i = 0; $i < count($src['main']); $i++) {
            $product_image_data = [
                'main' => $src['main'][$i] === 'null'? null : $src['main'][$i],
                'sub' => $src['sub'][$i] === 'null'? null : $src['sub'][$i]
            ];

            $product_data['product_images'][] = $this->Data->completion($product_image_data, ['table' => 'ProductImages']);
        }

        // 商品情报
        $product_data['product_info'] = [];
        $ProductInfoTypesTable = TableRegistry::get('ProductInfoTypes');
        foreach ($this->_extract($html, 'info') as $type => $info) {
            $product_info_type = $ProductInfoTypesTable->find('active')->where(['name' => $type])->first();
            if (is_null($product_info_type)) {
                $product_info_type = $ProductInfoTypesTable->newEntity(['name' => $type]);
                $this->Data->completion($product_info_type);

                $ProductInfoTypesTable->save($product_info_type);
            }

            foreach ($info as $label => $content) {
                $product_info_data = [
                    'label' => $label,
                    'content' => $content,
                    'product_info_type_id' => $product_info_type->id
                ];

                $product_data['product_info'][] = $this->Data->completion($product_info_data, ['table' => 'ProductInfo']);
            }
        }

        $product = TableRegistry::get('Products')->newEntity($product_data, ['validate' => 'curl']);
        $this->Data->completion($product);

        return $product;
    }

    /**
     * 自动操作
     * @param $url
     * @param $data
     * @return mixed
     */
    public function bot($url, $data = null)
    {
        $ch = curl_init($url);

        if (!is_null($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);

        try {
            set_time_limit(0);
            $response = json_decode(curl_exec($ch), true);
        } catch (\Cake\Error\FatalErrorException $e) {
            $response = false;
        } finally {
            curl_close($ch);
        }

        return $response;
    }

    /**
     * 使用ASIN CODE抓取Amazon商品页面
     *
     * @param string|array $asins
     * @return array
     */
    protected function _curl($asins)
    {
        $curl = [];
        $result = [];

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

        try {
            $active = null;
            do {
                curl_multi_exec($mh, $active);
            } while ($active);

            foreach ($curl as $asin => $ch) {
                try {
                    if (is_array($asins)) {
                        $result[$asin] = [
                            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
                            'html' => curl_multi_getcontent($ch)
                        ];
                    } else {
                        $result = [
                            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
                            'html' => curl_multi_getcontent($ch)
                        ];
                    }
                } finally {
                    curl_multi_remove_handle($mh, $ch);
                    curl_close($ch);
                }
            }
        } finally {
            curl_multi_close($mh);
        }

        return $result;
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
            case 'name':
                preg_match_all($this->_pattern[$part], $html, $matches);

                $result = html_entity_decode(@$matches[1][0]);

                break;
            case 'price':
                $matches = null;
                foreach ($this->_pattern['price'] as $format => $pattern) {
                    if (preg_match_all($pattern, $html, $matches)) {
                        break;
                    }
                }

                $result = @$matches[1][0];
                if (!is_null($result)) {
                    $result = (int)preg_replace('/,/', '', $result);
                }

                break;
            case 'standard':
                preg_match_all($this->_pattern['standard'], $html, $matches);

                if (empty($matches[0])) {
                    $result = null;
                } else {
                    $result = @"{$matches[1][0]} {$matches[2][0]}";
                }

                break;
            case 'product_type':
                if (preg_match($this->_pattern['product_type']['add-on'], $html)) {
                    $result = \App\Model\Entity\ProductType::ADD_ON;
                } elseif (preg_match($this->_pattern['product_type']['pre-sell'], $html)) {
                    $result = \App\Model\Entity\ProductType::PRE_SELL;
                } else {
                    $result = \App\Model\Entity\ProductType::NORMAL;
                }

                break;
            case 'sale_start_date':
                preg_match_all($this->_pattern['sale_start_date'], $html, $matches);

                if (empty($matches[1])) {
                    $result = null;
                } else {
                    $result = Time::createFromFormat('Y年m月d日', $matches[1][0])->setTime(0, 0, 0);
                }

                break;
            case 'images':
                $main = null;
                $sub = null;
                foreach ($this->_pattern['images'] as $index => $pattern) {
                    if (preg_match_all($pattern['container'], $html, $container)) {
                        switch ($index) {
                            case 1:
                                preg_match_all($pattern['main'], @$container[1][0], $main);
                                preg_match_all($pattern['thumb'], @$container[1][0], $sub);
                                break;
                            case 0:
                            default:
                                preg_match_all($pattern['large'], @$container[1][0], $main);
                                preg_match_all($pattern['thumb'], @$container[1][0], $sub);
                        }

                        break;
                    }
                }

                if (count($main[1]) === count($sub[1])) {
                    $result = [
                        'main' => $main[1],
                        'sub' => $sub[1]
                    ];
                } else {
                    $result = [
                        'main' => [],
                        'sub' => []
                    ];
                }

                break;
            case 'info':
                $result = [];
                for ($index = 0; $index < count($this->_pattern['info']['container']); $index++) {
                    $match = preg_match($this->_pattern['info']['container'][$index], $html, $container);
                    if ($match) {
                        $match = preg_match_all($this->_pattern['info']['section'][$index], $container[0], $sections);
                        for ($i = 0; $i < $match; $i++) {
                            preg_match_all($this->_pattern['info']['detail'][$index], $sections[2][$i], $info);
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
                preg_match_all($this->_pattern[$part], $html, $matches);

                $result = @$matches[1][0];
        }

        return $result;
    }
}
