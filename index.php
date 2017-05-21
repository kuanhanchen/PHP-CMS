<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
               
                <?php

                    $per_page = 10;

                    // get from pagagination, code in the bottom of this php
                    if(isset($_GET['page'])) {

                        $page = $_GET['page'];

                    } else {

                        $page = "";

                    }

                    if($page == "" || $page == 1) {

                        // e.g. click $page=1, display 0-10, limit 0, $page_1 = 0
                        $page_1 = 0;

                    } else {

                        // e.g. click $page=5, display 41-50, limit 40, $page_1 = 40
                        $page_1 = ($page * $per_page) - $per_page;

                    }

                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {

                        // if user is admin, show all posts including published and draft
                        $post_query_count = "SELECT * FROM posts";

                    } else {

                        // if log out or subsrciber, only show published posts
                        $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";

                    }   

                    $find_count = mysqli_query($connection,$post_query_count);
                    $count = mysqli_num_rows($find_count);

                    if($count < 1) {
                        // without pagination
                        echo "<h1 class='text-center'>No posts available</h1>";

                    } else {
                        //e.g. 4.2=>5
                        $count  = ceil($count /$per_page);
                            
                        $query = "SELECT * FROM posts LIMIT $page_1, $per_page";

                        $select_all_posts_query = mysqli_query($connection,$query);

                        // display all posts
                        while($row = mysqli_fetch_assoc($select_all_posts_query)) {

                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_user'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];

                            // limit to display smaller content
                            $post_content = substr($row['post_content'], 0, 400);
                            $post_status = $row['post_status'];
        
                ?>
                            <!-- put these code into while loop -->
                            <!-- First Blog Post -->
                            <!-- title -->
                            <!-- link to post.php with this post_id, only show this one post -->
                            <h2>
                                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                            </h2>
                            
                            <!-- author -->
                            <!-- link to author_posts.php to show all this author's posts -->
                            <p class="lead">
                                by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                            </p>
                            
                            <!-- date -->
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                            
                            <hr>
                            
                            <!-- image -->
                            <a href="post.php?p_id=<?php echo $post_id; ?>">

                                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">

                            </a>
                            
                            <hr>
                            
                            <!-- content -->
                            <p><?php echo $post_content ?></p>
                            
                            <!-- read more, redirect depending on id -->
                            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>   

                <?php }  } ?>
                <!-- else end -->
                <!-- while end -->

            </div>
            
<!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php";?>  

        </div>
        <!-- /.row -->

        <hr>
        
        <!-- pagination -->
        <ul class="pager">

        <?php 

            $number_list = array();

            for($i =1; $i <= $count; $i++) {

                if($i == $page) {

                    // css in style.css, display which page u are in with black background
                    echo "<li '><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";

                }  else {

                    echo "<li '><a href='index.php?page={$i}'>{$i}</a></li>";

                }
               
            }

         ?>

        </ul>

   
<?php include "includes/footer.php";?>
