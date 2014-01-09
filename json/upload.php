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
include_once ("../settings/upload_type.php");

if (DEBUG) {
    //   var_dump($_POST);
}

if (!checkPostExists("type") || !checkPostExists("userid") || !checkPostExists("text")) {
    printError(100);
}

//save POST var
$type = $_POST['type'];
$userid = $_POST['userid'];
$text = $_POST['text'];
if (strlen($text) > 512) {
    printError(512);
}

// plain text
if ($type == "text") {
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
} else if ($type == "file") {
    if ($_FILES["file"]["error"] > 0) {
        printError(301);
    } else {
        if (DEBUG) {
            var_dump($_FILES);
            var_dump($_FILES["file"]["type"]);
        }
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "application/pdf") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 5 * 1000 * 1000) && in_array($extension, $allowedExts)) {
            if (!file_exists('../files/' . $userid)) {
                mkdir('../files/' . $userid, 0777, true);
            }
            $savedURL = "C:/wamp/www/DataSyncWebApp/files/" . $userid . "/" . $_FILES["file"]["name"];
            $insertURL = "../files/" . $userid . "/" . $_FILES["file"]["name"];
            $now = date("YmdHis");
            if (file_exists($savedURL)) {
                $savedURL = "C:/wamp/www/DataSyncWebApp/files/" . $userid . "/" . $now . $_FILES["file"]["name"];
                $insertURL = "../files/" . $userid . "/" . $now . $_FILES["file"]["name"];
                if (DEBUG) {
                    var_dump($savedURL);
                }
            }
            move_uploaded_file($_FILES["file"]["tmp_name"], $savedURL);

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
VALUES ($userid, 'file', '$text', '$insertURL' , now())";

            if (mysqli_query($con, $insertQuery)) {
                header('Content-Type: application/json');
                echo json_encode(array('result' => 'SUCCESS', 'code' => 0));
            } else {
                printError(101);
            }
        } else {
            printError(302);
        }
    }
}

mysqli_close($con);
?>