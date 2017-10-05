<?php

include_once '../db/configr.php';
include_once '../db/connect.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$id = $_POST['id'];
if($id == 1){
    $name = $_POST['name'];
    $query = "SELECT * FROM nepal WHERE name = '$name'";
}
else if($id == 2){
    $title = $_POST['title'];
    $table_id = $_POST['stable_id'];
    $query = "SELECT nepal_id,name,lat,lon,type,area,service_table.id, notice FROM nepal,service_table WHERE nepal.id = service_table.nepal_id && title = '$title' && service_table.id = '$table_id'";
}


$result = mysql_query($query);

$json_array = array();
$row_array = array();


while ($row = mysql_fetch_assoc($result)) {
    if($id == 1){
        $row_array['id'] = $row['id'];
    }
    
    $row_array['name'] = $row['name'];
    $row_array['lat'] = $row['lat'];
    $row_array['lon'] = $row['lon'];
    $row_array['type'] = $row['type'];
    $row_array['area'] = $row['area'];
    if($id == 2){
        $row_array['id'] = $row['nepal_id'];
        
        $row_array['service_id']=$row['id'];
        $row_array['notice'] = $row['notice'];
    }
    array_push($json_array, $row_array);
    //     $var = array('id'=>$row['id'], 'name'=>$row['name'], 'lat'=>$row['lat'], 'lon'=>$row['lon'],'type'=>$row['type'], 'area'=>$row['area']); 
}

echo json_encode($json_array);
?>
