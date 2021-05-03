<?php

require_once("../../../private/initialize.php");

require_login();
require_admin();

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$review = Review::find_by_id($id);
$admin = Admin::find_by_id($review->user_id);

$page_title = 'Bookup Admin: View Review #' . $review->review_id;

include(SHARED_PATH . '/admin-header.php');

?>

    <main>

      <p class="backlink"><a href="<?php echo url_for('admins/review/index.php') ?>">&laquo; Back to List</a></p>
      
      <h1>Review: <?php echo("#" . $review->review_id) ?></h1>

      <ul class="attributes">
        <li>
          <p>Posted By: <?php echo($admin->user_username) ?></p>
        </li>

        <li>
          <p>Posted On: <?php echo($review->review_date) ?></p>
        </li>

        <li>
          <p>Book Reviewed: <?php echo($review->review_isbn) ?></p>
        </li>

        <li>
          <p>Review Text:<br> <?php echo($review->review_text) ?></p>
        </li>
      </ul>

    </main>
  </body>
</html>
