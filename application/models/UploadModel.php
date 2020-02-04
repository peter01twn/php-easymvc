<?php

// namespace application\models;

class UploadModel
{
  protected $tempPath;
  function uploadTemp($fileName, $stmt)
  {
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $newName = uniqid() . '.' . $ext;
    $newPath = TEMP_PATH . $newName;
    move_uploaded_file($stmt, $newPath);
    $imgUrl = 'api.com/public/events/temp/' . $newName;
    return $imgUrl;
  }
}
