<?php $subject_path = 'subject.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
    <title>Bookup: Home</title>
  </head>

  <body>
    <header role="banner">
      <!-- <img src="media/"> -->
      <h1>Bookup: The Book Lookup Tool</h1>
      <nav role="navigation">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li class="dropdown">
            <a class="dropbtn">Subjects</a>
            <ul class="dropdown-content">
              <a href="<?php echo($subject_path . "?subject=Fantasy") ?>">Fantasy</a>
              <a href="<?php echo($subject_path . "?subject=Science Fiction") ?>">Science Fiction</a>
              <a href="<?php echo($subject_path . "?subject=Historical") ?>">Historical</a>
            </ul>
          </li>
          <?php if($session->is_logged_in()) { ?>
            <li><a href="bookshelf.php">My Bookshelf</a></li>
          <?php } ?>
        </ul>
        <div>
          <?php if($session->is_logged_in()) { ?>
            <p class="username">User: <?php echo $session->username; ?></p>
            <a href="logout.php" class="login">Log Out</a>
          <?php } ?>      
          <?php if($session->is_admin()) { ?>
            <a href="admins/index.php" class="login">Backend</a>
          <?php } ?>

          <?php if(!$session->is_logged_in()) { ?>
            <a href="login.php" class="login">Log In</a>
            <a href="signup.php" class="login">Sign Up</a>
          <?php } ?>
          <form class="search-form">
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