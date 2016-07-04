<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$posts = count_entries($con, $__, "posts", "post_parent", $_REQUEST['id']);
$pages = ceil($posts / 10);

echo "<div id='posts_loadbox'>";
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
                url: "ajax/update_topic.php",
                data: { page: page, id:<?php echo $_REQUEST['id'] ?> }
            }).success(function(result) {
                $('#posts_loadbox').html(result);
            });
        }
    });
</script>
<?php
if(check_rank($con, $__, $_SESSION['user_id'], 100)) {
    show_post_form($_REQUEST['id']);
}
else { show_login(); }?>