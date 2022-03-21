<?php

require '../config.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $uID=$input['uID'];
        $action=$input['typ'];

        $sql="";
        switch ($action) {
            case 1: $sql = "UPDATE users SET level = level-1 WHERE uID = \"".$uID."\""; echo json_encode("rankdown");break;
            case 2: $sql = "UPDATE users SET level = level+1 WHERE uID = \"".$uID."\""; echo json_encode("rankup");break;
            case 3: $sql = "DELETE FROM users WHERE uID = \"".$uID."\""; echo json_encode("delete"); break;
        }
        $link->query($sql);
    }
?>