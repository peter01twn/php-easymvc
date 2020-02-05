<?php
namespace easymvc\base;
use PDO;

class Model
{
  protected $_db;
  protected $_table;
  
  public function __construct()
  {
    // $this->_table = strtolower($table);
    $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $this->_db = new PDO($dsn, DB_USER, DB_PASSWORD, $option);
    // PDO 屬性設定
    $this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $this->_db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES {".DB_CHARSET."} COLLATE ".DB_COLLATE);
  }
}
