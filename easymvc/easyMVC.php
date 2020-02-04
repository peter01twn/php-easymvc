<?php
// 初始化常量
defined('FRAME_PATH') or define('FRAME_PATH', __DIR__.'/');
defined('ROOT_PATH') or define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('APP_DEBUG') or define('APP_DEBUG', false);
defined('CONFIG_PATH') or define('CONFIG_PATH', ROOT_PATH.'config/');
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH.'runtime/');
// 包含配置檔案
require ROOT_PATH . 'config/config.php';
// 包含核心框架類
require FRAME_PATH . 'Core.php';
// 例項化核心類
$easy = new Core();
$easy->run();