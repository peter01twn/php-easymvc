<?php
namespace easymvc\base;

class Controller {
  protected $model;
  protected $msg;
  protected $errMsg;
  public function __construct()
  {
    $class = get_class($this);
    $modelName = substr($class, 0, -10) . 'Model';
    if (file_exists(ROOT_PATH . 'application/models/' . $modelName . '.php')) {
      echo $modelName;
      $this->model = new $modelName();
    }
    $this->msg = [
      'success' => true
    ];
    $this->errMsg = [
      'success' => false
    ];
  }
  function msgJson() {
    return json_encode($this->msg);
  }
  function errMsgJson() {
    return json_encode($this->errMsg);
  }
}