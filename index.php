<?php
// 應用目錄為當前目錄
define('ROOT_PATH', __DIR__.'/');
// 開啟除錯模式
define('APP_DEBUG', true);
// 網站根URL
define('ROOT_URL', 'http://api.com/');
define('PUBLIC_URL', ROOT_URL . 'public/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('MODULES_PATH', ROOT_PATH . 'modules/');
define('REQUEST_METHOD', $_SERVER[ 'REQUEST_METHOD' ]);
// 載入框架
require './easymvc/easyMVC.php';
