<?php
use application\models\EventsModel;
use easymvc\base\Controller;

class EventsController extends Controller
{
  public function get() {
    $model = new EventsModel();
    $data = $model->get();
    echo $data;
  }
  public function add() {

  }
  public function delete() {

  }
  public function update() {

  }
}
