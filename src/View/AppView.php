<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    protected $_style;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
    }

    public function renderLayout($content, $layout = null)
    {
        $this->start('navi');
        switch ($this->request->getParam('controller')) {
            case 'Mypage':
                echo $this->element('Navi/mypage');
                break;
            default:
                echo '';
        }
        $this->end();

        return parent::renderLayout($content, $layout);
    }



    /**
     * @param $block
     * @param $css
     */
    public function setStyle($block, $css)
    {
        $style = &$this->_style;
        foreach (explode('.', $block) as $part) {
            $style[$part] = null;
            $style = &$style[$part];
        }

        $style = $css;
    }

    /**
     * @param null|string $block
     * @return mixed
     */
    public function getStyle($block = null)
    {
        $style = $this->_style;
        if (!is_null($block)) {
            foreach (explode('.', $block) as $part) {
                $style = $style[$part];
            }
        }

        return $style;
    }

    /**
     * @param null $title
     * @return string
     */
    public function title($title = null)
    {
        if (is_null($title)) {
            return $this->fetch('title');
        }

        $this->assign('title', $title);
    }

    /**
     * 补全输入框默认值
     *
     * @param array $default
     * @param array $data
     * @param array $options
     */
    public function patchDefault(&$default, $data, $options = [])
    {
        if (isset($options['ignore'])) {
            foreach ((array)$options['ignore'] as $key) {
                unset($data[$key]);
            }
        }

        $default += $data;
    }
}
