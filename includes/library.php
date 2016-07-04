<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class connector {
    
    public function open_connection($config) {

        $host = $config->host;
        $user = $config->username;
        $pass = $config->password;
        $db = $config->dbname;

        try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
        } catch (PDOException $e) {
            echo "Error!: Could not connect. " . $e->getMessage();
        }
        return $pdo;
    }

    public function close_connection($con) {
        $con = null;
    }
}

/*
 * Runs through a given directory to include files as css or js, needs a way to order files
 *  */
function includeFile($dir, $type) {
    foreach (glob($dir) as $filename) 
    {
        if($type == "js") { echo "<script src='$filename'></script>"; }
        if($type == "css") { echo "<link rel='stylesheet' href='$filename' />"; }
    }
}

function defineDoctype() {
    $xhtml = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
    $html5 = "<!DOCTYPE html>";

    if(preg_match('/MSIE (.*?);/',$_SERVER['HTTP_USER_AGENT']))
    {
        // if IE
        $doctype = $xhtml;
    }
    else
    {
        $doctype = $html5;
    }
    return $doctype;
}

function list_languages($con, $__) {
    $sql = $con->prepare("SELECT set_value FROM ".$__."settings WHERE set_name='language'");
    $sql->execute();
    $row = $sql->fetch();
    $lang = $row['set_value'];
    foreach (glob("lang/*.ini") as $filename)
    {
        $filename_exp = explode("/", $filename);
        $filename = $filename_exp[1];
        if($lang === $filename) { $selected = "selected='selected'"; } else { $selected = ""; }
        echo "<option value='$filename' $selected >$filename</option>";
    }
}

function submit_handler($con, $__) {
    if(isset($_REQUEST['post_submit'])) {
        if($_REQUEST['post_cont'] != "") {
            $sql = $con->prepare("INSERT INTO ".$__."posts SET post_cont=:cont, post_auth=:auth, post_datetime=NOW(), post_parent=:topic");
            $sql->bindParam(":cont", $_REQUEST['post_cont']);
            $sql->bindParam(":auth", $_SESSION['user_id']);
            $sql->bindParam(":topic", $_REQUEST['post_topic']);
            if($sql->execute()) {
                header("Location:?show=topic&id=" . $_REQUEST['post_topic']);
            }
        }
    }
    if(isset($_REQUEST['topic_submit'])) {
        if($_REQUEST['topic_cont'] != "" && $_REQUEST['topic_title'] != "") {
            $q = $con->prepare("INSERT INTO ".$__."topics SET top_name=:name, top_desc=:desc, top_auth=:auth, top_tags=:tags, top_parent=:parent, top_datetime=NOW()");
            $q->bindParam(":name", $_REQUEST['topic_title']);
            $q->bindParam(":desc", $_REQUEST['topic_desc']);
            $q->bindParam(":auth", $_SESSION['user_id']);
            $q->bindParam(":tags", $_REQUEST['topic_tags']);
            $q->bindParam(":parent", $_REQUEST['cat_id']);
            if($q->execute()) {
                $id = $con->lastInsertId();
                $sql = $con->prepare("INSERT INTO ".$__."posts SET post_cont=:cont, post_auth=:auth, post_datetime=NOW(), post_parent=:topic");
                $sql->bindParam(":cont", $_REQUEST['topic_cont']);
                $sql->bindParam(":auth", $_SESSION['user_id']);
                $sql->bindParam(":topic", $id);
                if($sql->execute()) {
                    header("Location:?show=category&id=" . $_REQUEST['cat_id']);
                }
            }
        }
    }
}

function login_handle($con, $__ , $user, $pass) {
    if(isset($_REQUEST['login'])) {
        //$pass = md5($pass);
        $sql = $con->prepare("SELECT user_id FROM ".$__."users WHERE user_username = :name AND user_password = :pass");
        $sql->bindParam(":name", $user);
        $sql->bindParam(":pass", $pass);
        if ($sql->execute()) {
            $row = $sql->fetch();
            $_SESSION['user_id'] = $row['user_id'];
        }
    }
    if(isset($_REQUEST['logout'])) {
        session_destroy();
    }
}

