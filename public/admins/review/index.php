<?php 

  require_once("../../../private/initialize.php"); 
  require_login();
  require_admin();

  $reviews = Review::find_all();

  include(SHARED_PATH . "/admin-header.php");

?>
    <main>
      <table class="list">
        <tr>
          <th>Review ID</th>
          <th>User ID</th>
          <th>Review ISBN</th>
          <th>Review Text</th>
          <th>Review Date</th>
          <th></th>
          <th></th>
        </tr>

        <?php foreach($reviews as $review) { ?>
          <tr>
            <td><?php echo h($review->review_id); ?></td>
            <td><?php echo h($review->user_id); ?></td>
            <td><?php echo h($review->review_isbn); ?></td>
            <td><?php echo h($review->review_text); ?></td>
            <td><?php echo h($review->review_date); ?></td>
            <td><a class="action" href="<?php echo url_for('admins/review/show.php?current-page=&id=' . h(u($review->review_id))); ?>">Show</a></td>
            <td><a class="action" href="<?php echo url_for('admins/review/delete.php?current-page=&id=' . h(u($review->review_id))); ?>">Delete</a></td>
          </tr>
        <?php } ?>
      </table>
    </main>
  </body>
</html>
