<?php

require_once('../private/initialize.php');

$errors = [];
$username = '';

$page_title = "Bookup: Forgot Password";

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $recaptcha = $_POST['g-recaptcha-response'];
  $res = reCaptcha($recaptcha);
  
  // Validations
  if(!$res['success']){
    $errors['captcha'] = "ReCaptcha Failed.";
  }
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

$captcha_page = true;

include(SHARED_PATH . '/public-header.php');

?>

    <main>
      <h1>Reset Password</h1>
      <p>Please enter your username below. We will send instructions on how to reset your password to the email address associated with your account.</p>

      <form action="<?php echo url_for('forgot.php');?>" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required> <?php if(isset($errors['username'])) { echo($errors['username']); } ?>

        <div>
          <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LfAjMQaAAAAAPgjZnqdQD41KI_rferzdpL8n13H"></div> <?php if(isset($errors['captcha'])) { echo($errors['captcha']); } ?>
        </div>

        <input type="submit" value="Send Instructions">
      </form>
    </main>
  </body>
</html>

