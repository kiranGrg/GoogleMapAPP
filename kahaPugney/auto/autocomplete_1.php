<?php
include_once '../db/configr.php';
include_once '../db/connect.php';

$type = $_GET['type'];
$area = $_GET['area'];
$names = array();

$query = null;
if (strlen($type) != 0 && strlen($area) != 0) {
    $query = "SELECT name FROM nepal WHERE type = '$type' && area = '$area'";
} else {
    if (strlen($type) == 0 && strlen($area) == 0) {
        $query = "SELECT name FROM nepal";
    }
    else if (strlen($type) != 0) {
        $query = "SELECT name FROM nepal WHERE type = '$type'";
    }

    else if (strlen($area) != 0) {
        $query = "SELECT name FROM nepal WHERE area = '$area'";
    }
}

//echo $query;

$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $names[] = $row['name'];
}
mysql_free_result($result);
mysql_close($link);

// check the parameter
if (isset($_GET['part']) and $_GET['part'] != '') {
    // initialize the results array
    $results = array();

    // search colors
    foreach ($names as $name) {
        // if it starts with 'part' add to results
        if (strpos($name, $_GET['part']) === 0) {
            $results[] = $name;
        }
    }

    // return the array as json with PHP 5.2
    echo json_encode($results);
}