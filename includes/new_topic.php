<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$c = $_REQUEST['cat_id'];
$cat_name = get_topics($con, $__, $cat_id);
?>
<form method='post'>
    <h3>New topic in <span style="color: red;"></span>
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <input type="hidden" name="cat_id" value="<?php echo $c; ?>" />
                <label for="topic_title">Title *</label>
                <input type="text" data-toggle="tooltip" title="Max 512 symbols" data-placement="top" id="topic_title" name="topic_title" class="form-control" required="required" placeholder="Title" />
            </div>
            <div class="form-group">
                <label for="topic_desc">Description</label>
                <input type="text" data-toggle="tooltip" title="Max 512 symbols" data-placement="top" name="topic_desc" class="form-control" placeholder="Description"/>
            </div>
            <div class="form-group">
                <label for="topic_tags">Tags</label>
                <input type="text" data-toggle="tooltip" title="Comma separated. Max 512 symbols in total including commas" data-placement="top"name="topic_tags" class="form-control" placeholder="Tags" />
            </div>
            <div class="form-group">
                <label for="topic_cont">Message *</label>
                <textarea id="ckedit" name="topic_cont"></textarea>
            </div>
            <input type="submit" class="btn btn-default" onclick="check_ck_empty(event);check_field(event, '#topic_title');" name="topic_submit" value="Post" />
        </div>
    </div>
</form>