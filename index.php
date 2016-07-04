<?php
ini_set("display_errors", false);
if(!require_once 'includes/library.php') { $sysMsg = "Fatal error: library file not found"; } else { $sysMsg = ""; }
if(!include_once 'includes/system_msg.php') { $sysMsg = "Warning: Error handling file not found"; }

$cfg = parse_xml("config.xml");
$__ = $cfg->tableprefix;
$__con = new connector();
$con = $__con->open_connection($cfg);

$template = load_setting($con, $__ , "template");
session_start();
login_handle($con, $__, $_REQUEST['login_username'], $_REQUEST['login_pass']);

submit_handler($con, $__);

/* Include template header OR just default header */
if(!include_once "template/$template/header.php") {
    if(!require_once "includes/header.php") {
        $sysMsg = systemMsg(1,"includes/header.php");
    }
    //$sysMsg = systemMsg(2,"template/$template/header.php");
}

/* Include template */
if(!include_once "template/$template/default.php") { $sysMsg = systemMsg(1,"template/$template/default.php"); }

/* Include template footer OR just default footer */
if(!include_once "template/$template/footer.php") {
    if(!require_once "includes/footer.php") {
        $sysMsg = systemMsg(1,"includes/footer.php");
    }
    //$sysMsg = systemMsg(2,"template/$template/footer.php");
}