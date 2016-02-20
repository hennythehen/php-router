<?php

namespace bin\Components;

class Router
{

  const CONTROLLER_BASE_DIR = 'app/Controllers';

  private static $routes = array();
  private $uriString;
  private $controller;
  private $parameters;

  public function __construct()
  {
    $this->uriString = substr($_SERVER['REQUEST_URI'], 1);
    foreach (Router::$routes as $name => $route) {

      if ($this->routePathMatchesUri($route['path'], $this->uriString)) {
        $this->controller = Router::$routes[$name];
        $this->parameters = $this->getRouteParameters();
        break;
      }

    }
    if ($this->controller == null) {
      echo 'no route found';
    }
//    var_dump($this->parameters);
  }

  public static function newRoute($uriString, $name, $controllerCallback)
  {
    Router::$routes[$name] = array(
      'path' => $uriString,
      'controller' => $controllerCallback
    );
  }

  public function getController()
  {
//    var_dump($this->controller);
    return $this->controller['controller'];
  }

  public function executeController()
  {
    $reflection = new \ReflectionFunction($this->controller['controller']);
    $reflection->invokeArgs($this->parameters);
  }

  private function routePathMatchesUri($routePath, $uri)
  {
    $uriArr = explode("/", $uri);
    $pathArr = explode("/", $routePath);

    if (count($uriArr) != count($pathArr)) {
      return false;
    }

    $match = true;

    for ($i = 0; $i < count($routePath); $i++) {
      //if the first and last characters of the "/" divided section are { and }.
      if (substr($pathArr[$i], 0, 1) == "{" &&
          substr($pathArr[$i], strlen($pathArr[$i])-1, strlen($pathArr[$i]))) {
        continue;
      }
      else if ( $uriArr[$i] != $pathArr[$i]) {
        $match = false;
      }
    }

    return $match;
  }

  private function getRouteParameters()
  {
    $parameters = array();

    $uriArr = explode("/", $this->uriString);
    $routeArr = explode("/", $this->controller['path']);

    for ($i = 0; $i < count($routeArr); $i++) {
      //if the first and last characters of the "/" divided section are { and }.
      if (substr($routeArr[$i], 0, 1) == "{" &&
          substr($routeArr[$i], strlen($routeArr[$i])-1, strlen($routeArr[$i]))) {
        //So this is a parameter. Check with the route's equivalent position $i and create a new variable
        //<$routeArr[$i]> = $uriArr[$i]
        $parameters[substr($routeArr[$i], 1, strlen($routeArr[$i])-2)] = $uriArr[$i];
      }
    }

    return $parameters;
  }

  public function get($parameter)
  {
    if (isset($controller[$parameter])) {
      return $controller[$parameter];
    } else {
      throw new Exception('Route parameter does not exist');
    }
  }
}
