<?php 

  require_once("../../../private/initialize.php"); 
  require_login();
  require_admin();

  $page_title = 'Bookup Admin: Category Home';

  $categories = Category::find_all();

  $current_page = 'category-home';

  include(SHARED_PATH . "/admin-header.php");

?>

    <main>
      <p class="new-btn"><a class="new-btn" href="new.php">Add new Category</a></p>

      <table class="list">
        <tr>
          <th>ID</th>
          <th>Category Name</th>
          <td></td>
          <td></td>
        </tr>

        <?php foreach($categories as $category) { ?>
          <tr>
            <td><?php echo h($category->category_id); ?></td>
            <td><?php echo h($category->category_name); ?></td>
            <td><a class="action" href="<?php echo url_for('admins/category/edit.php?id=' . h(u($category->category_id))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo url_for('admins/category/delete.php?id=' . h(u($category->category_id))); ?>">Delete</a></td>
          </tr>
        <?php } ?>
      </table>
    </main>
  </body>
</html>
