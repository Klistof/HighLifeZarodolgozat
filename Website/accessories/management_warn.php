<?php

require '../config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username=$input['username'];
    $admin=$input['admin'];
    $reason = $input['reason'];
    $date = date("Y-m-d H:i:s");


    $sql='SELECT * FROM users WHERE username ="'.$username.'"';
    $result = $link->query($sql);
    if ($result->num_rows != 0)
    {
        $sql = 'INSERT INTO `warns`(`ID`, `username`, `reason`, `date`, `admin`) VALUES (NULL,"'.$username.'","'.$reason.'","'.$date.'","'.$admin.'")';
        $link->query($sql);
        echo json_encode( "success");
    } else {
        echo json_encode( "notexist");
    }
}

?>