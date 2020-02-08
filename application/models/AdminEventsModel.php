<?php

use easymvc\base\Model;

class AdminEventsModel extends Model
{
  protected $table = 'events';
  protected $imgUrl = PUBLIC_URL . 'events/images/';
  protected $tempPath = PUBLIC_PATH . 'events/temp/';
  protected $storePath = PUBLIC_PATH . 'events/images/';
  protected function moveImages($str)
  {
    $imgPaths = $this->matchPaths($str);
    $imgPaths = $this->replacePath($this->tempPath, $imgPaths);
    $imgPaths = $this->moveFiles($this->storePath, $imgPaths);
    $imgPaths = $this->replacePath($this->imgUrl, $imgPaths);

    foreach ($imgPaths as $path) {
      $basename = basename($path);
      $str = str_replace($path, $this->imgUrl . $basename, $str);
    }
    return $str;
  }
  protected function moveFiles($to, $pathAry)
  {
    $newAry = [];
    foreach ($pathAry as $path) {
      if (file_exists($path)) {
        $basename = basename($path);
        $newPath = $to . $basename;
        rename($path, $newPath);
        $newAry[] = $newPath;
      }
    }
    return $newAry;
  }
  protected  function replacePath($to, $pathAry)
  {
    $newAry = [];
    foreach ($pathAry as $path) {
      $basename = basename($path);
      $newAry[] = str_replace($path, $to . $basename, $path);
    }
    return $newAry;
  }
  protected function matchPaths($str)
  {
    $re = '/<img src="(.+)">/mU';
    preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
    $imgPaths = [];
    foreach ($matches as $match) {
      $imgPaths[] = $match[1];
    }
    return $imgPaths;
  }

  protected function deleteFiles($pathAry) {
    foreach ($pathAry as $path) {
      $fileName = basename($path);
      $path = $this->storePath . $fileName;
      @unlink($path);
    }
  }

  function get()
  {
    $query = "SELECT `id`, `title`, `status`, `date`, `location`, `banner`, `content` FROM {$this->table}";
    $stmt = $this->db->query($query);
    $data = $stmt->fetchAll();
    foreach ($data as &$row) {
      $row['banner'] = $this->imgUrl . $row['banner'];
    }
    return $data;
  }

  function delete($id)
  {
    $deleteId = is_array($id) ? $id : [$id];

    $query_getImg = "select `banner`, `content` from {$this->table} where `id` = ?";
    $getImg_stmt = $this->db->prepare($query_getImg);
    $getImg_stmt->execute($deleteId);
    $fetchdata = $getImg_stmt->fetch();
    $imgPaths = $this->matchPaths($fetchdata['content']);
    $imgPaths[] = $fetchdata['banner'];
    $imgPaths = $this->replacePath($this->storePath, $imgPaths);
    $this->deleteFiles($imgPaths);

    $query_del = "DELETE FROM {$this->table} WHERE `id` = ?";
    $del_stmt = $this->db->prepare($query_del);
    $del_stmt->execute($deleteId);

    return true;
  }

  function post($values)
  {
    $values['content'] = $this->moveImages($values['content']);
    if (!empty($values['banner'])) {
      $ext = pathinfo($values['banner']['name'], PATHINFO_EXTENSION);
      $name = uniqid() . '.' . $ext;
      move_uploaded_file($values['banner']['tmp'], $this->storePath . $name);
      $values['banner'] = $name;
    }
    $valsAry = [];
    foreach ($values as $key => $val) {
      $valsAry[] = $val;
    }
    $query_insert = "insert into {$this->table} (`cid`, `title`, `content`, `location`, `date`, `banner`) values (?, ?, ?, ?, ?, ?)";

    $insert_stmt = $this->db->prepare($query_insert);
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
    $newImgs = $this->matchPaths($values['content']);

    $query_getImg = "select `banner`, `content` from {$this->table} where `id` = ?";
    $getImg_stmt = $this->db->prepare($query_getImg);
    $getImg_stmt->execute([$values['id']]);
    $fetchData = $getImg_stmt->fetch();
    $oldImgs = $this->matchPaths($fetchData['content']);

    foreach ($oldImgs as $val) {
      if (!in_array($val, $newImgs)) {
        @unlink($this->storePath . basename($val));
      }
    }

    if (!empty($values['banner'])) {
      $ext = pathinfo($values['banner']['name'], PATHINFO_EXTENSION);
      $name = uniqid() . '.' . $ext;
      move_uploaded_file($values['banner']['tmp'], $this->storePath . $name);
      @unlink($this->storePath . basename($fetchData['banner']));
      $valsAry[] = $name;
    }
    
    $query_update = "update {$this->table} set `title` = ?, `content` = ?, `location` = ?, `date` = ? ";
    $valsAry = [$values['title'], $values['content'], $values['location'], $values['date']];
    if (!empty($values['banner'])) {
      $query_update .= ", `banner` = ? ";
    }
    $valsAry[] = $values['id'];
    $query_update .= "where `id` = ?";
    $update_stmt = $this->db->prepare($query_update);
    $update_stmt->execute($valsAry);

    if ($update_stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
}
