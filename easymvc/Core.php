<?php
/**
 * FastPHP核心框架
 */
class Core
{
  // 執行程式
  function run()
  {
    spl_autoload_register(array($this, 'loadClass'));
    $this->setReporting();
    $this->removeMagicQuotes();
    $this->unregisterGlobals();
    $this->Route();
  }
  // 路由處理
  function Route()
  {
    require(APP_PATH . 'easymvc/Route.php');
  }
  // 檢測開發環境
  function setReporting()
  {
    if (APP_DEBUG === true) {
      error_reporting(E_ALL);
      ini_set('display_errors', 'On');
    } else {
      error_reporting(E_ALL);
      ini_set('display_errors', 'Off');
      ini_set('log_errors', 'On');
      ini_set('error_log', RUNTIME_PATH . 'logs/error.log');
    }
  }
  // 刪除敏感字元
  function stripSlashesDeep($value)
  {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
  }
  // 檢測敏感字元並刪除
  function removeMagicQuotes()
  {
    if (get_magic_quotes_gpc()) {
      $_GET = $this->stripSlashesDeep($_GET);
      $_POST = $this->stripSlashesDeep($_POST);
      $_COOKIE = $this->stripSlashesDeep($_COOKIE);
      $_SESSION = $this->stripSlashesDeep($_SESSION);
    }
  }
  // 檢測自定義全域性變數（register globals）並移除
  function unregisterGlobals()
  {
    if (ini_get('register_globals')) {
      $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
      foreach ($array as $value) {
        foreach ($GLOBALS[$value] as $key => $var) {
          if ($var === $GLOBALS[$key]) {
            unset($GLOBALS[$key]);
          }
        }
      }
    }
  }
  // 自動載入
  static function loadClass($class)
  {
    $frameworks = APP_PATH . $class . '.php';
    $controllers = APP_PATH . 'application/controllers/' . $class . '.php';
    $models = APP_PATH . 'application/models/' . $class . '.php';
    $modules = MODULES_PATH . $class . '.php';
    // echo $class;
    // echo "<br>";
    if (file_exists($frameworks)) {
      // 載入框架核心類
      include $frameworks;
    } elseif (file_exists($controllers)) {
      // 載入應用控制器類
      include $controllers;
    } elseif (file_exists($models)) {
      //載入應用模型類
      include $models;
    } elseif (file_exists($modules)) {
      //載入模組
      include $modules;
    } else {
      /* 錯誤程式碼 */
      echo "module not found : ";
      echo $class;
      exit();
    }
  }
}
