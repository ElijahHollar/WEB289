<?php 
  require_once('../private/initialize.php'); 
  include(SHARED_PATH . '/public-header.php');
  
  $subject_type = $_GET['subject'] ?? 'Fantasy';

?>
    <main>
      <h1><?php echo $subject_type ?></h1>
    </main>
  </body>
</html>
