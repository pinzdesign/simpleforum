<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<script>
    CKEDITOR.on("click", function(){
        $("#cke_ckedit").css("border", "");
        $("#cke_ckedit").css("box-shadow", "");
    });
function check_ck_empty(e) {
    var ck = $("#cke_ckedit iframe").contents().find("body").text();
    if(ck === "") {
        e.preventDefault();
        $("#cke_ckedit").css("border", "1px solid red");
        $("#cke_ckedit").css("box-shadow", "0px 0px 8px red");
    }
}

function check_field(e, field, limit) {
    if($(field).val() === "" || $(field).val().length > limit) {
        e.preventDefault();
        $(field).css("border", "1px solid red");
        $(field).css("box-shadow", "0px 0px 8px red");
    }
}

$(document).ready(function() {
    if($("#ckedit").length > 0) {
        CKEDITOR.replace('ckedit');
    }
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
</html>