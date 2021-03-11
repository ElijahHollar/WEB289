<?php 

  require_once("../../../private/initialize.php"); 
  require_login();
  require_admin();

  $categories = Category::find_all();

  include(SHARED_PATH . "/admin-header.php");

?>
    <main>

      <p class="new-btn"><a class="new-btn" href="new.php?current-page=">Add new Category</a></p>

      <table class="list">
        <tr>
          <th>ID</th>
          <th>Category Name</th>
          <th></th>
          <th></th>
        </tr>

        <?php foreach($categories as $category) { ?>
          <tr>
            <td><?php echo h($category->category_id); ?></td>
            <td><?php echo h($category->category_name); ?></td>
            <td><a class="action" href="<?php echo url_for('admins/category/edit.php?current-page=&id=' . h(u($category->category_id))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo url_for('admins/category/delete.php?current-page=&id=' . h(u($category->category_id))); ?>">Delete</a></td>
          </tr>
        <?php } ?>
      </table>
    </main>
  </body>
</html>
