<?php
namespace application\models;

use easymvc\base\Model;

class EventsModel extends Model {
  public function __construct()
  {
    parent::__construct();
    $this->_table = 'events';
  }
  function get() {
    // $query = "SELECT `id`, `title`, `content`, `status`, `date`, `location`, `banner` FROM {$this->_table}";
    $query = "SELECT `id`, `title`, `status`, `date`, `location` FROM {$this->_table}";
    $stmt = $this->_db->query($query);
    return json_encode($stmt->fetchAll());
  }
}