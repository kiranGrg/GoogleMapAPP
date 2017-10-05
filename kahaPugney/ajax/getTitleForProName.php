<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../db/configr.php';
include_once '../db/connect.php';

$name = $_POST['name'];
//$query = "SELECT title FROM nepal, service_table WHERE nepal.id = service_table.nepal_id && service = 'yes' && nepal.name = '$name'";
//$item = "title";
//
//$result = mysql_query($query);
//$data = array();
//while($row = mysql_fetch_assoc($result)){
//    array_push($data, $row[$item]);
//}
//
//echo json_encode($data);

$query = "SELECT service_table.id, title FROM nepal, service_table WHERE nepal.id = service_table.nepal_id && service = 'yes' && nepal.name = '$name'";
//$item = "title";

$result = mysql_query($query);
$id = array();
$title = array();
while($row = mysql_fetch_row($result)){
    array_push($id, $row[0]);
    array_push($title, $row[1]);
}

echo json_encode(array($id, $title));
?>
