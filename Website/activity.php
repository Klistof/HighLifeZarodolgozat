<!DOCTYPE html>
<html lang="hu">
<head>
<?php include('components/head.php'); ?>
    <script src="javascript/activity.js"></script>
    <link rel="stylesheet" href="./designs/users.css">
    <link rel="stylesheet" href="./designs/activity.css">
</head>

<?php include('components/navbar.php'); ?>
<body>
<div class="card" style="margin-top: 40px;margin-left: auto;margin-right:auto;width: 95%;margin-bottom:5%;">
    <h1><i class="fas fa-chart-line"></i> Aktivitás</h1>
    <h1 id="month_placeholder" style="float: right"></h1>
    <hr>

    <canvas id="myChart" style="height: 200px"></canvas>

</div>

</body>
<?php include('components/footer.php'); ?>


