<?php

require_once('../private/initialize.php');

$errors = [];
$username = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    $admin = Admin::find_by_username($username);
    // test if admin found and password is correct
    if($admin != false && $admin->verify_password($password)) {
      // Mark admin as logged in
      $session->login($admin);
      $session->message('Welcome ' . $username . ', you have successfully logged in.');
      if ($session->user_level == 'm') {
        redirect_to(url_for('/index.php'));
      } else {
        redirect_to(url_for('/admins/index.php'));
      }
    } else {
      // username not found or password does not match
      $errors[] = "Log in was unsuccessful. Please try again.";
    }

  }

}

include(SHARED_PATH . '/public-header.php');

?>

    <main>
      <h1>Reset Password</h1>
      <p>Please enter your username below. We will send instructions on how to reset your password to the email address associated with your account.</p>

      <?php echo display_errors($errors); ?>

      <form action="<?php echo url_for('login.php');?>" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required>

        <input type="submit" value="Log In">
      </form>
    </main>
  </body>
</html>

