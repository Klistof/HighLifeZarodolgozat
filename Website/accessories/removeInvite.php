<?php

require '../config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $uID=$input['uID'];

    $sql="DELETE FROM generatetable WHERE uID = \"".$uID."\"";

    $link->query($sql);

    echo json_encode("success");
}
?>