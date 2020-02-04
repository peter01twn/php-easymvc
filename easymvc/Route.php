<?php
use \easymvc\base\Router;
require(MODULES_PATH . 'checkMethod.php');
require(MODULES_PATH . 'checkSession.php');
$route = new Router();
$middlewar = [
  [
    'url' => ['events'],
    'middlewars' => [
      'checkSession'
    ]
  ]
];
$route->setMiddle($middlewar)->run();
