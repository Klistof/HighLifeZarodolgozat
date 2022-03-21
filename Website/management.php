<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include('components/head.php'); ?>
    <link rel="stylesheet" href="./designs/users.css">
    <link rel="stylesheet" href="./designs/upload.css">
    <link rel="stylesheet" href="./designs/management.css">
    <script src="./javascript/management.js"></script>
</head>
<?php include('components/navbar.php');

if ($_COOKIE["level"] < 1) {
    header("location: ../index.php");
}

?>
<body onload="showTable()">

<div class="card" style="margin-top: 40px;margin-left: auto;margin-right:auto;width: 95%;margin-bottom:5%;">
    <h1><i class="fas fa-bookmark"></i> Elfogadásra váró bizonyítékok</h1>
    <hr>

    <?php
    $select = mysqli_query($link,"SELECT * FROM upload INNER JOIN users ON users.username = upload.username INNER JOIN members ON members.uID = users.uID");
    ?>

    <table class="row">
        <tr class="col" style="vertical-align: top;">
            <table class="table table-dark table-striped table-hover" style="text-align: center;">
                <thead>
                <tr>
                    <th scope="col">Felhasználó Név</th>
                    <th scope="col">Moderátor Név</th>
                    <th scope="col">Beküldve</th>
                    <th scope="col">Felhasználó Azonosítója</th>
                    <th scope="col">Állapot</th>
                    <th scope="col">Elbiráló személy</th>
                    <th scope="col">Bizonyíték</th>
                    <th scope="col">UCP Kép</th>
                    <th scope="col">Műveletek</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row=mysqli_fetch_array($select)) { if(!empty($row['username'])) {?>
                    <tr>
                        <th><?php echo $row['username'];?></th>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $row['identity'];?></td>
                        <td><?php if($row['aproved']) {echo 'Elfogadva';} else { if ($row['aprovedBy'] == "") {echo 'Elbirálás alatt';} else {echo 'Elutasítva';}}?></td>
                        <td><?php echo $row['aprovedBy'];?></td>
                        <td><img src="<?php echo $row['photoURL'];?>" id="myImg" onclick="showPhoto(this.src)" style="width:10%;max-width:300px"/></td>
                        <td><img src="<?php if ($row['UCP']) {echo $row['UCP'];} else {echo "";}?>" id="myImg" onclick="showPhoto(this.src)" style="width:10%;max-width:300px"/></td>
                        <td>
                            <?php if ($_COOKIE["level"] > 1) {?>
                                <button type='button' class="btn btn-warning" id="delete-<?php echo $row['name'].$row['identity'];?>" value="delete" onclick="manageEvidence('<?php echo $row['name'];?>','<?php echo $row['identity'];?>',3);"><i class="fas fa-trash-alt"></i></button>
                            <?php }?>
                            <?php if ($row['aproved'] == 0 && !$row['aprovedBy']) {?>
                                <button type='button' class="btn btn-success" id="agree-<?php echo $row['name'].$row['identity'];?>" value="agree" onclick="manageEvidence('<?php echo $row['name'];?>','<?php echo $row['identity'];?>',1);"><i class="fas fa-check-circle"></i></button>
                                <button type='button' class="btn btn-danger" id="decline-<?php echo $row['name'].$row['identity'];?>" value="decline" onclick="manageEvidence('<?php echo $row['name'];?>','<?php echo $row['identity'];?>',2);"><i class="fas fa-times-circle"></i></button>
                            <?php }?>
                        </td>
                    </tr>
                <?php } }?>
                </tbody>
            </table>
        </tr>
    </table>

</div>

<div class="card" style="margin-top: 40px;margin-left: auto;margin-right:auto;width: 95%">
    <h1><i class="fas fa-exclamation-triangle"></i> Figyelmeztetés kiosztása</h1>
    <hr>

    <table class="row">
        <tr class="col" style="vertical-align: top;">
            <table id="table_id" class="table table-dark table-striped table-hover" style="text-align: center;">
                <thead>
                <tr>
                    <th scope="col">Felhasználó Név</th>
                    <th scope="col">Indok</th>
                    <th scope="col">Dátum</th>
                    <th scope="col">Személy</th>
                    <th scope="col">Művelet</th>
                </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </tr>
    </table>

        <div class="container">
            <input class="btn btn-outline-light btn-xlg px-5" type="text" name="username" id="username" placeholder="Felhasználónév">
            <input class="btn btn-outline-light btn-xlg px-5" type="text" name="reason" id="reason" placeholder="Indok">
            <input class="btn btn-outline-light btn-xlg px-5" type="button" onclick="sendwarn()" name="send" value="Elküld">
        </div>
</div>


<div id="myModal" class="modal">

    <span class="close">&times;</span>

    <img class="modal-content" id="img01">

    <div id="caption"></div>
</div>


    <script>
        let modal = document.getElementById("myModal");
        let modalImg = document.getElementById("img01");

        function showPhoto(src)
        {
            modal.style.display = "block";
            modalImg.src = src;
        }
        let span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }

    </script>

</body>
<?php include('components/footer.php'); ?>


