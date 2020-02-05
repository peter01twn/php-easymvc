<?php

use easymvc\base\RouteNode;

require './easymvc/base/Route.php';

class item {
  function get() {
    echo 'get';
  }
  function post() {
    echo 'post';
  }
  function delete() {
    echo 'delete';
  }
}

function checkSession() {
  if (isset($_SESSION['username'])) {
    echo 'approved / ';
  } else {
    echo 'not login / ';
  }
}
// $_SERVER['REQUEST_METHOD'] = 'get';
$router = new RouteNode('');
$admin = $router
  ->any('admin')
    ->setMiddlewar('checkSession');
$admin
  ->get('get', 'item', 'show')
  ->post('post', 'item', 'show')
  ->delete('delete', 'item', 'show');
$router->runTree('admin/get');