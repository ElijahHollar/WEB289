<?php

  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("PRIVATE_PATH", dirname(__FILE__));
  define("SITE_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", SITE_PATH . '/public');
  define("SHARED_PATH", PRIVATE_PATH . '/shared');

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '/~kevinskoglund/chain_gang/public');
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/public"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once("functions.php");
  require_once("database-connection.php");
  require_once("status-error-functions.php");
  require_once("validation-functions.php");

  include("classes/session.class.php");
  include("classes/database-object.class.php");
  include("classes/admin.class.php");
  include("classes/category.class.php");
  include("classes/review.class.php");
  include("classes/bookshelf.class.php");

  $database = db_connect();
  DatabaseObject::set_database($database);

  $session = new Session;

  $captcha_page = false;
