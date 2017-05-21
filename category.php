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

    if(isset($_GET['category'])){
        
      $post_category_id  = $_GET['category'];

      // if user is admin, show all posts including published and draft in each category
      // 1. Prepare: An SQL statement template is created and sent to the database. Certain values are left unspecified, called parameters (labeled "?"). Example: INSERT INTO MyGuests VALUES(?, ?, ?)
      // 2. The database parses, compiles, and performs query optimization on the SQL statement template, and stores the result without executing it
      // 3. Execute: At a later time, the application binds the values to the parameters, and the database executes the statement. The application may execute the statement as many times as it wants with different values

      //Compared to executing SQL statements directly, prepared statements have two main advantages:

        // 1. Prepared statements reduces parsing time as the preparation on the query is done only once (although the statement is executed multiple times)
        // 2. Bound parameters minimize bandwidth to the server as you need send only the parameters each time, and not the whole query
        // 3. Prepared statements are very useful against SQL injections, because parameter values, which are transmitted later using a different protocol, need not be correctly escaped. If the original statement template is not derived from external input, SQL injection cannot occur.
      if(isset($_SESSION['username']) && is_admin($_SESSION['username'])){

        // A prepared statement is a feature used to execute the same (or similar) SQL statements repeatedly with high efficiency.
        $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

      } else {

          // if log out or subsrciber, only show published posts in each category
          $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");

          $published = 'published';

      }

      if(isset($stmt1)){
        //mysqli_stmt_bind_param(): Binds variables to a prepared statement as parameters
        // types: A string that contains one or more characters which specify the types for the corresponding bind variables:
          // i corresponding variable has type integer
          // d corresponding variable has type double
          // s corresponding variable has type string
          // b corresponding variable is a blob and will be sent in packets
        mysqli_stmt_bind_param($stmt1, "i", $post_category_id);

        mysqli_stmt_execute($stmt1);

        // fetch data
        mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

        $stmt = $stmt1;

      }else {
        // post_category_id is integer: i
        // post_status is string: s
        mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);

        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

        $stmt = $stmt2;

      }

    // if(mysqli_stmt_num_rows($stmt) < 1) {

         // echo "<h1 class='text-center'>No Post available for this category</h1>";

    // } else 

    while(mysqli_stmt_fetch($stmt)):
       
        ?>
        
          <h1 class="page-header">
                 <?php  ?>
                   
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                
   <?php endwhile; 

    mysqli_stmt_close($stmt);  

    }  else {

                // if no category, redirect
                header("Location: index.php");


              }?>

            </div>
            
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>
             
        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>
