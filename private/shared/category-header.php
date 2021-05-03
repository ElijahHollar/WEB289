<?php $subject_path = 'subject.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="<?php echo url_for('../css/style.css'); ?>" rel="stylesheet">
    <title>Bookup: Home</title>
    <script src="<?php echo url_for('../js/redirect.js'); ?>" defer></script>
    <?php if($captcha_page == true) { ?>
      <script src="https://www.google.com/recaptcha/api.js"></script>
    <?php } ?>
  </head>

  <body>
    <header role="banner">
      <!-- <img src="media/"> -->
      <h1>Bookup: The Book Lookup Tool</h1>
      <nav role="navigation">
        <ul>
          <li><a href="../../index.php">Site Home</a></li>
          <li><a href="<?php echo url_for("admins/category/index.php"); ?>">Categories</a></li>
          <li><a href="<?php echo url_for("admins/review/index.php"); ?>">Reviews</a></li>
        </ul>
        <div>
          <?php if($session->is_logged_in()) { ?>
            <a href="<?php echo url_for("public/logout.php"); ?>" class="login">Log Out</a>
          <?php } ?>

          <?php if(!$session->is_logged_in()) { ?>
            <a href="login.php" class="login">Log In</a>
            <a href="signup.php" class="login">Sign Up</a>
          <?php } ?>
          <form class="search-form" action="<?php echo url_for('search.php'); ?>" method="post">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" required>
            <label for="search-type">By:</label>
            <select id="search-type" name="search-type">
              <option value="title">Title</option>
              <option value="category">Category</option>
              <option value="author">Author</option>
              <option value="publisher">Publisher</option>
              <option value="isbn">ISBN</option>
            </select>
            <input type="submit" value="Search">
          </form>
        </div>
       </nav>
    </header>

    <?php echo display_session_message(); ?>