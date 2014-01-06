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
 //   var_dump($_POST);
}

if (!checkPostExists("type") || !checkPostExists("userid")) {
    printError(100);
}

//save POST var
$type = $_POST['type'];
$userid = $_POST['userid'];

// plain text
if ($type == "text") {
    if (!checkPostExists("text")) {
        printError(100);
    }
    $text = $_POST['text'];
    if (strlen($text) > 512) {
        printError(512);
    }
    $text = mysqli_real_escape_string($con, $text);

    $checkquery = "SELECT COUNT(*) AS total FROM data WHERE userid = $userid";
    $result = mysqli_query($con, $checkquery);
    $total = (int) mysqli_fetch_assoc($result)['total'];
    if (DEBUG) {
        //var_dump($total);
    }

    // maxium 10 user uploads
    if ($total >= 10) {
        $deletequery = "DELETE FROM data WHERE "
                . "dataid IN ( SELECT tmp.min FROM (SELECT MIN(dataid)AS min FROM data WHERE userid = $userid) AS tmp);";

        if (mysqli_query($con, $deletequery)) {
            
        } else {
            printError(300);
        }
    }

    $insertQuery = "INSERT INTO data (userid, type, text, url, date)
VALUES ($userid, 'text', '$text', NULL , now())";

    if (mysqli_query($con, $insertQuery)) {
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'SUCCESS', 'code' => 0));
    } else {
        printError(101);
    }
}

mysqli_close($con);
?>