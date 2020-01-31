<?php
namespace easymvc\base;

class Controller {
  protected $_controller;
  protected $_action;
  protected $_model;
  protected $_msg;
  protected $_erMsg;
  public function __construct($controller, $action)
  {
    $this->_controller = $controller;
    $this->_action = $action;
    $this->_msg = [
      'success' => true
    ];
    $this->_errMsg = [
      'success' => false
    ];
  }
}