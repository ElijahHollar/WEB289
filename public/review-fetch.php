<?php

require_once("../private/initialize.php"); 

$book_isbn = $_GET['isbn'] ?? '';

$reviews = Review::get_reviews($book_isbn);

if($reviews != false) {
  foreach($reviews as $review) {
    $username = Admin::find_by_id($review->user_id);
  
    echo("<div class=\"review\">");
    echo("<p>Posted By: " . $username->user_username . "</p>");
    echo("<p>Posted On: " . $review->review_date . "</p>");
    echo("<p>" . $review->review_text . "</p>");
    echo("</div>");
  }
} else {
  echo("<p>No reviews found for this book. Be the first to write one!</p>");
}

?>