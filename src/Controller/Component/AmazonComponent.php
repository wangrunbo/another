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

    const AMAZON_PRODUCT_SOLD_OUT = ['在庫切れ。'];

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
            'name' => '{<title>Amazon \| (.+?) \|.*</title>}',
            'price' => '{<span id="priceblock_ourprice" class="a-size-medium a-color-price">￥ (\d+,?[0-9,]+)</span>}',
            'standard' => '{<div id="twisterContainer"(?:.|\n)*?<form id="twister"(?:.|\n)*?<div class="a-row">[\s\n]*<label>[\s\n]*(.+?)[\s\n]*</label>[\s\n]*<span class="selection">[\s\n]*(.+?)[\s\n]*</span>[\s\n]*</div>}',
            'image' => '{<div id="main-image-container"(?:.|\n)*?<li class=".*?itemNo0.*?selected.*?"(?:.|\n)*?<div id="imgTagWrapperId"(?:.|\n)*?<img .*? src="(.*?)" .*?>}',
            'stock' => '{<div id="availability"(?:.|\n)*?<span.*?>[\s\n]*(.+?)[\s\n]*</span>(?=[\s\n]*<span.*?在庫状況</a>について</span>)}',
//            'info' =>
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
        dump($html);exit;
        /** @var \App\Model\Entity\Product $product */
        $product = TableRegistry::get('Products')->newEntity();

        $product->asin = $asin;
        $product->name = $this->_extract($html, 'name');
        $product->price = $this->_extract($html, 'price');
        $product->standard = $this->_extract($html, 'standard');
        $product->product_type_id = 1; // TODO
        $product->sale_start_date = null; // TODO
        $product->stock_flg = !in_array($this->_extract($html, 'stock'), self::AMAZON_PRODUCT_SOLD_OUT);
        $product->description = '';  // TODO

        $product->product_images = []; //TODO
        $product->product_info = [];  // TODO

        $this->Data->completion($product);

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
     * @return mixed
     */
    protected function _extract($html, $part)
    {
        preg_match_all($this->getConfig("pattern.{$part}"), $html, $matches);

        switch ($part) {
            case 'price':
                $result = @$matches[1][0];
                if (!is_null($result)) {
                    $result = (int)preg_replace('/,/', '', $result);
                }
                break;
            case 'standard':
                $result = @"{$matches[1][0]} {$matches[2][0]}";
                break;
            default:
                $result = @$matches[1][0];
        }
if ($part === 'description') {
    dump($matches);exit;
}
        return $result;
    }
}
