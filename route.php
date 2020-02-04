<?php

use easymvc\base\RouteNode;

require './easymvc/base/Route.php';

class item {
  function show() {
    echo 'show';
  }
}

$router = new RouteNode('/');
$router->get('item', 'item', 'show');
$router->runTree('item');