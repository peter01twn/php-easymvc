<?php

namespace easymvc\base;

class Router
{
  protected $_middle;
  function __construct()
  {
    $this->_middle = [];
  }

  protected function middleHandler($controllerName) {
    foreach ($this->_middle as $obj) {
      $url = $obj['url'];
      $middlewars = $obj['middlewars'];
      if (in_array($controllerName, $url)) {
        foreach ($middlewars as $func) {
          if (is_array($func) && isset($func[0]) && isset($func[1])) {
            $func[1] = is_array($func[1]) ? $func[1] : [$func[1]];
            call_user_func_array($func[0], $func[1]);
          } else {
            call_user_func_array($func, []);
          }
        }
      }
    }
  }

  protected function parseUrl($url) {
    $controllerName = '';
    $action = '';
    if (!empty($url)) {
      $urlArray = explode('/', $url);
      $controllerName = ucfirst($urlArray[0]);
      // 獲取動作名
      array_shift($urlArray);
      $action = empty($urlArray[0]) ? '' : $urlArray[0];
      //獲取URL引數
      array_shift($urlArray);
      $queryString = empty($urlArray) ? array() : $urlArray;
    }
    // 資料為空的處理
    $queryString = empty($queryString) ? array() : $queryString;
    return [$controllerName, $action, $queryString];
  }

  function setMiddle($middle)
  {
    $this->_middle = $middle;
    return $this;
  }

  function run()
  {
    session_start();
    $url = isset($_GET['url']) ? $_GET['url'] : '';
    if (preg_match('/^static/', $url)) {
      if (file_exists($url)) {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        header('X-Sendfile:' . APP_PATH . $url);
        header("Content-Type: image/$ext");
      } else {
        echo 'file not found';
      }
      exit();
    }
    $parseAry = $this->parseUrl($url);
    $controllerName = $parseAry[0];
    $action = $parseAry[1];
    $queryString = $parseAry[2];

    $this->middleHandler($controllerName);

    // 例項化控制器
    $c = $controllerName . 'Controller';
    $m = $controllerName . 'Model';

    try {
      $model = new $m($controllerName);
      $controller = new $c($controllerName, $action, $model);
    } catch (\Throwable $th) {
      // echo $controllerName . ' not found';
      echo $th;
      exit();
    }
    // 如果控制器和動作存在，呼叫並傳入URL引數
    if ((int) method_exists($c, $action)) {
      call_user_func_array(array($controller, $action), $queryString);
    } else {
      exit($c . "->" . $action . " doesn't exist");
      // $msg = [
      //   'success' => false,
      //   'code' => '404'
      // ];
      // echo json_encode($msg);
    }
  }
}
