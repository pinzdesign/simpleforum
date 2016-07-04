<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<body>
    <noscript>
        <div style="background-color: red;padding: 20px;">Fatal Error - javascript disabled. Many of the forums functions disabled.</div>
    </noscript>
    <div id="top" class="container">
        <div class="jumbotron">
            
        </div>
    </div>
    <div id="mainmenu" class="container">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">WebSiteName</a>
            </div>
            <ul class="nav navbar-nav">
                <?php show_menu($con, $__, $_SESSION['user_id']); ?>
            </ul>
            <div class="pull-right nav-login"><a href="#"><i class="fa fa-envelope-o"></i></a><a href="#"><i class="fa fa-user"></i></a><?php show_login_icon(); ?></div>
        </nav>
    </div>
    <div id="content" class="container">
        <?php show_page($con, $__, $_REQUEST['show'], $_SESSION['user_id'], "basic"); ?>
    </div>
    <div id="bottom" class="container">
        
    </div>
</body>
