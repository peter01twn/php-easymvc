<?php
use \easymvc\base\Router;
require(MODULES_PATH . 'checkMethod.php');
require(MODULES_PATH . 'checkSession.php');
$route = new Router();
$middlewar = [
  [
    'middlewars' => [
      ['checkMethod', 'get'],
      ['checkSession']
    ],
    'url' => ['Events']
  ]
];
$route->setMiddle($middlewar)->run();
