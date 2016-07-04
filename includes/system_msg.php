<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function systemMsg($id, $param = "") {
    switch($id) {
        case 1:
            $lvl = "danger";
            $txt = "File not found";
            if($param != "") { $txt .= ": " . $param; }
            break;
        case 2:
            $lvl = "warning";
            $txt = "File not found";
            if($param != "") { $txt .= ": " . $param; }
            break;
    }
    
    echo "<div class='container-fluid system-message-$lvl'>"
            . "<p>$txt</p>"
            . "</div>";
}