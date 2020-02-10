<?php
use easymvc\base\Model;

class CompanyModel extends Model {
  function login($username, $password) {
    $this->table = 'admin';
    // $password = sha1($password);
    $query = "SELECT `id`, `username` FROM {$this->table} WHERE `username` = ? AND `password` = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$username, $password]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch();
    } else {
      return false;
    }
  }
}