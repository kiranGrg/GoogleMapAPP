<?php

require '../map/config.php';
$name = $_POST['name'];
//$name = 'ekantakuna';
try {
    $json_array = array();
    $row_array = array();
    $connection = mysql_connect($server, $username, $password)
            or die("Failed in Connection");

    $selectdb = mysql_select_db($database, $connection)
            or die("Failed in Selecting DB");

    $query = "SELECT * FROM nepal";
    $result = mysql_query($query);
    $var;
    while ($row = mysql_fetch_assoc($result)) {
        $row_array['id'] = $row['id'];
        $row_array['name'] = $row['name'];
        $row_array['lat'] = $row['lat'];
        $row_array['lon'] = $row['lon'];
        $row_array['type'] = $row['type'];
        $row_array['area'] = $row['area'];
        //array_push($json_array, $row_array);
        array_push($json_array, array('id'=>$row['id'], 'name' => $row['name']));
   //     $var = array('id'=>$row['id'], 'name'=>$row['name'], 'lat'=>$row['lat'], 'lon'=>$row['lon'],'type'=>$row['type'], 'area'=>$row['area']); 
    }

    echo json_encode($json_array);
} catch (Exception $e) {

    echo $e . getMessage();
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>