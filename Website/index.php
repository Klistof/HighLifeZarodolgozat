<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include('components/head.php'); ?>
    <script src="javascript/activity.js"></script>
    <link rel="stylesheet" href="./designs/users.css">
    <link rel="stylesheet" href="./designs/activity.css">
    <script src="./javascript/index.js"></script>
    <link rel="stylesheet" href="./designs/index.css">
</head>

<?php include('components/navbar.php'); ?>
<body>
<div class="card">
    <h1><i class="fas fa-home"></i> Áttekintés</h1>

    <hr>

    <div id="keret">
    <h1 style="margin-bottom: 20px;margin-top:-10px;font-size: 20px; margin-left:-5px"> Szia! <?php echo $_COOKIE["username"]?></h1>
        <p> Rankod : <span id="rank"></span> </p>
        <p> Útoljára felcsatlakozva : <span id="seen"></span> </p>
        <p> Csatlakozások száma : <span id="con"></span> </p>
        <p> Figyelmeztetéseid száma : <span id="warns"></span></p>
        <p> Elküldött/Ellenőrzött bizonyítékok száma : <span id="prove"></span></p>

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
                    $query = "SELECT * FROM warns WHERE username = \"".$_COOKIE['username']."\"";

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
                        $query = "SELECT * FROM `log` INNER JOIN users ON users.uID = log.uID WHERE users.username = \"".$_COOKIE['username']."\" AND date like \"".$today."\"";



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
<?php include('components/footer.php'); ?>


