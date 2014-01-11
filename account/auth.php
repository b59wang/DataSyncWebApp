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
        !checkPostExists("password")) {

    // set up header
    header('Content-Type: application/json');
    header('HTTP/1.1 500 Internal Server');
    die(json_encode(array('result' => 'ERROR', "code" => 100)));
}

// save POST var
$username = $_POST['username'];
$password = $_POST['password'];
$function = $_POST['function'];

// determine header
if ($function == "json") {
    // set up header
    header('Content-Type: application/json');
}

// insert into DB
$checkQuery = "SELECT userid,salt,password FROM datasync.users WHERE username = '$username';";

// apply query
$result = mysqli_query($con, $checkQuery);

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        if ($function == "broswer") {
            header("refresh:2;url=../index.php");
            echo "<html><body><p>Wrong username/password, please try again.</p></body></html>";
        } else if ($function == "json") {
            echo json_encode(array('result' => 'ERROR', 'code' => 201));
        }
    } else {
        $row = mysqli_fetch_array($result);
        $hash_pass = hash("sha256", $password . $row['salt']);

        if (DEBUG) {
            var_dump($row);
            var_dump($hash_pass);
        }

        if ($hash_pass == $row['password']) {
            if ($function == "broswer") {
                session_start();
                session_destroy();
                session_start();
                $_SESSION['userid'] = $row['userid'];
                header("refresh:2;url=../gui/index.php");
                echo "<html><body><p>You are now logged in, redirecting you to menu in a second.</p></body></html>";
            } else if ($function == "json") {
                echo json_encode(array('result' => 'SUCCESS', 'code' => 0, 'userid' => $row['userid']));
            }
        } else {
            if ($function == "broswer") {
                header("refresh:2;url=../index.php");
                echo "<html><body><p>Wrong username/password, please try again.</p></body></html>";
            } else if ($function == "json") {
                echo json_encode(array('result' => 'ERROR', 'code' => 201));
            }
        }
    }
} else {
    if ($function == "broswer") {
         header("refresh:5;url=register.php");
        echo "<html><body><p>Problem creating account, please try again.</p></body></html>";
    } else if ($function == "json") {
        // set up header
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'ERROR', 'code' => 101));
    }
}
mysqli_close($con);
?> 