<?php
class route {
  public $uri = 'asd';
}
function Route () {
  echo new route;
}
$route = new route();
echo $route->uri;
// $route::show();
