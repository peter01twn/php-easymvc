<?php

namespace application\models;

use easymvc\base\Model;

include MODULES_PATH . 'matchPaths.php';

define('IMAGES_PATH', STATIC_PATH . 'events/images');
define('TEMP_PATH', STATIC_PATH . 'events/temp');

class EventsModel extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->_table = 'events';
  }

  protected function moveImages($str)
  {
    $imgPaths = matchPaths($_POST['content']);
    foreach ($imgPaths as $path) {
      $basename = basename($path);
      if (file_exists(TEMP_PATH . $basename)) {
        rename(TEMP_PATH . $basename, IMAGES_PATH . $basename);
        $str = str_replace($path, IMAGES_PATH . $basename, $str);
      }
    }
    return $str;
  }

  function get()
  {
    $query = "SELECT `id`, `title`, `status`, `date`, `location` FROM {$this->_table}";
    $stmt = $this->_db->query($query);
    return json_encode($stmt->fetchAll());
  }

  function delete($id)
  {
    $query_getImg = "select `banner`, `content` from `events` where `id` = ?";
    $getImg_stmt = $this->_db->prepare($query_getImg);
    $getImg_stmt->execute($id);
    $fetchdata = $getImg_stmt->fetch();
    $imgPaths = matchPaths($fetchdata['content']);
    $imgPaths[] = $fetchdata['banner'];
    foreach ($imgPaths as $path) {
      $fileName = basename($path);
      $path = IMAGES_PATH . $fileName;
      @unlink($path);
    }

    $query_del = 'DELETE FROM `events` WHERE `id` = ?';
    $del_stmt = $this->_db->prepare($query_del);
    $del_stmt->execute($id);

    return true;
  }

  function post($values)
  {
    $values['content'] = $this->moveImages($values['content']);
    if (!empty($values['banner'])) {
      $ext = pathinfo($values['banner']['name'], PATHINFO_EXTENSION);
      $name = uniqid() . '/' . $ext;
      move_uploaded_file($values['banner']['tmp'] , $name);
      $values['banner'] = $name;
    }
    $valsAry = [];
    foreach ($values as $key => $val) {
      $valsAry[] = $val;
    }
    $query_insert = "insert into `events` ('cid', 'title', 'content', 'location', 'date', 'banner') values (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $this->_db->prepare($query_insert);
    $insert_stmt->execute($valsAry);
    if ($insert_stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  function put($values)
  {
    $values['content'] = $this->moveImages($values['content']);
    $newImgs = matchPaths($values['content']);

    $query_getImg = "select `banner`, `content` from `events` where `id` = ?";
    $getImg_stmt = $this->_db->prepare($query_getImg);
    $getImg_stmt->execute([$values['id']]);
    $fetchData = $getImg_stmt->fetch();
    $oldImgs = matchPaths($fetchData['content']);

    foreach ($oldImgs as $val) {
      if (!in_array($val, $newImgs)) {
        @unlink(IMAGES_PATH . basename($oldImgs));
      }
    }

    $query_update = "update `events` set 'title' = ?, 'content' = ?, 'location' = ?, 'date' = ? ";
    $valsAry = [$values['title'], $values['content'], $values['location'], $values['date']];
    if (!empty($values['banner'])) {
      $ext = pathinfo($values['banner']['name'], PATHINFO_EXTENSION);
      $name = uniqid() . '/' . $ext;
      move_uploaded_file($values['banner']['tmp'], IMAGES_PATH . $name);
      @unlink(TEMP_PATH . basename($fetchData['banner']));
      $query_update .= ", 'banner' = ? ";
      $valsAry[] = IMAGES_PATH . $name;
    }

    $valsAry[] = $values['id'];
    $query_update .= "where `id` = ?";
    $insert_stmt = $this->_db->prepare($query_update);
    $insert_stmt->execute($valsAry);
    if ($insert_stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
}
