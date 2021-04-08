<?php

require_once('../private/initialize.php');

  $username = $_SESSION['username'] ?? '';

  $errors = [];

  $confirmation_code = '';

  if(is_post_request()) {

    $confirmation_code = $_POST['reset-code'] ?? '';

    $new_password = $_POST['admin[\'password\']'] ?? '';

    $confirm_password = $_POST['admin[\'confirm_password\']'] ?? '';

    // Validations
    if(is_blank($confirmation_code)) {
      $errors['confirmation_code'] = "Please enter your reset code.";
    } elseif($confirmation_code != $_SESSION['confirmation_code']) {
      $errors['confirmation_code'] = "The confirmation code is incorrect.";
    }
    
    if(is_blank($new_password)) {
    }

    if($new_password != $confirm_password) {
    }

    // if there were no errors, try to reset password
    if(empty($errors)) {
      $admin = Admin::find_by_username($username);
      // test if admin is found
      if($admin != false) {
        // populate admin profile with new password and attempt to update
        $args = $_POST['admin'];

        $admin->merge_attributes($args);

        $result = $admin->save();

        if($result === true) {
          // if update was successful log the user in, provide a message stating the change, and redirect them to the home page
          $session->message("The password was changed successfully.");
          $session->login($admin);

          
          redirect_to(url_for('index.php'));
        }
      } else {
        // username not found
      }

    }

  }

  include(SHARED_PATH . '/public-header.php');
?>

    <main>
      <h1>Log In</h1>
      <p>Please fill out the form below to reset your password:</p>

      <form action="<?php echo url_for('reset.php');?>" method="post">

        <div>
          <label for="reset-code">Reset Code:</label>
          <input type="text" id="reset-code" name="reset-code" value="<?php echo h($confirmation_code); ?>" required> <?php if(isset($errors['confirmation_code'])) { echo($errors['confirmation_code']); } ?>
        </div>

        <div>
          <label for="password">New Password:</label>
          <input type="password" id="password" name="admin[password]" value="" required> <?php if(isset($admin->errors['password'])) { echo($admin->errors['password']); } ?>
        </div>

        <div>
          <label for="confirm-pass">Confirm New Password:</label>
          <input type="password" id="confirm-pass" name="admin[confirm_password]" value="" required> <?php if(isset($admin->errors['confirm_password'])) { echo($admin->errors['confirm_password']); } ?>
        </div>

        <input type="submit" value="Reset Password">
      </form>
    </main>
  </body>
</html>
