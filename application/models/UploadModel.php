<?php

class UploadModel
{
  protected $tempPath;
  function uploadTemp($fileName, $stmt)
  {
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $newName = uniqid() . '.' . $ext;
    $newPath = PUBLIC_PATH . 'events/temp/' . $newName;
    move_uploaded_file($stmt, $newPath);
    $imgUrl = PUBLIC_URL . 'events/temp/' . $newName;
    return $imgUrl;
  }
}
