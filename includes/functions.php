<?php

function generateHashWithSalt($password) {
    $intermediateSalt = md5(uniqid(rand(), true));
    $salt = substr($intermediateSalt, 0, 256);
    return hash("sha256", $password . $salt);
}

function generateSalt() {
    $intermediateSalt = md5(uniqid(rand(), true));
    $salt = substr($intermediateSalt, 0, 6);
    return $salt;
}

function checkPostExists($key) {
    return isset($_POST[$key]);
}

function printError($errorno) {
    header('Content-Type: application/json');
    die(json_encode(array('result' => 'ERROR', "code" => $errorno)));
}

?> 