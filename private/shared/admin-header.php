<?php 

if(!isset($current_page)) {
  $current_page = '';
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="<?php echo url_for('../css/style.css'); ?>" rel="stylesheet">
    <title>Bookup: Home</title>
  </head>

  <body>
    <header role="banner">
    <img src="<?php echo url_for('../media/images/bookup-logo.png'); ?>" alt="bookup site logo">
      <h1>Bookup: The Book Lookup Tool</h1>
      <nav role="navigation">
        <ul>
          <li><a href="<?php echo url_for("index.php"); ?>">Site Home</a></li>
          <li><a class="<?php if($current_page == "category-home") { echo "current-page"; } ?>" href="<?php echo url_for("admins/category/index.php"); ?>">Categories</a></li>
          <li><a class="<?php if($current_page == "review-home") { echo "current-page"; } ?>" href="<?php echo url_for("admins/review/index.php"); ?>">Reviews</a></li>
        </ul>
        <div>
          <?php if($session->is_logged_in()) { ?>
            <a href="<?php echo url_for("logout.php")?>" class="logout"><?php echo "Log Out " . $session->username; ?></a>
          <?php } ?>

          <?php if(!$session->is_logged_in()) { ?>
            <a href="login.php" class="login">Log In</a>
            <a href="signup.php" class="login">Sign Up</a>
          <?php } ?>
          <form class="search-form" action="<?php echo url_for('search.php'); ?>" method="post">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search">
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