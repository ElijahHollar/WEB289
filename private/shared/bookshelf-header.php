<?php 

$subject_path = 'subject.php'; 

if(!isset($current_page)) {
  $current_page = '';
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
    <title>Bookup: My Bookshelf</title>
    <script src="../js/redirect.js" defer></script>
    <script src="../js/bookshelf.js" defer></script>
  </head>

  <body>
    <header role="banner">
      <img src="<?php echo url_for('../media/images/bookup-logo.png'); ?>" alt="Bookup site logo">
      <h1>Bookup: The Book Lookup Tool</h1>
      <nav role="navigation">
        <ul>
          <li><a class="<?php if($current_page == "home") { echo "current-page"; } ?>" href="index.php">Home</a></li>

          <li><a class="<?php if($current_page == "about") { echo "current-page"; } ?>" href="about.php">About</a></li>

          <li class="dropdown">
            <a class="dropbtn <?php if($current_page == "subject") { echo "current-page"; } ?>">Subjects</a>
            <ul class="dropdown-content">
              <li><a href="<?php echo($subject_path . "?subject=Fantasy") ?>">Fantasy</a></li>
              <li><a href="<?php echo($subject_path . "?subject=Science%20Fiction") ?>">Science Fiction</a></li>
              <li><a href="<?php echo($subject_path . "?subject=Historical") ?>">Historical</a></li>
            </ul>
          </li>

          <?php if($session->is_logged_in()) { ?>
            <li><a class="<?php if($current_page == "bookshelf") { echo "current-page"; } ?>" href="bookshelf.php">My Bookshelf</a></li>
          <?php } ?>
        </ul>

        <div>
          
          <?php if($session->is_logged_in()) { ?>
            <a href="logout.php" class="logout"><?php echo "Log Out " . $session->username; ?></a>
          <?php } ?>     

          <?php if($session->is_admin()) { ?>
            <a href="admins/index.php" class="login">Backend</a>
          <?php } ?>

          <?php if(!$session->is_logged_in()) { ?>
            <a href="login.php" class="login">Log In</a>
            <a href="signup.php" class="login">Sign Up</a>
          <?php } ?>

          <form class="search-form" action="<?php echo url_for('search.php'); ?>" method="post">

            <label for="search-type">Search By:</label>
            <select id="search-type" name="search-type">
              <option value="title">Title</option>
              <option value="category">Category</option>
              <option value="author">Author</option>
              <option value="publisher">Publisher</option>
              <option value="isbn">ISBN</option>
            </select>

            <label for="search">Search For:</label>
            <input type="text" id="search" name="search" required>

            <input type="submit" id="submit-search" value="Search">
          </form>
        </div>
       </nav>
    </header>

    <?php echo display_session_message(); ?>