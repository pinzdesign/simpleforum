<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo defineDoctype();
?>

<html lang="<?php echo load_setting($con, $__ , "language"); ?>">
    <head>
        <title><?php echo load_setting($con, $__ , "title"); ?></title>
        <meta charset="<?php echo load_setting($con, $__ , "charset"); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo load_setting($con, $__ , "description"); ?>">
        <meta name="keywords" content="<?php echo load_setting($con, $__ , "keywords"); ?>">
        <meta name="author" content="<?php echo load_setting($con, $__ , "author"); ?>">
        
        <script src="plugins/jquery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        
        <script src="plugins/pagination/jquery.twbsPagination.min.js" type="text/javascript"></script>
        <script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,600,300,700,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        
        <?php $css = includeFile("template/$template/css/main.css", "css"); ?>
    </head>