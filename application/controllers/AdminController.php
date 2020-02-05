<?php

use easymvc\base\Controller;
use application\models\AdminModel;

class AdminController extends Controller
{
  function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->_model = new AdminModel();
  }
  function login()
  {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
      $this->_errMsg['msg'] = 'please enter correct info';
      echo json_encode($this->_errMsg);
      exit();
    }
    $account = $this->_model->login($_POST['username'], $_POST['password']);
    if ($account) {
      $_SESSION['username'] = $account['username'];
      $_SESSION['id'] = $account['id'];
      echo $this->msgJson();
    } else {
      echo $this->errMsgJson();
    }
  }
  function logout()
  {
    session_destroy();
    echo $this->msgJson();
  }
};
