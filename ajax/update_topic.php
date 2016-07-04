<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!require_once('../includes/library.php')) {
    echo "Fatal error: library file was not found.";
}
$cfg = parse_xml("../config.xml");
$__ = $cfg->tableprefix;
$__con = new connector();
$con = $__con->open_connection($cfg);
if(isset($_POST['page'])) {
    $page = $_POST['page'];
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $c = get_posts($con, $__, $_REQUEST['id'], $offset, $limit);
}
else {
    $c = get_posts($con, $__, $_REQUEST['id'], 1, 10);
}

foreach($c as $post) {
?>

<div class='row'>
    <div class="item">
        <div class='col-sm-2 text-center'>
            <?php $user = get_user($con, $__,$post['post_auth']);
            echo "<img src='images/users/" . $user['user_img'] . "' alt='img' class='img-user' />";
            echo "<p><a href='?show=profile&id=" . $user['user_id'] . "'>" . $user['user_username'] . "</a></p>";
            ?>
        </div>
        <div class="col-sm-8">
            <article>
                <?php echo $post['post_cont']?>
            </article>
        </div>
        <div class='col-sm-2 text-right'>
            <small><?php echo $post['post_datetime']?></small>
        </div>
    </div>
</div>

<?php }