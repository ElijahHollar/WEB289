<?php

class Session {

  private $admin_id;
  public $username;
  public $user_level;
  private $last_login;

  public const MAX_LOGIN_AGE = 60*60*24; // 1 day

  /**
   * Starts a session and checks to see if the user has a stored login upon the creation of a new instance of the session class
   *
   */
  public function __construct() {
    session_start();
    $this->check_stored_login();
  }

  /**
   * Returns the current username stored in the session class
   *
   */
  public function get_username() {
    return $this->username;
  }

  /**
   * Logs the user into the site and regenerates the session id
   *
   * @param {class} $admin - an instance of the admin class, who's values will be used to login
   *
   */
  public function login($admin) {
    if($admin) {
      // prevents session fixation attacks
      session_regenerate_id();
      $this->admin_id = $_SESSION['admin_id'] = $admin->user_id;

      $this->username = $_SESSION['username'] = $admin->user_username;

      $this->user_level = $_SESSION['user_level'] = $admin->user_level;

      $this->last_login = $_SESSION['last_login'] = time();
    }
    return true;
  }
  
  /**
   * Checks to see if the current user is logged into the site
   *
   */
  public function is_logged_in() {
    return isset($this->admin_id) && $this->last_login_is_recent();
    
  }
  
  /**
   * Checks to see if the current user is a site admin
   *
   */
  public function is_admin() {
    if($this->is_logged_in() && $this->user_level == 'a') {
      return true;
    } else {
      // $session->message("Access denied.");
    }
  }

  /**
   * Unsets all of the stored login information for the user
   *
   */
  public function logout() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['username']);
    unset($_SESSION['user_level']);
    unset($_SESSION['last_login']);
    unset($this->admin_id);
    unset($this->username);
    unset($this->user_level);
    unset($this->last_login);
    return true;
  }

  /**
   * Checks to see if the current user has a login stored in the session
   *
   */
  private function check_stored_login() {
    if(isset($_SESSION['admin_id'])) {
      $this->admin_id = $_SESSION['admin_id'];
      $this->username = $_SESSION['username'];
      $this->user_level = $_SESSION['user_level'];
      $this->last_login = $_SESSION['last_login'];
    }
  }

  /**
   * Checks to see if the current user has logged in within the last day or not
   *
   */
  private function last_login_is_recent() {
    if(!isset($this->last_login)) {
      return false;
    } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Either stores a supplied message in session memory or retrieves a message from the session memory, depending on the type of request made
   *
   * @param {string} $msg="" - the message to be stored in session memory
   *
   */
  public function message($msg="") {
    if(!empty($msg)) {
      // Then this is a "set" message
      $_SESSION['message'] = $msg;
      return true;
    } else {
      // Then this is a "get" message
      return $_SESSION['message'] ?? '';
    }
  }

  /**
   * Unsets the current message stored in session memory
   *
   */
  public function clear_message() {
    unset($_SESSION['message']);
  }
}