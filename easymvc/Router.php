<?php
use easymvc\base\RouteNode;

require MODULES_PATH . 'checkSession.php';

$root = new RouteNode('/');

$admin = $root->any('admin');
$admin
  ->group(function(&$a) {
      $a->post('login', 'AdminController', 'login');
      $a->get('logout', 'AdminController', 'logout');
    })
  ->any('')
    ->setMiddlewar('checkSession')
    ->group(function($a) {
        $a->post('upload', 'UploadController', 'uploadTemp');
        $a->any('events')
            ->group(function($e) {
                $e->get('get', 'AdminEventsController', 'get');
                $e->post('post', 'AdminEventsController', 'post');
                $e->post('put', 'AdminEventsController', 'put');
                $e->delete('delete', 'AdminEventsController', 'delete');
              });
      });

// $admin->post('login', 'AdminController', 'login');
// $admin->get('logout', 'AdminController', 'logout'); 
// $check = $admin->any('')->setMiddlewar('checkSession');
// $check->post('upload', 'UploadController', 'uploadTemp');

// $events = $check->any('events');
// $events->get('get', 'AdminEventsController', 'get');
// $events->post('post', 'AdminEventsController', 'post');
// $events->post('put', 'AdminEventsController', 'put');
// $events->delete('delete', 'AdminEventsController', 'delete');

$root->run($_GET['url']);