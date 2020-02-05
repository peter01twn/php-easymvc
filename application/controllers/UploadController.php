<?php
use easymvc\base\Controller;
use application\models\UploadModel;

class UploadController extends Controller {
  function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->_model = new UploadModel();
  }
  function uploadTemp() {
    if ($_FILES['upload']['error'] === 0) {
      $fileName = $_FILES['upload']['name'];
      $tmp = $_FILES['upload']['tmp_name'];
      $imgUrl = $this->_model->uploadTemp($fileName, $tmp);
      if ($imgUrl) {
        $this->_msg['url'] = $imgUrl;
        echo $this->msgJson();
      }
    } else {
      echo $this->errMsgJson();
    }
  }
  function show() {
    echo 'show';
  }
}