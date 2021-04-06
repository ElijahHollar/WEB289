<?php

require_once('../private/initialize.php');

if(is_post_request()) {

  // Create record using post parameters
  $args = $_POST['admin'];
  var_dump($args);
  $admin = new Admin($args);
  $result = $admin->save();

  if($result === true) {
    $session->login($admin);
    $session->message('You are now a member of the Bookup family! You may now save books to your bookshelf for later viewing.');
    redirect_to(url_for('index.php'));
  } else {
    // show errors
  }

} else {
  // display the form
  $admin = new Admin;
}

include(SHARED_PATH . '/public-header.php');

?>


    <main>
      <h1>Sign Up</h1>
      <p>Please fill out the form below to become a member:</p>

      <?php //echo display_errors($admin->errors); ?>

      <form action="<?php echo url_for('/signup.php'); ?>" method="post">

        <div>
          <label for="email">Email:</label>
          <input type="text" id="email" name="admin[user_email_address]" value="<?php echo h($admin->user_email_address); ?>" required> <?php if(isset($admin->errors['email'])) { echo($admin->errors['email']); } ?>
        </div>

        <div>
          <label for="username">Username:</label>
          <input type="text" id="username" name="admin[user_username]" value="<?php echo h($admin->user_username); ?>" required> <?php if(isset($admin->errors['username'])) { echo($admin->errors['username']); } ?>
        </div>

        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" name="admin[password]" value="" required> <?php if(isset($admin->errors['password'])) { echo($admin->errors['password']); } ?>
        </div>

        <div>
          <label for="confirm-pass">Confirm Password:</label>
          <input type="password" id="confirm-pass" name="admin[confirm_password]" value="" required> <?php if(isset($admin->errors['confirm_password'])) { echo($admin->errors['confirm_password']); } ?>
        </div>

        <input type="submit" value="Sign Up">
      </form>
    </main>
  </body>
</html>