function parse_xml($xmlfile) {
    $xml=simplexml_load_file($xmlfile);
    return $xml;
}

function count_entries($con, $__, $table, $where = null, $value = null) {
    if($where != null && $value != null) { $dyn_q = "WHERE $where = :value"; } else { $dyn_q = ""; }
    $sql = $con->prepare("SELECT COUNT(*) AS result FROM $__$table $dyn_q");
    if($where != null && $value != null) {
        $sql->bindParam(":value", $value);
    }
    if($sql->execute()) {
        $result = $sql->fetch();
        return $result['result'];
    }
}

function load_setting($con, $__ , $setting = "undefined") {
    $sql = $con->prepare("SELECT set_value FROM ".$__."settings WHERE set_name = :setting LIMIT 1");
    $sql->bindParam(":setting", $setting, PDO::PARAM_STR);
    if($sql->execute()) {
        $result = $sql->fetch();
        return $result['set_value'];
    }
    else {
        return false;
    }
}

function get_user($con, $__ , $user_id) {
    $sql = $con->prepare("SELECT * FROM ".$__."users WHERE user_id = :user_id");
    $sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    if ($sql->execute()) {
        $row = $sql->fetch();
        return $row;
    }
    else { return false; }
}

function get_username($con, $__, $user_id) {
    $sql = $con->prepare("SELECT user_id, user_username FROM ".$__."users WHERE user_id = :user_id");
    $sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    if ($sql->execute()) {
        $row = $sql->fetch();
        return "<a href='?show=profile&id=".$row['user_id']."'>". $row['user_username']."</a>";
    }
}

function show_rank($con, $__, $rank_id) {
    $sql = $con->prepare("SELECT rank_name FROM ".$__."ranks WHERE rank_id = :rank_id");
    $sql->bindParam(":rank_id", $rank_id, PDO::PARAM_INT);
    if ($sql->execute()) {
        $row = $sql->fetch();
        return $row['rank_name'];
    }
}

function check_rank($con, $__, $user_id, $weight_chk) {
    $sql = $con->prepare("SELECT * FROM ".$__."users AS main INNER JOIN ".$__."ranks AS t1 ON main.user_rank=t1.rank_id WHERE main.user_id=$user_id");
    if($sql->execute()) {
        $r = $sql->fetch();
        $user_weight = $r['rank_weight'];
        if($user_weight >= $weight_chk) { return true; } else { return false; }
    }
}

function show_menu($con, $__, $user_id) {
    echo "<li><a href='?show=profile&id=".$_SESSION['user_id']."'>Profile</a></li>";
    if(check_rank($con, $__, $user_id, 1000)) { echo "<li><a href='?show=adminpanel'>Adminpanel</a></li>"; }
}

function show_page($con, $__, $page, $user_id, $template = null) {
    if($page == "profile") {
        show_profile($con, $__, $user_id);
    }
    elseif($page == "category") {
        if(!include_once "template/$template/show_category.php") { require_once "includes/show_category.php"; }
    }
    elseif($page == "topic") {
        if(!include_once "template/$template/show_topic.php") { require_once "includes/show_topic.php"; }
    }
    elseif($page == "newtopic") {
        if(!include_once "template/$template/new_topic.php") { require_once "includes/new_topic.php"; }
    }
    elseif($page == "tags") {
        if(!include_once "template/$template/show_tags.php") { require_once "includes/show_tags.php"; }
    }
    else { if(!include_once "template/$template/show_categories.php") { require_once "includes/show_categories.php"; } }
}

