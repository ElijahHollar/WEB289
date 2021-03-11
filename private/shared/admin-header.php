<?php $current_page = $_GET['current-page']; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="<?php echo url_for('../css/style.css'); ?>" rel="stylesheet">
    <title>Bookup: Home</title>
  </head>

  <body>
    <header role="banner">
      <!-- <img src="media/"> -->
      <h1>Bookup: The Book Lookup Tool</h1>
      <nav role="navigation">
        <ul>
          <li><a href="<?php echo url_for("index.php?current-page=home"); ?>">Site Home</a></li>
          <li><a class="<?php if($current_page == "category-home") { echo "current-page"; } ?>" href="<?php echo url_for("admins/category/index.php?current-page=category-home"); ?>">Categories</a></li>
          <li><a class="<?php if($current_page == "review-home") { echo "current-page"; } ?>" href="<?php echo url_for("admins/review/index.php?current-page=review-home"); ?>">Reviews</a></li>
        </ul>
        <div>
          <?php if($session->is_logged_in()) { ?>
            <p class="username">User: <?php echo $session->username; ?></p>
            <a href="<?php echo url_for("logout.php")?>" class="login">Log Out</a>
          <?php } ?>

          <?php if(!$session->is_logged_in()) { ?>
            <a href="login.php" class="login">Log In</a>
            <a href="signup.php" class="login">Sign Up</a>
          <?php } ?>
          <form class="search-form" action="<?php echo url_for('search.php?current-page='); ?>" method="post">
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