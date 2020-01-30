<?php
function route()
{
  session_start();
  $controllerName = 'index';
  $action = 'render';
  if (!empty($_GET['url'])) {
    $url = $_GET['url'];
    $urlArray = explode('/', $url);
    $spotRe = '/\./';
    if (preg_match($spotRe, $url)) {
      $staticUrl = APP_PATH . 'static/' . $url;
      $adminRe = '/^admin/';
      if (preg_match($adminRe, $url) && !preg_match('/login\.html$/', $url)) {
        if (!isset($_SESSION['username'])) {
          $staticUrl = APP_PATH . '/static/admin/login.html';
          header("Location: /admin/login.html");
          exit();
        }
      }
      $html = '/\.html$/';
      if (preg_match($html, $url)) {
        if (file_exists($staticUrl)) {
          include_once($staticUrl);
        } else {
          include_once(APP_PATH . 'static/404.html');
        }
      } else {
        if (file_exists($staticUrl)) {
          header("Content-Type: " . explode(',', getallheaders()['Accept'])[0]);
          include_once($staticUrl);
        }
      }
      exit();
    }
    // 獲取控制器名
    $controllerName = ucfirst($urlArray[0]);
    // 獲取動作名
    array_shift($urlArray);
    $action = empty($urlArray[0]) ? 'render' : $urlArray[0];
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
    // exit($controller . "->" . $action . " doesn't exist");
    $msg = [
      'success' => false,
      'code' => '404'
    ];
    echo json_encode($msg);
  }
}
