<?php

include_once '../db/configr.php';
include_once '../db/connect.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$name = $_POST['name'];

$query = "SELECT * FROM nepal, service_table WHERE nepal.id = service_table.nepal_id && name = '$name'";
$json_array = array();
        
try{
        if(mysql_num_rows(mysql_query($query)) == 0 ){
            $query = "SELECT * FROM nepal WHERE name = '$name'";
            $result = mysql_query($query);
            
            
            $row_array = array();
            
            while ($row = mysql_fetch_assoc($result)) {
                $row_array['id'] = $row['id'];
                $row_array['name'] = $row['name'];
                $row_array['lat'] = $row['lat'];
                $row_array['lon'] = $row['lon'];
                $row_array['type'] = $row['type'];
                $row_array['area'] = $row['area'];
                array_push($json_array, $row_array);
                //     $var = array('id'=>$row['id'], 'name'=>$row['name'], 'lat'=>$row['lat'], 'lon'=>$row['lon'],'type'=>$row['type'], 'area'=>$row['area']); 
            }

            echo json_encode($json_array);
            
        }
        else{
            echo json_encode($json_array);
        }
}
catch(Exception $e){
    echo "Mysql Exception Occurred. Pls Check";
}
?>
