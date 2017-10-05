<?php
include_once  'db/configr.php';
include_once 'db/connect.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getData($type){
    $data = array();
    
    $query = "SELECT distinct(".$type.") FROM nepal";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        array_push($data , $row[$type]);
    }
    return $data;
}


    //print_r($data) ;
?>
