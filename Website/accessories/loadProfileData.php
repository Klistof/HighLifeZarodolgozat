<?php
include '../config.php';

if (!isset($_GET["target"])) {
    $user = $_COOKIE["username"];
} else {
    $user = $_GET["target"];
}

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = 'SELECT username,connection,name,users.uID,rank,min,activetime,date,members.lastSeen FROM `users` LEFT JOIN members ON members.uID = users.uID LEFT JOIN dutytime ON dutytime.uID = users.uID WHERE username = "'.$user.'"';

$link->query("SET names utf8");
$result = $link->query($query);

$jsonArray = array();

while($row = $result->fetch_assoc()) {
    $jsonArrayItem = array();
    $jsonArrayItem['username'] = $row['username'];
    $jsonArrayItem['name'] = $row['name'];
    $jsonArrayItem['connection'] = $row['connection'];
    $jsonArrayItem['uID'] = $row['uID'];
    $jsonArrayItem['rank'] = $row['rank'];
    $jsonArrayItem['min'] = $row['min'];
    $jsonArrayItem['activetime'] = $row['activetime'];
    $jsonArrayItem['date'] = $row['date'];
    $jsonArrayItem['lastSeen'] = $row['lastSeen'];

    $query2 = 'SELECT COUNT(ID) as "warns" FROM `warns` WHERE username ="'.$user.'";';
    $result2 = $link->query($query2);
    $row2 = $result2->fetch_assoc();
    $jsonArrayItem['warns'] = $row2['warns'];

    $query2 = 'SELECT COUNT(ID) as "upload" FROM `upload` WHERE username ="'.$user.'";';
    $result2 = $link->query($query2);
    $row2 = $result2->fetch_assoc();
    $jsonArrayItem['upload'] = $row2['upload'];

    array_push($jsonArray, mb_convert_encoding($jsonArrayItem,"utf8"));
}

$link->close();

header('Content-type: application/json');

echo json_encode($jsonArray);
?>