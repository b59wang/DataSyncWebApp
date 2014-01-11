<?php

/*
  register.php
  created by: Bohao. Dec,2013

  register an account to the server
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
        !checkPostExists("username") ||
        !checkPostExists("fullname") ||
        !checkPostExists("email") ||
        !checkPostExists("password")) {

    // set up header
    header('Content-Type: application/json');
    header('HTTP/1.1 500 Internal Server');
    die(json_encode(array('result' => 'ERROR', "code" => 100)));
}

// save POST var
$function = $_POST['function'];
$username = $_POST['username'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];

// obtain salt & hashed password
$salt = generateSalt();
$hash_pass = hash("sha256", $password . $salt);

// insert into DB
$insertQuery = "INSERT INTO users (username, fullname, email, password, salt, join_date)
VALUES ('$username', '$fullname', '$email', '$hash_pass', '$salt', now())";

// apply query
if (mysqli_query($con, $insertQuery)) {
    if ($function == "broswer") {
        echo "<html><body><center><p>Your account has been created, click <a href='../index.html'> here </a> to login.</p></center></body></html>";
    } else if ($function == "json") {
        // set up header
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'SUCCESS', 'code' => 0));
    }
} else {
    if ($function == "broswer") {
        echo "<html><body><center><p>Problem creating account, please try again with another username.</p> "
        . "<p> Click <a href='../register.php'> here </a> to try again.</p></center></body></html>";
    } else if ($function == "json") {
        // set up header
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'ERROR', 'code' => 101));
    }
}
mysqli_close($con);
?> 