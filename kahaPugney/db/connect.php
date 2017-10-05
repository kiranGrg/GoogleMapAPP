<?php
include_once 'configr.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$link = mysql_connect(SERVER, USERNAME, PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db(DATABASE)) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}
?>
