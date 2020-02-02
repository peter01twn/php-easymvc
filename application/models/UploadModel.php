<?php

namespace application\models;

class imgHandler
{
  protected $tempPath;
  function __construct()
  {
    $this->tempPath = STATIC_PATH . 'temp/';
    $this->storePath = STATIC_PATH . 'images/';
  }
  function uploadTemp($fileName, $stmt)
  {
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $newName = uniqid() . '.' . $ext;
    move_uploaded_file($stmt, $this->tempPath . $newName);
    return $newName;
  }
}
