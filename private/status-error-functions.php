<?php

/**
 * Checks to see if the user attempting to access the web page is logged into the site, if not it redirects the user to the site's homepage and 
 * prepares a session message telling them that they need to log in to access the page
 *
 */
function require_login() {
  global $session;
  if(!$session->is_logged_in()) {
    $session->message("You must be logged in to access this page.");
    redirect_to(url_for('index.php'));
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

/**
 * Checks to see if the user attempting to access the web page is an admin of the site, if not it redirects the user to the site's homepage
 *
 */
function require_admin() {
  global $session;
  if($session->user_level !== 'a') {
    redirect_to(url_for('/index.php'));
  } else {
    // Let the page load
  }
}

/**
 * Takes a supplied array of error messages and displays them in a <div> containing a list, or returns an empty string if the supplied array is empty
 *
 * @param {array} $errors=array() - the array of errors to be displayed
 *
 */
function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

/**
 * Gets the current message stored in the session class, and displays it if it isn't null or empty. Clears the current session message as well.
 *
 */
function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div id="message">' . h($msg) . '</div>';
  }
}
