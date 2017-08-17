<?php
/**
 * 网站信息
 */
const SITE = 'お兄ちゃんの萌屋';

/**
 * Amazon信息
 */
const AMAZON_HOME_PAGE = 'https://www.amazon.co.jp/';
const AMAZON_PRODUCT_PAGE_1 = 'https://www.amazon.co.jp/dp/';
const AMAZON_PRODUCT_PAGE_2 = '/ref=twister_dp_update?_encoding=UTF8&psc=1';

/**
 * 机器人接口
 */
define('BOT_PROTOCOL', 'http');
define('BOT_IP', 'localhost');
define('BOT_PORT', 5000);
define('BOT_CART', BOT_PROTOCOL.'://'.BOT_IP.':'.BOT_PORT.'/cart');
define('BOT_CHECKOUT', BOT_PROTOCOL.'://'.BOT_IP.':'.BOT_PORT.'/checkout');

/**
 * Session信息
 */
define('SESSION_FLASH_SUCCESS', 'Flash.Success');
define('SESSION_FLASH_ERROR', 'Flash.Error');
define('SESSION_LOGIN', 'Auth.User');
define('SESSION_DEFAULT', 'Default');
define('SESSION_VARS', 'ViewVars');
// 重定向请求页面
define('SESSION_FROM', 'From');
define('SESSION_FROM_ORDER', 'From.Order');

/**
 * 常量设定
 */
define('REDIRECT_COUNTER', 5);  // 跳转页面前倒数秒数