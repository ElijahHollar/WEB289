<?php 
  require_once('private/database-connection.php');

  $sql = "SELECT category_name FROM category";

  $result = $database->query($sql);
  if(!$result) {
    exit("<p>Database query failed</p>");
  }
  
  $category_array = [];
  while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
    foreach($record as $category) {
      echo("<h1>".$category."</h1>");
    }
  }
?>