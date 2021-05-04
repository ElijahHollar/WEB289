<?php

/**
 * Redirects the browser to the supplied location
 *
 * @param {string} $location - the location to redirect the browser to
 *
 */
function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

/**
 * Appends a given url path to the site's root path and returns the combined url
 *
 * @param {string} $script_path - the url path to be combined with the site's root path
 *
 */
function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

/**
 * Checks to see if the server request is using the POST method and retuns true if it is
 *
 */
function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Checks to see if the server request is using the GET method and retuns true if it is
 *
 */
function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

/**
 * Runs a supplied string through the strip_tags() php function, to remove any tags included in the input and prevent HTML injection and cross site scripting
 *
 * @param {string} $string="" - the string to be run through the strip_tags() function
 *
 */
function h($string="") {
  return strip_tags($string);
}
