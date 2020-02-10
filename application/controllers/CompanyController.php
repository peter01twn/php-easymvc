<?php

use easymvc\base\Controller;

class CompanyController extends Controller {
  function login() {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
      $this->errMsg['msg'] = 'please enter correct info';
      echo json_encode($this->errMsg);
      exit();
    }
    $account = $this->model->login($_POST['username'], $_POST['password']);
    if ($account) {
      $_SESSION['username'] = $account['username'];
      $_SESSION['id'] = $account['id'];
      echo $this->msgJson();
    } else {
      echo $this->errMsgJson();
    }
  }
}
