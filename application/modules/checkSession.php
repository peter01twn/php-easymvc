<?php
function checkSession() {
  if (!isset($_SESSION['username'])) {
    $msg = [
      'success' => false,
      'msg' => 'you are not login'
    ];
    echo json_encode($msg);
    exit();
  }
}