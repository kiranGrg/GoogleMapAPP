<?php

include_once '../db/configr.php';
include_once '../db/connect.php';
$query = '';
$type = $_POST['type'];
$area = $_POST['area'];
if ($type != "" && $area != "") {
    $query = "SELECT * FROM nepal WHERE type='$type' && area='$area'";
} else {
    if ($type == "" && $area == "") {
        $query = "SELECT * FROM nepal";
    } else if ($type != "") {
        $query = "SELECT * FROM nepal WHERE type='$type'";
    } else if ($area != "") {
        $query = "SELECT * FROM nepal WHERE area='$area'";
    }
}

try {
    $json_array = array();
    $row_array = array();

    $result = mysql_query($query);
    //if($result) {
        while ($row = mysql_fetch_assoc($result)) {
            $row_array['id'] = $row['id'];
            $row_array['name'] = $row['name'];
            $row_array['lat'] = $row['lat'];
            $row_array['lon'] = $row['lon'];
            $row_array['type'] = $row['type'];
            $row_array['area'] = $row['area'];
            array_push($json_array, $row_array);
        }
        echo json_encode($json_array);
//    }else {
//        echo "no data";
//    }
} catch (Exception $e) {

    echo $e . getMessage();
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>