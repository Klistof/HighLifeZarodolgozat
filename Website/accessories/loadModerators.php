<?php
include '../config.php';
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $startDate=$input['startDate'];
    $endDate=$input['endDate'];

    $query = 'SELECT users.username,members.name,COUNT(warns.ID) as warns,users.uID,members.connection,rank,SUM(min) AS min,SUM(activetime) AS activetime,members.lastSeen FROM `users` INNER JOIN members ON members.uID = users.uID INNER JOIN dutytime ON dutytime.uID = users.uID LEFT JOIN warns ON warns.username = users.username WHERE dutytime.date BETWEEN "'.$startDate.'" AND "'.$endDate.'" GROUP BY username ';

    $link->query("SET names utf8");
    $result = $link->query($query);

    $jsonArray = array();

    while($row = $result->fetch_assoc()) {
        $jsonArrayItem = array();
        $jsonArrayItem['username'] = $row['username'];
        $jsonArrayItem['name'] = $row['name'];
        $jsonArrayItem['uID'] = $row['uID'];
        $jsonArrayItem['rank'] = $row['rank'];
        $jsonArrayItem['min'] = $row['min'];
        $jsonArrayItem['connection'] = $row['connection'];
        $jsonArrayItem['warns'] = $row['warns'];
        $jsonArrayItem['activetime'] = $row['activetime'];
        $jsonArrayItem['lastSeen'] = $row['lastSeen'];
        //append the above created object into the main array.
        array_push($jsonArray, mb_convert_encoding($jsonArrayItem,"utf8"));
    }

    $link->close();

    header('Content-type: application/json');

    echo json_encode($jsonArray);
}
?>