<?php
// namespace application\models;

use easymvc\base\Model;

class AdminModel extends Model {
  function login($username, $password) {
    // $password = sha1($password);
    $query = "SELECT `id`, `username` FROM {$this->_table} WHERE `username` = ? AND `password` = ?";
    $stmt = $this->_db->prepare($query);
    $stmt->execute([$username, $password]);
    if ($stmt->rowCount() > 0) {
      return $stmt->fetch();
    } else {
      return false;
    }
  }
}