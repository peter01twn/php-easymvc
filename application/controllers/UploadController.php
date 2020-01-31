<?php
use easymvc\base\Controller;
use application\models\UploadModel;
require_once(MODULES_PATH . 'checkMethod.php');

class UploadController extends Controller {
  function __construct()
  {
    $this->_model = new UploadModel();
  }
  function temp() {
    if (!checkMethod('post')) {
      echo 'Not allow method';
      exit();
    }
    exit();
    if ($_FILES['upload']['error'] === 0) {
      $fileName = $_FILES['upload']['name'];
      $tmp = $_FILES['upload']['tmp_name'];
      $newName = $this->_model->temp($fileName, $tmp);
      if ($newName) {
        return '/static/tmep/' . $newName;
      }
    }
  }
  function show() {
    echo 'show';
  }
}