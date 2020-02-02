<?php

use application\models\EventsModel;
use easymvc\base\Controller;

class EventsController extends Controller
{
  public function get()
  {
    $model = new EventsModel();
    $data = $model->get();
    echo $data;
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
      'cid' => $_SESSION['cid'],
      'title' => isset($_POST['title']) ? $_POST['title'] : '',
      'content' => isset($_POST['content']) ? $_POST['content'] : '',
      'location' => isset($_POST['location']) ? $_POST['location'] : '',
      'date' => isset($_POST['date']) ? $_POST['date'] : '',
      'banner' => $banner
    ];
    $model = new EventsModel();
    if ($model->post($insert_values)) {
      echo json_encode($this->msg);
    } else {
      echo json_encode($this->errMsg);
    }
  }
  public function delete()
  {
    $req = json_decode(file_get_contents('php://input'));
    $deleteId = is_array($req) ? $req : [$req];
    $model = new EventsModel();
    if ($model->delete($deleteId)) {
      echo json_encode($this->msg);
    }
  }
  public function put()
  {
    if (!isset($_POST['id'])) {
      $this->errMsg['msg'] = 'id not set';
      echo json_encode($this->errMsg);
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
    $model = new EventsModel();
    if ($model->put($insert_values)) {
      echo json_encode($this->msg);
    } else {
      echo json_encode($this->errMsg);
    }
  }
}
