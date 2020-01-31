<?php
function checkMethod($methods) {
  $methods = strtoupper($methods);
  if ($methods === $_SERVER['REQUEST_METHOD']) {
    return true;
  } else {
    $msg = [
      'success' => false,
      'msg' => 'method not allow'
    ];
    echo json_encode($msg);
    exit();
  }
}