<?php

require_once('../private/initialize.php');

$errors = [];
$username = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors['username'] = "username cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    // Redirect to the reset page
    $confirmation_code = random_int(10000, 99999);

    $_SESSION['username'] = $username;
    $_SESSION['confirmation_code'] = $confirmation_code;

    $admin = Admin::find_by_username($username);

    $subject = "Bookup Password Reset";
    $message = "Greetings " . $username . ",\nWe at Bookup recently recieved a request to reset your password. In compliance with this request we have sent you this email.\n" . $confirmation_code . "\nPlease enter this code on the page you were redirected to.";
    $header = "From: elijahshollar@students.abtech.edu";
    mail($admin->user_email_address, $subject, $message, $header);
    redirect_to(url_for('reset.php'));
  }
}

include(SHARED_PATH . '/public-header.php');

?>

    <main>
      <h1>Reset Password</h1>
      <p>Please enter your username below. We will send instructions on how to reset your password to the email address associated with your account.</p>

      <form action="<?php echo url_for('forgot.php');?>" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required> <?php if(isset($errors['username'])) { echo($errors['username']); } ?>

        <input type="submit" value="Send Instructions">
      </form>
    </main>
  </body>
</html>

