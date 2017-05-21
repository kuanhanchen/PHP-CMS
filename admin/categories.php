<?php include "includes/admin_header.php" ?>
    
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>
    
    <?php 
        // if not admin, not allowed to enter category page, then redirect to index page
        if(!is_admin($_SESSION['username'])){

            header("Location: index.php");

        }


    ?>

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
                
                <!-- Add Category Form in the left section-->
                <div class="col-xs-6">
                    
                    <!-- insert function from functions.php in admin_header.php -->
                    <?php insert_categories();  ?>
        
                    <form action="" method="post">

                        <div class="form-group">
                            <label for="cat-title">Add Category</label>
                            <input type="text" class="form-control" name="cat_title">
                        </div>

                        <div class="form-group">
                          <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                        </div>

                    </form>
                    
                    <!-- UPDATE AND INCLUDE QUERY -->
                    <?php 

                        if(isset($_GET['edit'])) {
                        
                            $cat_id = $_GET['edit'];
                            
                            include "includes/update_categories.php";
                           
                        }
                                       
                    ?>

                </div><!--Add Category Form end -->

                <!-- Display Current Category Info in the  right section -->
                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php findAllCategories(); ?>
                        </tbody>
                    </table>     
                </div>
                        
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<!-- delete selectd category -->
<?php deleteCategories(); ?>
        
<!-- /#page-wrapper -->
<?php include "includes/admin_footer.php" ?>
