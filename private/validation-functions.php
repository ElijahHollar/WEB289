<?php

/**
 * Checks to see if the supplied value is empty
 *
 * @param {string} $value - the value to be checked
 *
 */
function is_blank($value) {
  return !isset($value) || trim($value) === '';
}

/**
 * Checks to see if the supplied value is not empty
 *
 * @param {string} $value - the value to be checked
 *
 */
function has_presence($value) {
  return !is_blank($value);
}

/**
 * Checks to see if a supplied string is longer than a supplied integer value
 *
 * @param {string} $value - the string who's length is to be checked
 * @param {int} $min - the minimum acceptable length for the string
 *
 */
function has_length_greater_than($value, $min) {
  $length = strlen($value);
  return $length > $min;
}

/**
 * Checks to see if a supplied string is shorter than a supplied integer value
 *
 * @param {string} $value - the string who's length is to be checked
 * @param {int} $max - the maximum acceptable length for the string
 *
 */
function has_length_less_than($value, $max) {
  $length = strlen($value);
  return $length < $max;
}

/**
 * Checks to see if a supplied string is exacly as long as a supplied integer value
 *
 * @param {string} $value - the string who's length is to be checked
 * @param {int} $exact - the acceptable length for the string
 *
 */
function has_length_exactly($value, $exact) {
  $length = strlen($value);
  return $length == $exact;
}

  // has_length('abcd', ['min' => 3, 'max' => 5])
  // * validate string length
  // * combines functions_greater_than, _less_than, _exactly
  // * spaces count towards length
  // * use trim() if spaces should not count
/**
 * Runs a string through multiple functions checking its length based off a supplied array of option values
 *
 * @param {string} $value - the string who's length is to be checked
 * @param {array} $options - the array of options for the function to look through
 *
 */
function has_length($value, $options) {
  if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
    return false;
  } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
    return false;
  } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
    return false;
  } else {
    return true;
  }
}

/**
 * Checks if a supplied value is contained within a supplied array
 *
 * @param {string} $value - the value to be checked
 * @param {array} $set - the array of values to be compared against
 *
 */
function has_inclusion_of($value, $set) {
  return in_array($value, $set);
}

/**
 * Checks if a supplied value is not contained within a supplied array
 *
 * @param {string} $value - the value to be checked
 * @param {array} $set - the array of values to be compared against
 *
 */
function has_exclusion_of($value, $set) {
  return !in_array($value, $set);
}

/**
 * Checks if a supplied value is in a valid email format
 *
 * @param {string} $value - the value to be checked
 *
 */
function has_valid_email_format($value) {
  $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
  return preg_match($email_regex, $value) === 1;
}

/**
 * Checks if a supplied username is unique or not, an id can be passed to check already existing usernames for uniqueness
 *
 * @param {string} $username - the username to be checked for uniqueness
 * @param {int} $current_id="0" - the id to be used when checking already existing usernames
 *
 */
function has_unique_username($username, $current_id="0") {
  $admin = Admin::find_by_username($username);
  if($admin === false || $admin->user_id == $current_id) {
    // is unique
    return true;
  } else {
    // not unique
    return false;
  }
}

/**
 * Checks to see if a user has already added a specific book to their Bookup bookshelf
 *
 * @param {string} $isbn - the isbn number used to check if the specific book has already been saved
 * @param {int} $user_id - the user id used to check if that specific user has already added the book
 *
 */
function already_in_bookshelf($isbn, $user_id) {
  $book = Bookshelf::get_book_by_isbn_and_user($isbn, $user_id);
  if($book === false) {
    // is unique
    return true;
  } else {
    // not unique
    return false;
  }
}

/**
 * Validates a recaptcha response
 *
 * @param {object} $recaptcha - the recaptcha response to validate
 *
 */
function reCaptcha($recaptcha){
  $secret = "6LfAjMQaAAAAAGEoaYOUdU7AGHKOuVJCE4RWFAqB";
  $ip = $_SERVER['REMOTE_ADDR'];

  $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  $data = curl_exec($ch);
  curl_close($ch);

  return json_decode($data, true);
}
