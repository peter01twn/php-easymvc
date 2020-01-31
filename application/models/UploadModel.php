<?php

namespace application\models;

class UploadModel
{
  protected $tempPath;
  function __construct()
  {
    $this->tempPath = STATIC_PATH . 'temp/';
  }
  function temp($fileName, $stmt)
  {
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $newName = uniqid() . '.' . $ext;
    move_uploaded_file($stmt, $this->tempPath . $newName);
    return $newName;
  }
}
