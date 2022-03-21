<?php

require '../config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username=$input['username'];
    $reason = $input['reason'];

    $sql='DELETE FROM `warns` WHERE username ="'.$username.'" AND reason="'.$reason.'"';
    $result = $link->query($sql);

    echo json_encode( "success");
}

?>