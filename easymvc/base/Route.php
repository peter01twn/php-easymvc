<?php

namespace easymvc\base;

class RouteNode
{
  protected $name;
  protected $uri;
  protected $method;
  protected $controller;
  protected $action;
  protected $params;
  protected $middlewars;
  protected $children;
  protected $parent;
  protected $router;

  function __construct($uri, $controller = null, $action = null, $method = 'any')
  {
    $this->method = $method;
    $this->uri = $uri;
    $this->controller = $controller;
    $this->action = $action;
    $this->params = [];
    $this->children = [];
    $this->middlewars = [];
  }

  function setParent($parent)
  {
    $this->parent = $parent;
    return $this;
  }

  function getParent()
  {
    return $this->parent;
  }

  // function setRouter($router)
  // {
  //   $this->router = $router;
  //   return $this;
  // }

  // function getRouter()
  // {
  //   $this->router ?:  $this->router = new Router();
  //   return $this->router;
  // }

  protected function createRoute($uri, $controller, $action, $method, $parent)
  {
    $newNode = new RouteNode($uri, $controller, $action, $method);
    $newNode
      ->setParent($parent);
    // ->setRouter($parent->getRouter());
    return $newNode;
  }

  function get($uri, $controller = null, $action = null)
  {
    $this->children[] = $this->createRoute($uri, $controller, $action, 'get', $this);
    return $this;
  }
  function post($uri, $controller = null, $action = null)
  {
    $this->children[] = $this->createRoute($uri, $controller, $action, 'post', $this);
    return $this;
  }
  function put($uri, $controller = null, $action = null)
  {
    $this->children[] = $this->createRoute($uri, $controller, $action, 'put', $this);
    return $this;
  }
  function delete($uri, $controller = null, $action = null)
  {
    $this->children[] = $this->createRoute($uri, $controller, $action, 'delete', $this);
    return $this;
  }
  function any($uri, $controller = null, $action = null)
  {
    $this->children[] = $this->createRoute($uri, $controller, $action, 'any', $this);
    return $this;
  }

  function getMiddlewaars()
  {
    return $this->middlewars;
  }

  function setMiddlewar($param1, $param2)
  {
    $this->middlewars[] = [$param1, $param2];
    return $this;
  }

  function runTree($path, $params = [])
  {
    if (!empty($params)) {
      $this->params = array_merge($this->params, $params);
    }
    $pathAry = array_filter(explode('/', $path));
    $uriAry = array_filter(explode('/', $this->uri));
    for ($i = 0; $i < count($uriAry); $i++) {
      if (preg_match('/:(\w*)$/', $uriAry[0])) {
        $this->params[] = array_shift($pathAry);
        array_shift($uriAry);
        continue;
      } else if (array_shift($pathAry) === array_shift($uriAry)) {
        continue;
      } else {
        return;
      }
    }

    $this->run();
    $children = empty($this->children) ? [] : $this->children;
    foreach ($children as $node) {
      $node->runTree(implode('', $pathAry), $this->params);
    }
  }

  function run()
  {
    $this->callMiddlewars();
    $this->callController();
  }
  protected function callController()
  {
    $controller = $this->controller;
    if ($controller) {
      $insController = new $controller();
      call_user_func(array($insController, $this->action), $this->params);
      exit();
    }
  }
  // function run($url)
  // {
  //   $uriCollection = $this->getAllUri();
  //   foreach ($uriCollection as $uri) {
  //     $urlAry = explode('/', $url);
  //     $uriAry = explode('/', $uri);
  //     $hasParam = preg_match('/:(\w*)$/', $uri);
  //     if ($hasParam) {
  //       array_pop($uriAry);
  //       $param = array_pop($urlAry);
  //       // implode('', $uriAry);
  //       // implode('', $urlAry);
  //       if (implode('', $uriAry) === implode('', $urlAry)) {
  //         # code...
  //       }
  //     }
  //   }
  // }

  protected function matchUrl()
  {
  }

  protected function getAllUri()
  {
    $uriCollection = [];
    $children = empty($this->children) ? [] : $this->children;
    foreach ($children as $child) {
      $childCollection = $this->child->run();
      $childCollection = preg_replace('/(.*)/', $this->uri . '$1', $childCollection);
      $uriCollection[] = $childCollection;
    }
    return empty($uriCollection) ? $this->uri : $uriCollection;
  }

  // function setName($str) {
  //   $this->name = $str;
  //   return $this;
  // }
  // function getNode($name) {
  //   if (empty($this->children)) {
  //     return false;
  //   }
  //   foreach ($this->children as $node) {
  //     if ($node->getName() === $name) {
  //       return $node;
  //     } else {
  //       $result = $node->getNode($name);
  //       if ($result) {
  //         return $result;
  //       } else {
  //         return false;
  //       }
  //     }
  //   }
  // }
  // function getName() {
  //   return $this->name;
  // }
  protected function callMiddlewars()
  {
    $middlewars = empty($this->middlewars) ? [] : $this->middlewars;
    foreach ($middlewars as $funcAry) {
      if (is_array($funcAry[0])) {
        if (isset($funcAry[1])) {
          $funcAry[1] = is_array($funcAry[1]) ? $funcAry[1] : [$funcAry[1]];
        }
        call_user_func_array($funcAry[0], $funcAry[1]);
      } else {
        call_user_func_array($funcAry, []);
      }
    }
  }
}
