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
$title = $_POST['title'];
$notice = $_POST['notice'];
$service = $_POST['service'];

$key = rand(1000, 6000);

$nepal_id = $_POST['id'];

try{
    
    
    
    if($nepal_id == 0){
        
            $query = "INSERT INTO nepal (id,name,lat,lon,type,area) VALUES (null,'$name','$lat','$lon','$type','$area')";

            if(mysql_query($query)){
                $nepal_id = mysql_insert_id();
                $query = "INSERT INTO service_table (id, title, notice, nepal_id, service, user_key) VALUES (null,'$title','$notice','$nepal_id','$service','$key')";
                mysql_query($query);
                echo "Your Data Inserted Successfully!!!! And your Key is : "+$key+". Please Note it Down.";
            }
            else{
                echo "First Action Failed!!! And Thanks for Helping Though";
            }

    }
    else{
        $query = "INSERT INTO service_table (id, title, notice, nepal_id, service, user_key) VALUES (null,'$title','$notice','$nepal_id','$service','$key')";
        if(mysql_query($query)){
            echo "Your Data Inserted Successfully!!!! And your Key is : "+$key+". Please Note it Down.";
        }
        else{
            echo "Second Action Failed!!! And Thanks for Helping Though";
        }
            
    }
    
}
catch(Exception $e){
    echo "Exception occured: ---> "+$e;
}
?>
