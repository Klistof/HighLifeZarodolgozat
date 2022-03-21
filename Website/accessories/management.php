<?php

require '../config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $uID=$input['uID'];
    $action=$input['typ'];
    $user=$input['username'];
    $identity = $input['identity'];


    $sql="";
    switch ($action) {
        case 1: $sql = "UPDATE upload SET aproved = 1, aprovedBy = \"".$user."\" WHERE username = \"".$uID."\" AND identity = \"".$identity."\""; echo json_encode("agree");break;
        case 2: $sql = "UPDATE upload SET aprovedBy = \"".$user."\" WHERE username = \"".$uID."\" AND identity = \"".$identity."\""; echo json_encode("decline");break;
        case 3:

        $sql = "SELECT photoURL FROM upload WHERE username = \"".$uID."\" AND identity = \"".$identity."\"";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        $tmpfile = $row['photoURL'];
        $tmpfile2 = $row['UCP'];

        echo json_encode("delete");
        unlink($tmpfile);
        unlink($tmpfile2);
        $sql = "DELETE FROM upload WHERE username = \"".$uID."\" AND identity = \"".$identity."\"";
        break;
    }
    $link->query($sql);
}
?>