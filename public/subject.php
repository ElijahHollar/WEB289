<?php 
  require_once('../private/initialize.php'); 
  
  $current_page = 'subject';
  
  $subject_type = h($_GET['subject']) ?? 'Fantasy';
  
  $page_title = "Bookup: " . $subject_type . " Subject";
  
  include(SHARED_PATH . '/public-header.php');
?>
    <main>
      <h1><?php echo $subject_type ?></h1>
    </main>
  </body>
</html>
