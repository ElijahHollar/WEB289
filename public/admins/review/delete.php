<?php

require_once("../../../private/initialize.php");

require_login();
require_admin();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admins/category/index.php'));
}

$id = $_GET['id'];

$review = Review::find_by_id($id);

if($review == false) {
  redirect_to(url_for('/admins/category/index.php'));
}

if(is_post_request()) {

  $result = $review->delete();

  $session->message('Review #' . $Review->review_id . ' was deleted successufully.');
  redirect_to(url_for('/admins/category/index.php'));

} else {
  // display the form
}

?>

<?php include(SHARED_PATH . "/category-header.php"); ?>

    <main>
      <a href="<?php echo url_for('admins/review/index.php') ?>">&laquo; Back to List</a>
      
      <h1>Delete Review</h1>
      <p>Are you sure you want to delete this review?<p>

      <form action="<?php echo url_for('/admins/review/delete.php?id=' . h(u($id))); ?>" method="post">
        <input type="submit" value="Delete Review">
      </form>

    </main>
  </body>
</html>
