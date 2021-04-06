<?php

require_once('../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors['username'] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors['password'] = "Password cannot be blank.";
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
      <h1>Log In</h1>
      <p>Please fill out the form below to log in:</p>

      <?php // echo display_errors($errors); ?>

      <form action="<?php echo url_for('login.php');?>" method="post">

        <div>
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required> <?php if(isset($errors['username'])) { echo($errors['username']); } ?>
        </div>

        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" value="" required> <?php if(isset($errors['password'])) { echo($errors['password']); } ?>
        </div>

        <input type="submit" value="Log In">
        <p><a href="<?php echo(url_for('forgot.php')); ?>">Forgot Password?</a></p>
      </form>
    </main>
  </body>
</html>

