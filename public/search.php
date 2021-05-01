<?php 
  require_once('../private/initialize.php'); 
  include(SHARED_PATH . '/search-header.php');
  date_default_timezone_set("America/New_York");

  if(is_post_request()) {

    if($_POST['review'] != null) {
      
      $args = $_POST['review'];

      $args['user_id'] = $_SESSION['admin_id'];
      $args['review_date'] = date("Y-m-d h:i:s");

      // var_dump($args);
      // echo("<br>");
      $review = new Review($args);
      $result = $review->save();

      if($result === true) {
        $new_id = $review->review_id;
        $session->message("Your review was successfully posted.");
      } else {
        // show errors
      }
    }
  }

?>
    <main>
      <h1></h1>
      <div id="modalBackground">
        <div id="modalContainer">
          <div id="modalBox">
            <span id="close">&times;</span>
            <img>
            <div>
              <p class="bold">Title</p>
              <p></p>
            </div>
            <div>
              <p class="bold">Author</p>
              <p></p>
            </div>
            <div>
              <p class="bold">Publisher</p>
              <p></p>
            </div>
            <div>
              <p class="bold">Year Published</p>
              <p></p>
            </div>
            <div>
              <p class="bold">Description</p>
              <p></p>
            </div>
            <?php if($session->is_logged_in()) { ?>
              <a href="#" id="review-button">Write a Review</a>
            <?php } ?>
          </div>
          <div id="reviewBox">
            <div id="reviewViewing">
              <p class="bold"></p>
              <div id="reviews">

              </div>
            </div>
            <div id="reviewWriting">
              <p class="bold"></p>
              <form action="/WEB289/public/search.php" method="post">
                <input class="hidden" type="text" id="review_isbn" name="review[review_isbn]">
                <label for="review_text">Review Text:</label>
                <textarea rows="25" cols="80" maxlength="2500" id="review_text" name="review[review_text]"></textarea>
                <input type="submit" id="submit-review" value="Submit Review">
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
