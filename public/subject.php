<?php 
  require_once('../private/initialize.php'); 
  
  $current_page = 'subject';

  include(SHARED_PATH . '/public-header.php');
  
  $subject_type = h($_GET['subject']) ?? 'Fantasy';

?>
    <main>
      <h1><?php echo $subject_type ?></h1>
    </main>
  </body>
</html>
