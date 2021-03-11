<?php

require_once("../../../private/initialize.php");

require_login();
require_admin();

if(is_post_request()) {

  $args = $_POST['category'];

  $category = new Category($args);
  $result = $category->save();

  if($result === true) {
    $new_id = $category->id;
    $session->message("The category was added successfully.");
    redirect_to(url_for("admins/category/index.php?current-page=category-home"));
  } else {
    // show errors
  }

} else {
  // display the form
  $category = new Category;
}

?>

<?php include(SHARED_PATH . "/admin-header.php"); ?>


    <main>
      <p class="backlink"><a href="<?php echo url_for('admins/category/index.php?current-page=category-home') ?>">&laquo; Back to List</a></p>
      
      <h1>Edit Category</h1>

      <?php echo display_errors($category->errors); ?>

      <form action="<?php echo url_for('admins/category/new.php?current-page='); ?>" method="post">

        <label for="category_name">Category:</label>
        <input type="text" id="category_name" name="category[category_name]">

        <input type="submit" value="Create Category">

      </form>
      

    </main>
  </body>
</html>
