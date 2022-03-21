<?php
include 'config.php';

if (!isset($_GET["target"])) {
    $user = $_COOKIE["username"];
} else {
    $user = $_GET["target"];
}

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = 'SELECT username,connection,name,users.uID,rank,min,activetime,date,members.lastSeen FROM `users` INNER JOIN members ON members.uID = users.uID INNER JOIN dutytime ON dutytime.uID = users.uID WHERE username = "'.$user.'"';
session_abort();

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


?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <script src="javascript/activity.js"></script>
    <link rel="stylesheet" href="./designs/users.css">
    <link rel="stylesheet" href="./designs/activity.css">
    <link rel="stylesheet" href="./designs/index.css">
</head>

<body>
<div class="card">
    <h1><i class="fas fa-home"></i> Áttekintés</h1>

    <hr>

    <div id="keret">
        <h1 style="margin-bottom: 20px;margin-top:-10px;font-size: 20px; margin-left:-5px"> Szia! <?php echo $_GET["target"];?></h1>
        <p> Rankod : <span id="rank"><?php echo $jsonArray[0]['rank'];?> </span> </p>
        <p> Útoljára felcsatlakozva : <span id="seen"><?php echo $jsonArray[0]['lastSeen'];?></span> </p>
        <p> Csatlakozások száma : <span id="con"><?php echo $jsonArray[0]['connection'];?></span> </p>
        <p> Figyelmeztetéseid száma : <span id="warns"><?php echo $jsonArray[0]['warns'];?></span></p>
        <p> Elküldött/Ellenőrzött bizonyítékok száma : <span id="prove"><?php echo $jsonArray[0]['upload'];?></span></p>

    </div>

    <div class="container" style="margin-left: auto;margin-right: auto;margin-bottom: 20px">
        <div class="row">
            <div class="col-lg">
                <span style="color:#ff9100; font-weight: bold"><i class="fas fa-exclamation-triangle"></i> Figyelmeztetéseid <i class="fas fa-exclamation-triangle"></i></span>
                <table class="table table-dark table-striped table-hover" style="text-align: center;">
                    <thead>
                    <tr>
                        <th scope="col">Kitől</th>
                        <th scope="col">Indok</th>
                        <th scope="col">Dátum</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM warns WHERE username = \"".$_GET["target"]."\"";

                    $result = $link->query($query);
                    while($rows = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo "<td>".$rows['admin']."</td>";
                        echo "<td>".$rows['reason']."</td>";
                        echo "<td>".$rows['date']."</td>";
                        echo '</tr>';
                    }

                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg">
                <span style="color:#0033ff; font-weight: bold"><i class="fas fa-link"></i> Csatlakozásaid <i class="fas fa-link"></i></span>
                <table class="table table-dark table-striped table-hover" style="text-align: center;">
                    <thead>
                    <tr>
                        <th scope="col">Felcsatlakozás</th>
                        <th scope="col">Lecsatlakozás</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $today = date("Y-m");
                    $today = $today."%";
                    $query = "SELECT * FROM `log` INNER JOIN users ON users.uID = log.uID WHERE users.username = \"".$_GET["target"]."\" AND date like \"".$today."\"";



                    $result = $link->query($query);
                    while($rows = $result->fetch_assoc()) {

                        if ($rows['date'])
                            echo '<tr>';
                        echo "<td>".$rows['joined']."</td>";
                        echo "<td>".$rows['leaved']."</td>";
                        echo '</tr>';
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>