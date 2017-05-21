<?php ob_start(); ?>
<?php session_start(); ?>

<!-- similar to post.php -->
<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">
                                
                    Welcome to admin
                    
                    <small> 
                        <?php 

                            if(isset($_SESSION['username'])) {

                                echo $_SESSION['username'];

                            }

                            if(is_admin($_SESSION['username'])){

                                echo " (admin)";

                            } else {

                                echo " (subscriber)";

                            }

                        ?>
                        
                    </small>

                </h1>
                
                <?php include "includes/view_all_comments.php"; ?>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
     
<!-- /#page-wrapper -->  
<?php include "includes/admin_footer.php" ?>
