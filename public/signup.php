<?php

require_once('../private/initialize.php');

// if(is_post_request()) {

//   // Create record using post parameters
//   $args = $_POST['admin'];
//   $admin = new Admin($args);
//   $result = $admin->save();

//   if($result === true) {
//     $session->login($admin);
//     $session->message('You are now a member of the Bookup family! You may now save books to your bookshelf for later viewing.');
//     redirect_to(url_for('index.php'));
//   } else {
//     // show errors
//   }

// } else {
//   // display the form
//   $admin = new Admin;
// }

include(SHARED_PATH . '/public-header.php');

?>


    <main>
      <h1>Sign Up</h1>
      <p>Please fill out the form below to become a member:</p>
      <form action="<?php echo url_for('signup.php');?>" method="post">

        <label for="email">Email:</label>
        <input type="text" id="email" name="admin[email]" value="<?php echo h($admin->email); ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="admin[username]" value="<?php echo h($admin->username); ?>">


        <label for="password">Password:</label>
        <input type="password" id="password" name="admin[password]" value="">

        <label for="confirm-pass">Confirm Password:</label>
        <input type="password" id="confirm-pass" name="admin[confirm_password]" value="">

        <input type="submit" value="Sign Up">
      </form>
    </main>
  </body>
</html>

