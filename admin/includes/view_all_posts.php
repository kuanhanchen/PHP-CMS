<?php

    include("delete_modal.php");

    // from checkbox in the form, $_POST['checkBoxArray'] = chosen post_id = $postValueId 
    if(isset($_POST['checkBoxArray'])) {
        
        foreach($_POST['checkBoxArray'] as $postValueId ){
            
            $bulk_options = $_POST['bulk_options'];
            
            switch($bulk_options) {
            
                case 'published':
            
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ";
            
                    $update_to_published_status = mysqli_query($connection,$query);       
                    confirmQuery($update_to_published_status);

                    break;
                
                
                case 'draft':
            
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ";
                            
                     $update_to_draft_status = mysqli_query($connection,$query);
                                
                    confirmQuery($update_to_draft_status);

                    break;
                
                
                case 'delete':
            
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}  ";
                            
                    $update_to_delete_status = mysqli_query($connection,$query);
                                
                    confirmQuery($update_to_delete_status);

                    break;


                case 'clone':

                    $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                    $select_post_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_array($select_post_query)) {

                        $post_title         = $row['post_title'];
                        $post_category_id   = $row['post_category_id'];
                        $post_date          = $row['post_date']; 
                        $post_user          = $row['post_user'];
                        $post_status        = $row['post_status'];
                        $post_image         = $row['post_image'] ; 
                        $post_tags          = $row['post_tags']; 
                        $post_content       = $row['post_content'];

                    }

                    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date,post_image,post_content,post_tags,post_status) ";
                 
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') "; 

                    $copy_query = mysqli_query($connection, $query);   

                    if(!$copy_query ) {

                        die("QUERY FAILED" . mysqli_error($connection));
                    }   
                     
                    break;

            }
         
        } 

    }

?>


<form action="" method='post'>

    <table class="table table-bordered table-hover">
              
        <div id="bulkOptionContainer" class="col-xs-4">
            
            <!-- used in line 10 -->
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>

        </div> 
    
        <div class="col-xs-4">
            <!-- link to add_post.php -->
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>

        </div>

        <thead>
            <tr>
                <!-- selectAllboxes function in scripts.js -->
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Users</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Views</th>
            </tr>
        </thead>
                
        <tbody>      
        <?php 
        
        
            
            //$query = "SELECT * FROM posts ORDER BY post_id DESC ";

            // Refactoring our view all posts by JOINING TABLES, so don't need to get $query many times
            // left join returns all rows from the left table (table1), with the matching rows in the right table (table2). The result is NULL in the right side when there is no match.
            $query = "SELECT posts.post_id, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
            $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
            $query .= "FROM posts ";
            $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
            $query .= "ORDER BY posts.post_id DESC";
               
            
            $select_posts = mysqli_query($connection,$query);  

            while($row = mysqli_fetch_assoc($select_posts)) {
                
                $post_id            = $row['post_id'];
                $post_user          = $row['post_user'];
                $post_title         = $row['post_title'];
                $post_category_id   = $row['post_category_id'];
                $post_status        = $row['post_status'];
                $post_image         = $row['post_image'];
                $post_tags          = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date          = $row['post_date'];
                $post_views_count   = $row['post_views_count'];

                // when refactoring by joining tables
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                
                echo "<tr>";
                
        ?>
                <!-- echo checkbox -->
                <!-- $_POST['checkBoxArray[]'] in line 6 -->
                <!-- click -->
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
        
        <?php
                echo "<td>$post_id </td>";
                
                echo "<td>$post_user</td>";

                echo "<td>$post_title</td>";
            
                // get category id, then get category title and echo title
                // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
                // $select_categories_id = mysqli_query($connection,$query);  

                // while($row = mysqli_fetch_assoc($select_categories_id)) {

                //     $cat_id = $row['cat_id'];
                //     $cat_title = $row['cat_title'];

                    echo "<td>$cat_title</td>";
                    
                // }
                
                echo "<td>$post_status</td>";
                
                echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                
                echo "<td>$post_tags</td>";

                // get count_comments from comment table
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);

                $row = mysqli_fetch_array($send_comment_query);
                $comment_id = $row['comment_id'];
                $count_comments = mysqli_num_rows($send_comment_query);

                // update post_cooment_count in posts table
                $query = "UPDATE posts SET ";
                $query .="post_comment_count  = $count_comments ";
                $query .= "WHERE post_id = $post_id ";
                $update_post = mysqli_query($connection,$query);
                confirmQuery($update_post);

                // post_comments.php show all comments of the one post
                echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";

                echo "<td>$post_date</td>";

                echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";
                
                // edit with $_GET['p_id'] and $_GET['source']=edit_post 
                echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

            ?>
            
            <!--  delete method 1 without confirm box-->
            <!-- execute javascript in the bottom in line 255-->
            <!-- <form method="post">

                <input type="hidden" name="post_id" value="<?php //echo $post_id ?>">

                <?php   

                    //echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';

                ?>

            </form> -->

            <?php
            // delete method 2 with javascript and execute delete_modal.php with better confirm box
            // The rel attribute specifies the relationship between the current document and the linked document.
            // delete_modal.php gets id and make a form to use POST to execute delete function
            echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link btn btn-danger'>Delete</a></td>";

            // delete method 3 with javascript and default confirm box
            //echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
            

            // reset
            echo "<td><a href='posts.php?reset={$post_id}'>$post_views_count</a></td>";
            echo "</tr>";
       
        } // while end

      ?>

        </tbody>
    
    </table>
            
</form>
    
<?php 

// delete method 1 without confirm box
// with line 212 form
if(isset($_POST['delete'])){
    
    $the_post_id = escape($_POST['post_id']);
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");
    
}

// reset
// click the number of post_views_count, then become 0
if(isset($_GET['reset'])){
    
    $the_post_id = escape($_GET['reset']);
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $the_post_id  ";
    $reset_query = mysqli_query($connection, $query);
    header("Location: posts.php");
    
}

?> 

<script>
    // delete method 2
    // if delete btn is clicked, execute modal_delete_link.php with the delete_url
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            // rel='$post_id' 
            var id = $(this).attr("rel");

            // method 2-2 pass id to delete_modal.php to use POST
            $(".modal_delete").attr("value", id);


            $("#myModal").modal('show');

        });
    });

    <?php if(isset($_SESSION['message'])){

        unset($_SESSION['message']);

    }

    ?>

</script>
            
            
            
            
            
            
            
      