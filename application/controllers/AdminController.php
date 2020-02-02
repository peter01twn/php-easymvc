<?php

use easymvc\base\Controller;
use application\models\AdminModel;

class AdminController extends Controller
{
  protected $_model;
  public function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->_model = new AdminModel();
  }
  function login()
  {
    $this->_errMsg['msg'] = 'please enter correct info';
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
      echo json_encode($this->_errMsg);
      exit();
    }
    $account = $this->_model->login($_POST['username'], $_POST['password']);
    if ($account) {
      $_SESSION['username'] = $account['username'];
      $_SESSION['cid'] = $account['id'];
      echo json_encode($this->_msg);
    } else {
      echo json_encode($this->_errMsg);
    }
  }
  function logout()
  {
    session_destroy();
    echo json_encode($this->_msg);
  }
};
