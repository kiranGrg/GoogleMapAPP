<?php

include_once '../db/configr.php';
include_once '../db/connect.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$name = $_POST['place'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$type = $_POST['type'];
$area = $_POST['area'];
try {
    
    $query = "INSERT INTO nepal (id,name,lat,lon,type,area) VALUES (null,'$name','$lat','$lon','$type','$area')";
    if(mysql_query($query)){
        echo "Inserted Successfully!!! And Thanks for Helping Us";
    }
    else{
        echo "Action Failed!!! And Thanks for Helping Though";
    }
    
} catch (Exception $e) {
    //echo $e . getMessage();
    echo "Action Failed!!! And Thanks for Helping Though";
}
?>
