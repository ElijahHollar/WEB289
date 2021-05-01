<?php

require_once("../private/initialize.php"); 

$book_isbn = $_GET['isbn'] ?? '';

$reviews = Review::find_by_isbn($book_isbn);

if($reviews != false) {
  foreach($reviews as $review) {
    $username = Admin::find_by_id($review->user_id);
  
    echo("<div class=\"review\">");
    echo("<p>" . $username->user_username . "</p>");
    echo("<p>Posted On:" . $review->review_date . "</p>");
    echo("<p>" . $review->review_text . "</p>");
    echo("</div>");
  }
} else {
  echo("<p>No reviews found.</p>");
}

?>