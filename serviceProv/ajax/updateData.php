<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../db/configr.php';
include_once '../db/connect.php';

$area = '';
$lat = 0.0;
$lon = 0.0;
$title = '';
$new_title = '';
$notice = '';
$service = '';
$key = 0;
$id = 0;

$query = '';

$action_type = $_POST['action'];
switch ($action_type){
    case 1:
        $area = $_POST['area'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];
        $id = $_POST['id'];
        $query = "UPDATE nepal SET lat = '$lat', lon = '$lon', area = '$area' WHERE id = '$id'";
        break;
    case 2:
        $title = $_POST['title'];
        $notice = $_POST['notice'];
        $service = $_POST['service'];
        $key = $_POST['key'];
        $query = "UPDATE service_table SET notice = '$notice', service = '$service' WHERE title = '$title' && user_key = '$key'";
        break;
    case 3:
        $new_title = $_POST['title'];
        $notice = $_POST['notice'];
        $service = $_POST['service'];
        $key = $_POST['key'];
        $id = $_POST['id'];
        $query = "INSERT INTO service_table (id, title, notice, nepal_id, service, user_key) VALUES(null,'$new_title','$notice','$id','$service','$key')";
        break;
}

if(mysql_query($query)){
    echo "Successful";
}
else
{
    echo "Unsuccessful";
}

?>
