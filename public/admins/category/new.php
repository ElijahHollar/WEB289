<?php

require_once("../../../private/initialize.php");

require_login();
require_admin();

if(is_post_request()) {
  $recaptcha = $_POST['g-recaptcha-response'];
  $res = reCaptcha($recaptcha);
  
  // Validations
  if(!$res['success']){
    $errors['captcha'] = "ReCaptcha Failed.";
  }

  if(empty($errors)) {
    $args = $_POST['category'];

    $args['category_name'] = h($args['category_name']);
  
    $category = new Category($args);
    $result = $category->save();
  
    if($result === true) {
      $new_id = $category->id;
      $session->message("The category was added successfully.");
      redirect_to(url_for("admins/category/index.php"));
    } else {
      // show errors
    }
  }
} else {
  // display the form
  $category = new Category;
}

$captcha_page = true;

?>

<?php include(SHARED_PATH . "/admin-header.php"); ?>

    <main>
      <p class="backlink"><a href="<?php echo url_for('admins/category/index.php') ?>">&laquo; Back to List</a></p>
      
      <h1>Edit Category</h1>

      <form action="<?php echo url_for('admins/category/new.php'); ?>" method="post">

        <label for="category_name">Category:</label>
        <input type="text" id="category_name" name="category[category_name]"> <?php echo display_errors($category->errors); ?>

        <div>
          <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LeNkcQaAAAAAGZjWfi9je8Zt7NnoimBtA_jJ_HB"></div> <?php if(isset($errors['captcha'])) { echo($errors['captcha']); } ?>
        </div>

        <input type="submit" value="Create Category">

      </form>
    </main>
  </body>
</html>