function show_profile($con, $__, $user_id = 0) {
    if($user_id > 0) {
        $total_topics = count_entries($con, $__, "topics", "top_auth", $user_id);
        $total_posts = count_entries($con, $__, "posts", "post_auth", $user_id);
        $user = get_user($con, $__, $user_id);
        echo "<div class='row'>"
            . "<div class='col-md-3'><img class='img-user' src='images/users/".$user['user_img']."' alt='profile_img'/></div>"
            . "<div class='col-md-9'>"
                . "<h4>".$user['user_username']." (".show_rank($con, $__, $user['user_rank']).")</h4>"
                . "<p><strong>Email: </strong>".$user['user_email']."</p>"
                . "<p><strong>Registered: </strong>".$user['user_regdate']."</p>"
                . "<p><strong>Total topics: </strong>$total_topics</p>"
                . "<p><strong>Total posts: </strong>$total_posts</p>"
            . "</div>"
        . "</div>";
    }
    else { show_login(); }
}

function get_categories($con, $__) {
    $sql = $con->prepare("SELECT * FROM ".$__."category");
    if($sql->execute()) {
        $result = array();
        while($r = $sql->fetch()) {
            array_push($result, $r);
        }
        return $result;
    }
}

function get_topics($con, $__, $where = "top_parent", $param = true, $offset = 1, $limit = 10) {
    if($where == "top_tags") { $query = "SELECT * FROM ".$__."topics WHERE top_tags LIKE CONCAT('%', :param, '%') ORDER BY top_datetime DESC LIMIT $offset,$limit"; }
    else { $query = "SELECT * FROM ".$__."topics WHERE $where=:param ORDER BY top_datetime DESC LIMIT $offset,$limit"; }
    $sql = $con->prepare($query);
    if($where == "top_tags") { $sql->bindParam(":param", $param, PDO::PARAM_STR); } else { $sql->bindParam(":param", $param, PDO::PARAM_INT); }
    if($sql->execute()) {
        $result = array();
        while($r = $sql->fetch()) {
            array_push($result, $r);
        }
        return $result;
    }
}

function get_posts($con, $__, $top_id, $offset = 1, $limit = 10) {
    $sql = $con->prepare("SELECT * FROM ".$__."posts WHERE post_parent=:top_id ORDER BY post_datetime ASC LIMIT $offset,$limit");
    $sql->bindParam(":top_id", $top_id);
    if($sql->execute()) {
        $result = array();
        while($r = $sql->fetch()) {
            array_push($result, $r);
        }
        return $result;
    }
}

function show_post_form($top_id) {
    if($_SESSION['user_id'] > 0) {
        echo "<form method='post'>"
            . "<input type='hidden' value='$top_id' name='post_topic' />"
            . "<textarea name='post_cont' id='ckedit'></textarea>"
            . "<input type='submit' name='post_submit' onclick='check_ck_empty(event);' class='btn btn-default pull-right' id='post_submit' value='Post' />"
        . "</form>";
        }
        else {
            show_login();
        }
}

function show_tags($tagstring) {
    $tagstring = explode(",", $tagstring);
    foreach ($tagstring as $tag) {
        if($tag != "") {
            echo "<span class='label label-default'><a href='?show=category&tag=$tag'><i class='fa fa-tag'></i>&nbsp;$tag</a></span> ";
        }
    }
}

function show_login() {
    echo '<form method="post">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
            <input class="form-control" name="login_username" type="text" placeholder="username">
        </div>
        <br />
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
            <input class="form-control" name="login_pass" type="password" placeholder="password">
        </div>
        <hr>
        <input class="btn btn-default btn-login pull-right" name="login" type="submit" value="Login" />
        </form>
        ';
}

function show_login_icon() {
    if(isset($_SESSION['user_id'])) {
        echo "<a href='?logout=true'><i class='fa fa-sign-out'></i></a>";
    }
    else {
        echo "<a href='?show=profile'><i class='fa fa-sign-in'></i></a>";
    }
}