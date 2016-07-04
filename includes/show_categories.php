<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$c = get_categories($con, $__);
foreach ($c as $r) {
?>

<div class='row'>
    <div class="item">
        <div class='col-md-8'>
            <h4><i class='fa fa-folder-o item-icon'></i> <a href='?show=category&id=<?php echo $r['cat_id']; ?>'><?php echo $r['cat_name']; ?></a></h4>
            <p><?php echo $r['cat_desc']; ?></p>
        </div>
        <div class='col-md-4 text-right'>
            <small><i class='fa fa-comment item-icon'></i> Total topics: <?php echo count_entries($con, $__, "topics", "top_parent", $r['cat_id']); ?> <i class="fa fa-user fa-fw item-icon"></i>Created by: <?php echo get_username($con, $__, $r['cat_createdby']); ?></small>
        </div>
    </div>
</div>
<?php } ?>