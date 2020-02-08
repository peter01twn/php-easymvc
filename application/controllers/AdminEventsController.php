<?php

use easymvc\base\Controller;

class AdminEventsController extends Controller
{
  public function get()
  {
    $data = $this->model->get();
    $this->msg['data'] = $data;
    echo $this->msgJson();
  }
  public function post()
  {
    $banner = '';
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] === 0) {
      $banner = [
        'name' => $_FILES['banner']['name'],
        'tmp' => $_FILES['banner']['tmp_name']
      ];
    }
    $insert_values = [
      'cid' => isset($_SESSION['cid']) ? $_SESSION['cid'] : 1,
      'title' => isset($_POST['title']) ? $_POST['title'] : '',
      'content' => isset($_POST['content']) ? $_POST['content'] : '',
      'location' => isset($_POST['location']) ? $_POST['location'] : '',
      'date' => isset($_POST['date']) ? $_POST['date'] : '',
      'banner' => $banner
    ];
    if ($this->model->post($insert_values)) {
      echo $this->msgJson();
    } else {
      echo $this->errMsgJson();
    }
  }
  public function delete()
  {
    $id = json_decode(file_get_contents('php://input'));
    if ($this->model->delete($id)) {
      echo $this->msgJson();
    }
  }
  public function put()
  {
    if (!isset($_POST['id'])) {
      $this->errMsg['msg'] = 'id not set';
      echo $this->errMsgJson();
    }
    $banner = '';
    $insert_values = [
      'id' => $_POST['id'],
      'title' => isset($_POST['title']) ? $_POST['title'] : '',
      'content' => isset($_POST['content']) ? $_POST['content'] : '',
      'location' => isset($_POST['location']) ? $_POST['location'] : '',
      'date' => isset($_POST['date']) ? $_POST['date'] : ''
    ];
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] === 0) {
      $banner = [
        'name' => $_FILES['banner']['name'],
        'tmp' => $_FILES['banner']['tmp_name']
      ];
      $insert_values['banner'] = $banner;
    }
    if ($this->model->put($insert_values)) {
      echo $this->msgJson();
    } else {
      echo $this->errMsgJson();
    }
  }
}
