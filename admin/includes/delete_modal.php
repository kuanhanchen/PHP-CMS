<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Delete Box</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Are you sure you want to delete this post?</h3>
      </div>
      <div class="modal-footer">

        <form method="POST">

          <!-- get value=id from view_all_posts.php -->
          <input type="hidden" name="post_id" class="modal_delete">
          
          <input type="button" name="cancel" value="Cancel" class="btn btn-default" data-dismiss="modal">
            
          <input type="submit" name="delete" value="Delete" class="form-group btn btn-danger">

        </form>

        <?php 

          if(isset($_POST['delete'])){

            $the_post_id = escape($_POST['post_id']);
            $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
            $delete_query = mysqli_query($connection, $query);
            header("Location: posts.php");

          }

        ?>
      </div>
    </div>

  </div>
</div>