<?php

namespace easymvc\base;

class Router
{
  protected $_middle;
  function __construct()
  {
    $this->_middle = [];
  }
  function callFunc($funcAry)
  {
    if (!isset($funcAry[0])) {
      return;
    }
    if (isset($funcAry[1])) {
      if (isset($funcAry[2])) {
        $param = is_array($funcAry[2]) ? $funcAry[2] : [$funcAry[2]];
        $class = new $funcAry[0];
        call_user_func_array(array($class, $funcAry[1]), $param);
      } else {
        $param = is_array($funcAry[1]) ? $funcAry[1] : [$funcAry[1]];
        call_user_func_array($funcAry[0], $param);
      }
    } else {
      $funcAry[0]();
    }
  }
  function setMiddle($middle)
  {
    $this->_middle = $middle;
    return $this;
  }
  function run()
  {
    session_start();
    $controllerName = '';
    $action = '';
    if (!empty($_GET['url'])) {
      $url = $_GET['url'];
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
    // 例項化控制器
    $controller = $controllerName . 'Controller';
    $dispatch = new $controller($controllerName, $action);
    // 如果控制器和動作存在，這呼叫並傳入URL引數
    if ((int) method_exists($controller, $action)) {
      foreach ($this->_middle as $obj) {
        $url = $obj['url'];
        $middlewars = $obj['middlewars'];
        if (in_array($controllerName, $url)) {
          foreach ($middlewars as $funcAry) {
            $this->callFunc($funcAry);
          }
        }
      }
      call_user_func_array(array($dispatch, $action), $queryString);
    } else {
      exit($controller . "->" . $action . " doesn't exist");
      // $msg = [
      //   'success' => false,
      //   'code' => '404'
      // ];
      // echo json_encode($msg);
    }
  }
}
