<!-- similar to view_all_posts.php -->
<?php  

    if(isset($_POST['checkBoxArray'])) {

        foreach($_POST['checkBoxArray'] as $commentValueId ){
        
            $bulk_options = $_POST['bulk_options'];
        
            switch($bulk_options) {
                
                case 'approved':
        
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId}  ";
        
                    $update_to_approved_status = mysqli_query($connection,$query);
            
                    confirmQuery( $update_to_approved_status);
                    break;
            
            
                case 'unapproved':
        
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId}  ";
        
                    $update_to_unapproved_status = mysqli_query($connection,$query);
            
                    confirmQuery($update_to_unapproved_status);
                    break;
            
                
                case 'delete':
        
                    $query = "DELETE FROM comments WHERE comment_id = {$commentValueId}  ";
        
                    $update_to_delete = mysqli_query($connection,$query);
            
                    confirmQuery($update_to_delete);
                    break;

            }

        } 

    }

?>

<form action="" method='post'>
               
    <table class="table table-bordered table-hover">
               
        <div id="bulkOptionContainer" class="col-xs-4">

            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="approved">Approve</option>
                <option value="unapproved">Unapprove</option>
                <option value="delete">Delete</option>
            </select>

        </div> 
            
        <div class="col-xs-4">

            <input type="submit" name="submit" class="btn btn-success" value="Apply">

        </div>

        <thead>
            <tr>
               <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
            </tr>
        </thead>
                
        <tbody>
                      
        <?php 
    
            $query = "SELECT * FROM comments";
            $select_comments = mysqli_query($connection,$query);  

            while($row = mysqli_fetch_assoc($select_comments)) {
        
                $comment_id          = $row['comment_id'];
                $comment_post_id     = $row['comment_post_id'];
                $comment_author      = $row['comment_author'];
                $comment_content     = $row['comment_content'];
                $comment_email       = $row['comment_email'];
                $comment_status      = $row['comment_status'];
                $comment_date        = $row['comment_date'];
            
                echo "<tr>";
        ?>
                <!-- in while loop -->
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>'></td>
          
                <?php
                // comment id
                echo "<td>$comment_id</td>";
                
                // author
                echo "<td>$comment_author</td>";
                
                // content
                echo "<td>$comment_content</td>";       
                
                // email
                echo "<td>$comment_email</td>";
                
                // status
                echo "<td>$comment_status</td>";
        
                // in response to
                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                $select_post_id_query = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($select_post_id_query)){

                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    
                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                }
                
                // date
                echo "<td>$comment_date</td>";

                // approve
                echo "<td><a class='btn btn-primary' href='comments.php?approve=$comment_id'>Approve</a></td>";
                
                // unapprove
                echo "<td><a class='btn btn-info' href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                
                // delete
                echo "<td><a class='btn btn-danger' href='comments.php?delete=$comment_id'>Delete</a></td>";

                echo "</tr>";
           
            }// while end

                ?>
        </tbody>
    </table>     
</form>
            
            
<?php

// approve
if(isset($_GET['approve'])){
    
    $the_comment_id = escape($_GET['approve']);
    
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id   ";
    $approve_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php");
    
}

// unapprove
if(isset($_GET['unapprove'])){
    
    $the_comment_id = escape($_GET['unapprove']);
    
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
    $unapprove_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php");
    
}

// delete
if(isset($_GET['delete'])){
    
    $the_comment_id = escape($_GET['delete']);
    
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: comments.php");
     
}

?>     