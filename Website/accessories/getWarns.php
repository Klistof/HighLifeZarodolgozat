<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query = $link->query("SET names utf8");
    $result = $link->query($query);

    $query = "SELECT * FROM warns";
    $result = $link->query($query);
    $jsonArray = array();
    while ($rows = $result->fetch_assoc()) {
        $jsonArrayItem = array();

        $jsonArrayItem["username"] = $rows["username"];
        $jsonArrayItem["reason"] = $rows["reason"];
        $jsonArrayItem["date"] = $rows["date"];
        $jsonArrayItem["admin"] = $rows["admin"];
        array_push($jsonArray, mb_convert_encoding($jsonArrayItem,"utf8"));
    }

    $link->close();
    header('Content-type: application/json');
    echo json_encode($jsonArray);
}
?>