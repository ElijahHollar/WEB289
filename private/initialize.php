<?php

  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("PRIVATE_PATH", dirname(__FILE__));
  define("SITE_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", SITE_PATH . '\public');
  define("SHARED_PATH", PRIVATE_PATH . '\shared');

  require_once("functions.php");