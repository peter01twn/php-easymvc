<?php
namespace easymvc\base;

class Controller {
  protected $_controller;
  protected $_action;
  protected $_model;
  protected $_msg;
  protected $_errMsg;
  public function __construct($controller, $action, $model)
  {
    $this->_controller = $controller;
    $this->_action = $action;
    $this->_model = $model;
    $this->_msg = [
      'success' => true
    ];
    $this->_errMsg = [
      'success' => false
    ];
  }
  function msgJson() {
    return json_encode($this->_msg);
  }
  function errMsgJson() {
    return json_encode($this->_errMsg);
  }
}