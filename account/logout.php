<?php

/*
  register.php
  created by: Bohao. Dec,2013

  delete session or unregister with the server
 */

// includes
include_once("../includes/functions.php");
include_once("../settings/connect.php");
include_once("../settings/debug.php");


if (DEBUG) {
    var_dump($_POST);
}

// check if post varaible all exists
if (!checkPostExists("function") ||
        !checkPostExists("userid")) {

    session_start();
    if (isset($_SESSION['userid'])) {
        unset($_SESSION['userid']);
        echo "<html><body><p>ByeBye</p></body></html>";
        die();
    } else {
// set up header
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server');
        die(json_encode(array('result' => 'ERROR', "code" => 100)));
    }
}

// save POST var
$function = $_POST['function'];
$username = $_POST['userid'];

if ($function == "android") {
    
}
//TODO add android & other logout pus function


mysqli_close($con);
?> 