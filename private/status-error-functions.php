<?php

function require_login() {
  global $session;
  if(!$session->is_logged_in()) {
    $session->message("You must be logged in to access this page.");
    redirect_to(url_for('index.php'));
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

function require_admin() {
  global $session;
  if($session->user_level !== 'a') {
    redirect_to(url_for('/index.php'));
  } else {
    // Let the page load
  }
}

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

function get_and_clear_session_message() {
  if(isset($_SESSION['message']) && $_SESSION['message'] != '') {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']);
    return $msg;
  }
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div id="message">' . h($msg) . '</div>';
  }
}
