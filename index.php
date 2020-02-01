<?php
// 應用目錄為當前目錄
define('APP_PATH', __DIR__.'/');
// 開啟除錯模式
define('APP_DEBUG', true);
// 網站根URL
define('APP_URL', 'http://localhost/framework');
define('VIEW_PATH', __DIR__ . '/application/views/');
define('STATIC_PATH', __DIR__ . '/static/');
define('MODULES_PATH', __DIR__ . '/modules/');
// 載入框架
require './easymvc/easyMVC.php';
