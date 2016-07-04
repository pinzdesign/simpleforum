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
    if(@$_REQUEST['tag'] != "") {
        $c = get_topics($con, $__, "top_tags", $_REQUEST['tag'], $offset, $limit);
    }
    else {
        $c = get_topics($con, $__, "top_parent", $_REQUEST['id'], $offset, $limit);
    }
}
else {
    $c = get_topics($con, $__, "top_parent", $_REQUEST['id'], 1, 10);
}

foreach($c as $cat) {
?>

<div class='row'>
    <div class="item">
        <div class='col-sm-9'>
            <h4>
                <i class='fa fa-comment-o item-icon'></i> <a href='?show=topic&id=<?php echo $cat['top_id']?>'><?php echo $cat['top_name']?></a>
            </h4>
            <p><?php echo $cat['top_desc']?></p>
            <p>
            <?php show_tags($cat['top_tags']); ?>
            </p>
        </div>
        <div class='col-sm-3 text-right'>
            <small><i class="fa fa-clock-o item-icon"></i> <?php echo $cat['top_datetime']?> <i class='fa fa-user item-icon'></i> Created by: <?php echo get_username($con, $__,$cat['top_auth']); ?></small>
        </div>
    </div>
</div>

<?php }