<?php
use easymvc\base\Controller;
use application\models\AdminModel;

class AdminController extends Controller {
  protected $_model;
  function __construct()
  {
    $this->_model = new AdminModel();
  }
  function login() {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
      echo '請輸入正確資料';
      exit();
    }
    $username = $this->_model->login($_POST['username'], $_POST['password']);
    if ($username) {
      session_start();
      $_SESSION['username'] = 'username';
      header('Location: /admin/events.html');
    } else {
      $msg = [
        'success' => false
      ];
      echo json_encode($msg);
    }
  }
  function logout() {
    session_start();
    session_destroy();
    header('Location: /admin/login.html');
  }
  function render()
  {
    session_start();
    if (!isset($_SESSION['username'])) {
      header('Location: /admin/login.html');
    } else {
      header('Location: /admin/events.html');
    }
    exit();
  }
};