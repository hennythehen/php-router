<?php

namespace app\Controllers;

use bin\Components\Router;

Router::newRoute('test/route', 'my_route', function() {
  echo 'Hello World';
});

Router::newRoute('user/{userId}/{userName}', 'get_user', function($userId, $asdf) {
  echo "p1: $userId <br>";
  echo "p2: $asdf <br>";
});


