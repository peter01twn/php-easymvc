<?php

namespace easymvc\base;

class Route
{
  protected $_routerTree;
  function __construct()
  {
    $this->_routerTree = [];
  }
  function callFunc($param1, $param2 = [], $ary = [])
  {
    if (!isset($param1)) {
      return;
    }
    if (is_array($param2)) {
      call_user_func_array($param1, $param2);
    } else {
      call_user_func_array(array($param1, $param2), $ary = []);
    }
  }
  function setTree($tree)
  {
    $this->_routerTree = $tree;
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
    if (!isset($_SESSION['username'])) {
      $controllerName = 'admin';
    }
    // 資料為空的處理
    $queryString = empty($queryString) ? array() : $queryString;
    // 例項化控制器
    $controller = $controllerName . 'Controller';
    $dispatch = new $controller($controllerName, $action);
    // 如果控制器和動作存在，這呼叫並傳入URL引數
    if ((int) method_exists($controller, $action)) {
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
$middlewar = [
  'middlewar' => [
    ['checkSession'],
    ['transform', 'move', ['temp', 'images']]
  ],
  'url' => ['products', 'events']
];
echo $_routerTree['middlewar']('name/', '2');
