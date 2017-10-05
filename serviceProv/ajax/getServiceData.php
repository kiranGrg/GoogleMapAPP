<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../db/configr.php';
include_once '../db/connect.php';

$title = $_POST['title'];
$key = $_POST['key'];

$query = "SELECT notice, service FROM service_table WHERE title = '$title' && user_key = '$key'";

$row = mysql_fetch_row(mysql_query($query));

echo json_encode(array($row[0], $row[1]));

?>
