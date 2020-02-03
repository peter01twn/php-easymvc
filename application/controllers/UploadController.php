<?php
use easymvc\base\Controller;
require_once(MODULES_PATH . 'checkMethod.php');

class UploadController extends Controller {
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