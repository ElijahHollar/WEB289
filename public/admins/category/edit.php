<?php

require_once("../../../private/initialize.php");
require_login();
require_admin();

if(!isset($_GET['id'])) {
  redirect_to(url_for('admins/category/index.php'));
}

$id = $_GET['id'];

$category = Category::find_by_id($id);

if($category == false) {
  redirect_to(url_for('admins/category/index.php'));
}

$page_title = 'Bookup Admin: Edit Category ' . $category->category_name;

if(is_post_request()) {
  $recaptcha = $_POST['g-recaptcha-response'];
  $res = reCaptcha($recaptcha);
  
  // Validations
  if(!$res['success']){
    $errors['captcha'] = "ReCaptcha Failed.";
  }
  if(empty($errors)) {
    $args = $_POST['category'];
    $category->merge_attributes($args);
    $result = $category->save();
  
    if($result === true) {
      $session->message("The category was updated successfully.");
      redirect_to(url_for('admins/category/index.php'));
    } else {
      // show errors
    }
  }
} else {
  // display the form
}

$captcha_page = true;

include(SHARED_PATH . "/admin-header.php");

?>

    <main>
      <p class="backlink"><a href="<?php echo url_for('admins/category/index.php') ?>">&laquo; Back to List</a></p>

      <h1>Edit Category: <?php echo($category->category_name); ?></h1>

      <form action="<?php echo url_for('admins/category/edit.php?id=' . h(u($id))); ?>" method="post">
        <label for="category_name">Category:</label>
        <input type="text" id="category_name" name="category[category_name]"> <?php echo display_errors($category->errors); ?>

        <div>
          <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LeNkcQaAAAAAGZjWfi9je8Zt7NnoimBtA_jJ_HB"></div> <?php if(isset($errors['captcha'])) { echo($errors['captcha']); } ?>
        </div>

        <input type="submit" value="Update Category">
      </form>
    </main>
  </body>
</html>
