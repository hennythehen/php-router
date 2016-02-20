<?php

use bin\Components\Router;

function __autoload($className) {
  include $className . '.php';
}

foreach (glob("app/Controllers/*.php") as $filename) {
//    echo $filename;
    require_once($filename);
}

$router = new Router();

$action = $router->getController();
//var_dump($action);
$router->executeController();

function foo($p1, $p2) {
    echo 'p1 is '. $p1 . '<br>';
    echo 'p2 is '. $p2 . '<br>';
}
