<?php

/*
  register.php
  created by: Bohao. Dec,2013

  upload text/video/photo to the server
 */

// includes
include_once("../includes/functions.php");
include_once("../settings/connect.php");
include_once("../settings/debug.php");

if (DEBUG) {
    //var_dump($_POST);
}

if (!checkPostExists("userid")) {
    printError(100);
}

//save POST var
$userid = $_POST['userid'];

$query = "SELECT * FROM data WHERE userid = $userid";
$result = mysqli_query($con, $query);
if ($result) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
       array_push($output,$row);
    }
    echo(json_encode(array('result' => 'SUCCESS', "info" => $output)));
} else {
     printError(201);
}

mysqli_close($con);
?>