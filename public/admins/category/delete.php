<?php

require_once("../../../private/initialize.php");

require_login();
require_admin();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admins/category/index.php'));
}

$id = $_GET['id'];

$category = Category::find_by_id($id);

if($category == false) {
  redirect_to(url_for('/admins/category/index.php'));
}

if(is_post_request()) {

  $result = $category->delete();

  $session->message($category->category_name . ' category was deleted successufully.');
  redirect_to(url_for('/admins/category/index.php'));

} else {
  // display the form
}

?>

<?php include(SHARED_PATH . "/category-header.php"); ?>

    <main>
      <a href="<?php echo url_for('admins/category/index.php') ?>">&laquo; Back to List</a>
    
      <h1>Delete Category</h1>
      <p>Are you sure you want to delete this category?<p>

      <form action="<?php echo url_for('/admins/category/delete.php?id=' . h(u($id))); ?>" method="post">
        <input type="submit" value="Delete Category">
      </form>

    </main>
  </body>
</html>
