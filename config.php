<?php

  /*
  in production, there would need to be a configuration file lower than the
  DocumentRoot. Functions inside this file would then be able to read that document
  and pull critical information like database connection strings.

  In the mean time, the associative arrays will have to do.
  */



  $conf['root'] = $_SERVER['DOCUMENT_ROOT'];

  $conf['hostname'] = 'localhost';
  $conf['username'] = 'kenny';
  $conf['password'] = 'pass123';
  $conf['database'] = 'phpmvc';

print_r($conf);
?>
