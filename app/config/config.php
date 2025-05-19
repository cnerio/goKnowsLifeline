<?php
  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_NAME', 'go_records');
  //echo $_SERVER['DOCUMENT_ROOT'];
  
  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));

  $config = parse_ini_file(APPROOT . "/config.ini");
  $GLOBALS["urlroot"] = $config["urlroot"];
  // URL Root
  define('URLROOT', $GLOBALS["urlroot"]);
  // Site Name
  define('SITENAME', 'GO Knows Lifeline');
  // App Version
  define('APPVERSION', '1.0.0');