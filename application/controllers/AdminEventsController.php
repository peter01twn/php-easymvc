<?php

use easymvc\base\Controller;
use application\models\AdminEventsModel;

class AdminEventsController extends Controller
{
  function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->_model = new AdminEventsModel();
  }
  public function get()
  {
    $data = $this->_model->get();
    $this->_msg['data'] = $data;
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
    if ($this->_model->post($insert_values)) {
      echo $this->msgJson();
    } else {
      echo $this->errMsgJson();
    }
  }
  public function delete()
  {
    $id = json_decode(file_get_contents('php://input'));
    if ($this->_model->delete($id)) {
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
    if ($this->_model->put($insert_values)) {
      echo $this->msgJson();
    } else {
      echo $this->errMsgJson();
    }
  }
}
