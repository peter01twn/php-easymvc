<?php
// class route {
//   public $uri = 'asd';
// }
// function Route () {
//   echo new route;
// }
// $route = new route();
// echo $route->uri;
// $route::show();
// if (false === '') {
//   echo 'true';
// } else {
//   echo 'false';
// }
// foreach(['asd'] as $str) {
//   echo $str;
// }
$str = ':path';
echo preg_match('/:(\w*)$/', $str);