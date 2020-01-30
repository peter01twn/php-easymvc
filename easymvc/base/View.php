<?php
namespace easymvc\base;
class View
{
  // protected $variables = array();
  protected $_controller;
  protected $_action;

  function __construct($controller, $action)
  {
    $this->_controller = $controller;
    $this->_action = $action;
  }

  // function assign($name, $value)
  // {
  //   $this->variables[$name] = $value;
  // }

  function render()
  {
    extract($this->variables);
    $defaultHeader = APP_PATH . 'application/views/header.php';
    $defaultFooter = APP_PATH . 'application/views/footer.php';
    $controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
    $controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';
    if (is_file($controllerHeader)) {
      include($controllerHeader);
    } else {
      include($defaultHeader);
    }
    if (is_file($controllerFooter)) {
      include($controllerFooter);
    } else {
      include($defaultFooter);
    }
    if (is_file($controllerFooter)) {
      include($controllerFooter);
    } else {
      include($defaultFooter);
    }
  }
}
