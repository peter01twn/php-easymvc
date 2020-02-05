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
    $newNode = $this->createRoute($uri, $controller, $action, 'get', $this);
    $this->children[] = $newNode;
    return $newNode;
  }
  function post($uri, $controller = null, $action = null)
  {
    $newNode = $this->createRoute($uri, $controller, $action, 'post', $this);
    $this->children[] = $newNode;
    return $newNode;
  }
  function put($uri, $controller = null, $action = null)
  {
    $newNode = $this->createRoute($uri, $controller, $action, 'put', $this);
    $this->children[] = $newNode;
    return $newNode;
  }
  function delete($uri, $controller = null, $action = null)
  {
    $newNode = $this->createRoute($uri, $controller, $action, 'delete', $this);
    $this->children[] = $newNode;
    return $newNode;
  }
  function any($uri, $controller = null, $action = null)
  {
    $newNode = $this->createRoute($uri, $controller, $action, 'any', $this);
    $this->children[] = $newNode;
    return $newNode;
  }

  function getMiddlewaars()
  {
    return $this->middlewars;
  }

  function setMiddlewar($param1, $param2 = [])
  {
    $this->middlewars[] = [$param1, $param2];
    return $this;
  }

  function runTree($path, $params = [])
  {
    
    $method = strtoupper($this->method);
    
    if ($method !== 'ANY' && $method !== REQUEST_METHOD) {
      return;
    }
    
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
    $nextPath = implode('/', $pathAry);
    foreach ($this->children as $node) {
      $node->runTree($nextPath, $this->params);
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
      $insController = new $controller($controller, $this->action);
      call_user_func(array($insController, $this->action), $this->params);
      exit();
    }
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

  protected function callMiddlewars()
  {
    foreach ($this->middlewars as $funcAry) {
      call_user_func_array($funcAry[0], $funcAry[1]);
    }
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

}
