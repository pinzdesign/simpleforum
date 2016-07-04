<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$posts = count_entries($con, $__, "topics", "top_parent", $_REQUEST['id']);
$pages = ceil($posts / 10);

echo "<div id='topics_loadbox'>";
echo "</div>";

echo "<ul id='pagination' class='pagination-sm'>";
echo "</ul>";
?>
<script>
$('#pagination').twbsPagination({
        totalPages: <?php echo $pages; ?>,
        visiblePages: 10,
        //initiateStartPageClick: false,
        onPageClick: function (event, page) {
            $.ajax({
                type: "POST",
                url: "ajax/update_category.php",
                data: { page: page, <?php if($_REQUEST['tag'] != "") { echo "tag: '" . $_REQUEST['tag'] . "'"; } else { echo "id: " . $_REQUEST['id']; } ?> }
            }).success(function(result) {
                $('#topics_loadbox').html(result);
            });
        }
    });
</script>
<?php
if(check_rank($con, $__, $_SESSION['user_id'], 100)) {
?>
<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-default" href="?show=newtopic&cat_id=<?php echo $_REQUEST['id'] ?>">New Topic</a>
    </div>
</div>
<?php } else { show_login(); }?>