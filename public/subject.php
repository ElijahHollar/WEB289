<?php 
  require_once('../private/initialize.php'); 
  
  $current_page = 'subject';
  
  $subject_type = h($_GET['subject']) ?? 'Fantasy';
  
  $page_title = "Bookup: " . $subject_type . " Subject";

  if(is_post_request()) {
    
    if(isset($_POST['review']) == true) {
      
      $args = $_POST['review'];
      
      $args['review_text'] = h($args['review_text']);
      $args['user_id'] = $_SESSION['admin_id'];
      $args['review_date'] = date("Y-m-d h:i:s");
      
      $review = new Review($args);
      $result = $review->save();
      
      if($result === true) {
        $new_id = $review->review_id;
        $session->message("Your review was successfully posted.");
      } else {
        // show errors
      }
    }
    
    if(isset($_POST['bookshelf']) == true) {
      
      $args = $_POST['bookshelf'];
      
      $args['user_id'] = $_SESSION['admin_id'];
      
      $bookshelf_item = new Bookshelf($args);
      $result = $bookshelf_item->save();
      
      if($result === true) {
        $new_id = $bookshelf_item->bookshelf_item_id;
        $session->message("The book was added to your bookshelf");
      } else {
        // show errors
      }
    }
  } else {
  }
  
  include(SHARED_PATH . '/public-header.php');

  echo display_session_message();
  
  if(isset($bookshelf_item->errors['bookshelf'])) { echo($bookshelf_item->errors['bookshelf']); }

?>

    <main>
      <h1><?php echo $subject_type ?></h1>

      <div id="modalBackground">
        <div id="modalContainer">

          <div id="modalBox">
            <img alt="modal box image" src="<?php echo url_for('../media/images/image-not-found.png'); ?>">
            <span id="close">&times;</span>

            <div>
              <h3 class="bold">Title</h3>
              <p></p>
            </div>
            
            <div>
              <h3 class="bold">Author</h3>
              <p></p>
            </div>
            
            <div>
              <h3 class="bold">Publisher</h3>
              <p></p>
            </div>
            
            <div>
              <h3 class="bold">Year Published</h3>
              <p></p>
            </div>
            
            <div>
              <h3 class="bold">Description</h3>
              <p></p>
            </div>
            
            <?php if($session->is_logged_in()) { ?>

              <form action="/WEB289/public/subject.php?subject=<?php if($subject_type == "Science Fiction") { $subject_type = "Science%20Fiction"; } echo($subject_type); ?>" method="post">
                <label class="hidden" for="bookshelf_item_isbn">Bookshelf ISBN</label>
                <input class="hidden" type="text" id="bookshelf_item_isbn" name="bookshelf[bookshelf_item_isbn]">
                
                <input type="submit" value="Add to my Bookshelf">
              </form>

              <a href="#" id="review-button">Write a Review</a>

            <?php } ?>
          </div>

          <div id="reviewBox">

            <div id="reviewViewing">
              <h3 class="bold">Reviews Header</h3>
              <div id="reviews"></div>
            </div>
            
            <div id="reviewWriting">
              <h3 class="bold">Review Writing Header</h3>
              <form action="/WEB289/public/subject.php?subject=<?php if($subject_type == "Science Fiction") { $subject_type = "Science%20Fiction"; } echo($subject_type); ?>" method="post">

                <label class="hidden" for="review_isbn">Review ISBN</label>
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
