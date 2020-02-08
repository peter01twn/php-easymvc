<?php

namespace easymvc\base;

use PDO;

class Model
{
  protected $db;
  protected $table;

  public function __construct()
  {
    if (!$this->table) {
      $class = get_class($this);
      $class = substr($class, 0, -5);
      $this->table = strtolower($class);
    }

    $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $this->db = new PDO($dsn, DB_USER, DB_PASSWORD, $option);
    // PDO 屬性設定
    $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES {" . DB_CHARSET . "} COLLATE " . DB_COLLATE);
  }
}
