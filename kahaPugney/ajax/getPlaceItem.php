<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../db/configr.php';
include_once '../db/connect.php';

//$area = $_POST['area'];
$id = $_POST['id'];
$type = "";
$query = "";
$item = "";

switch($id){
    case 1:
        $area = $_POST['area'];
        $query = "SELECT distinct(type) FROM nepal WHERE area = '$area'";
        $item = "type";
        break;
    case 2:
        $area = $_POST['area'];
        $type = $_POST['type'];
        $query = "SELECT name FROM nepal WHERE area = '$area' && type = '$type'";
        $item = "name";
        break;
    case 3:
        $type = $_POST['type'];
        $query = "SELECT distinct(name) FROM nepal, service_table WHERE nepal.id = service_table.nepal_id && type = '$type' && service = 'yes'";
        $item  = 'name';
}

$result = mysql_query($query);
$data = array();
while($row = mysql_fetch_assoc($result)){
    array_push($data, $row[$item]);
}

echo json_encode($data);
?>
