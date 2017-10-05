<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../db/configr.php';
include_once '../db/connect.php';

$type = $_POST['type'];

$query = "SELECT name FROM nepal WHERE type = '$type'";
$item = "name";

$result = mysql_query($query);
$data = array();
while($row = mysql_fetch_assoc($result)){
    array_push($data, $row[$item]);
}

echo json_encode($data);
?>
