<?php
// 應用目錄為當前目錄
define('ROOT_PATH', __DIR__.'/');
// 開啟除錯模式
define('APP_DEBUG', true);
// 網站根URL
define('ROOT_URL', 'http://api.com');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('MODULES_PATH', ROOT_PATH . 'application/modules/');
define('IMAGES_PATH', PUBLIC_PATH . 'events/images/');
define('TEMP_PATH', PUBLIC_PATH . 'events/temp/');
// 載入框架
require './easymvc/easyMVC.php';
