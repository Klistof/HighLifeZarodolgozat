<?php

require '../config.php';
include '../accessories/mail.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $uID=$input['uID'];
    $email=$input['email'];
    $ip=$input['ip'];

    if (empty($uID) || empty($email)) {
        echo json_encode('invalidEmailOruID');
        exit(-1);
    }

    $query = "SELECT * FROM generatetable WHERE uID = \"".$uID."\" OR email = \"".$email."\" ";
    $result = $link->query($query);
    $row = $result->fetch_assoc();

    if ($row == 0) {

        $query = "SELECT * FROM users WHERE uID = \"".$uID."\" OR email = \"".$email."\" ";
        $result = $link->query($query);
        $row = $result->fetch_assoc();

        if ($row == 0) {
            $key = getRandomString(20);
            $query = 'INSERT INTO `generatetable`(`uID`, `key`, `email`) VALUES ("'.$uID.'","'.$key.'","'.$email.'")';
            $result = $link->query($query);

            generateEmail($email,$uID,$key,$ip);

        } else {
            echo json_encode('exist');
        }

    } else {
        echo json_encode('exist');
        exit(-1);
    }
}



?>