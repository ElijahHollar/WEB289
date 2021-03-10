<?php

require_once('../private/initialize.php');

// Log out
$session->message('Goodbye ' . $session->username . ", you have logged out.");

$session->logout();

redirect_to(url_for('/index.php'));
