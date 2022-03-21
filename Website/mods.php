<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include('components/head.php'); ?>
    <link rel="stylesheet" href="./designs/users.css">
    <link rel="stylesheet" href="./designs/activity.css">
    <link rel="stylesheet" href="./designs/mods.css">
    <script src="./javascript/mods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.hu.min.js" integrity="sha512-hUj94GVUcMtQpARqIUR1qfiM9hFGW/sOKx6pZVEyuqUSYbjSw/LjQbjuXpFVfKqy8ZeYbDxylIm6D/KIfcJbTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<?php include('components/navbar.php'); ?>
<body>
<div class="card" style="margin-top: 40px;margin-left: auto;margin-right:auto;width: 95%;margin-bottom:5%;">
    <h1><i class="fas fa-list"></i> Moderátor Lista</h1>
    <hr>




    <div id="event_period" style="margin-left: auto">
        <input type="text" autocomplete="off" placeholder="Mettől" id="startDate" class="actual_range btn btn-outline-light btn-lg px-2">
        <input type="text" autocomplete="off" placeholder="Meddig" id="endDate" class="actual_range btn btn-outline-light btn-lg px-z">
        <button class="btn btn-outline-light btn-lg px-5" style="height: 50px" onclick="searchByDate()">Keresés</button>
    </div>
    <br>
    <table id="table_id" class="display table table-dark table-striped table-hover" style="width: 100%">
        <thead>
        <tr>
            <th>Felhasználó név</th>
            <th>Moderátor név</th>
            <th>Azonosító</th>
            <th>Rank</th>
            <th>Szolgálati idő</th>
            <th>Szerveren eltöltött idő</th>
            <th>Csatlakozások</th>
            <th>Figyelmeztetések</th>
            <th>Utoljára csatlakozva</th>
            <th><i class="fas fa-eye"></i></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content" style="background-color: #1c1e21;border-radius: 20px">
            <div class="modal-body" id="content">

            </div>
          
        </div>

    </div>
</div>


</body>
<?php include('components/footer.php'); ?>


