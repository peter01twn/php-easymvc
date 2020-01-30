<?php
namespace easymvc\base;
use easymvc\base\Db;
// use easymvc\base\View;
class Controller {
  protected $_controller;
  protected $_action;
  // protected $_view;
  protected $_model;

  public function __construct($controller, $action)
  {
    $this->_controller = $controller;
    $this->_action = $action;
    // $this->_view = new View($controller, $action);
  }

  // public function assign($name, $value) {
  //   $this->_view->assign($name, $value);
  // }

  public function render() {
    header("Location: /{$this->_controller}.html");
  }
}