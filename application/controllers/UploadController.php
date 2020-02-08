<?php
use easymvc\base\Controller;

class UploadController extends Controller {
  function uploadTemp() {
    if ($_FILES['upload']['error'] === 0) {
      $fileName = $_FILES['upload']['name'];
      $tmp = $_FILES['upload']['tmp_name'];
      $imgUrl = $this->model->uploadTemp($fileName, $tmp);
      if ($imgUrl) {
        $this->msg['url'] = $imgUrl;
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