<?php
use easymvc\base\RouteNode;

require MODULES_PATH . 'checkSession.php';

$root = new RouteNode('/');

$admin = $root->any('admin');
$admin->post('login', 'AdminController', 'login');
$admin->get('logout', 'AdminController', 'logout');

$check = $admin->any('')->setMiddlewar('checkSession');
$check->post('upload', 'UploadController', 'uploadTemp');

$events = $check->any('events');
$events->get('get', 'AdminEventsController', 'get');
$events->post('post', 'AdminEventsController', 'post');
$events->post('put', 'AdminEventsController', 'put');
$events->delete('delete', 'AdminEventsController', 'delete');

$root->runTree($_GET['url']);