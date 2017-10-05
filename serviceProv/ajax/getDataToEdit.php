<?php
include_once '../db/configr.php';
include_once '../db/connect.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$key = $_POST['key'];

$query = "SELECT title FROM service_table WHERE user_key = '$key'";
$item = 'title';

$json_array = array();

try{

    $result = mysql_query($query);
    if(mysql_num_rows($result) > 0){

        while ($row = mysql_fetch_assoc($result)) {

            array_push($json_array, $row[$item]);

        }

        $query = "SELECT * FROM nepal WHERE id = (SELECT distinct(nepal_id) FROM service_table WHERE user_key = '$key')";
        $result = mysql_query($query);
        $row = mysql_fetch_row($result);
        $final_data = array($json_array, $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);

        //echo json_encode($json_array);
        echo json_encode($final_data);
    }
    else{
        echo json_encode($json_array);
    }
}
catch(Exception $e){
    echo 'Error Occured during Retrieving Data. thank you';
}
?>
