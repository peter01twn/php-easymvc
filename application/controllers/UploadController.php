<?php
use easymvc\base\Controller;
use application\models\imgHandler;
require_once(MODULES_PATH . 'checkMethod.php');

class UploadController extends Controller {
  function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->_model = new imgHandler();
  }
  function uploadTemp() {
    if ($_FILES['upload']['error'] === 0) {
      $fileName = $_FILES['upload']['name'];
      $tmp = $_FILES['upload']['tmp_name'];
      $newName = $this->_model->uploadTemp($fileName, $tmp);
      if ($newName) {
        $this->msg['url'] = 'api.com/static/temp/' . $newName;
        echo json_encode($this->msg);
      }
    }
  }
  function show() {
    echo 'show';
  }
}