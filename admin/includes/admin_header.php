<?php ob_start(); ?>
<?php session_start(); ?>

<?php include "../includes/db.php"; ?>
<?php include "functions.php"; ?>

<!-- ob_start() turns on output buffering -->
<!-- While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer. -->
<!-- The contents of this internal buffer may be copied into a string variable using ob_get_contents(). To output what is stored in the internal buffer, use ob_end_flush(). Alternatively, ob_end_clean() will silently discard the buffer contents. -->

<?php 
    
    if(isset($_SESSION['user_role'])) {


    } else {
        // means no _SESSION and log out, so redirect to index.php
        //header() sends a raw HTTP header to a client.
        header("location: ../index.php");

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Adding a LOADER to the CMS Admin -->
    <link href="css/styles.css" rel="stylesheet">
    
    <!-- for index.php, google charts -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- tinyMCE editor, video 174 -->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    
    <script src="js/jquery.js"></script>

    <script src="js/scripts.js"></script>
    
    

</head>

<body>



