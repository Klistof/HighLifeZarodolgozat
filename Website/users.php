<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include('components/head.php'); ?>
    <link rel="stylesheet" href="./designs/users.css">
    <script src="./javascript/users.js"></script>
</head>
<?php include('components/navbar.php');

    if ($_COOKIE["level"] < 2) {
        header("location: ../index.php");
    }


?>
<body>

<?php
$select = mysqli_query($link,"SELECT * FROM users INNER JOIN members ON members.uID = users.uID");
?>
<div class="card">
    <h1><i class="fas fa-book-dead"></i> Felhasználói fiókok kezelése</h1>
    <hr>

    <table class="row">
        <tr class="col" style="vertical-align: top;">
                <table class="table table-dark table-striped table-hover" style="text-align: center;">
                    <thead>
                    <tr>
                        <th scope="col">Felhasználó Név</th>
                        <th scope="col">Email Cím</th>
                        <th scope="col">uID</th>
                        <th scope="col">Moderátor Becenév</th>
                        <th scope="col">Utoljára csatlakozva</th>
                        <th scope="col">Admin szint</th>
                        <th scope="col">Műveletek</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row=mysqli_fetch_array($select)) { if(!empty($row['username'])) {?>
                        <tr id = "row:<?php echo $row['uID'];?>">
                            <th><?php echo $row['username'];?></th>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['uID'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['lastSeen'];?></td>
                            <td id="rank:<?php echo $row['uID'];?>"><?php echo $row['level']; ?></td>
                            <td>
                                <?php if ($row['username'] != $_COOKIE["username"]) { ?>
                                <button type='button' class="btn btn-danger" id="delete_button-<?php echo $row['uID'];?>" value="delete" onclick="memberManagment('<?php echo $row['uID'];?>',3);"><i class="fas fa-user-times"></i></button>
                                <?php ?>
                               <?php if ($row['level'] <= 2 && $row['level'] > 0) { ?>
                                <button type='button' class="btn btn-warning" id="rankdown-<?php echo $row['uID'];?>" value="rankdown" onclick="memberManagment('<?php echo $row['uID'];?>',1);"><i class="fas fa-chevron-down"></i></button>
                                <?php }?>
                                <?php if ($row['level'] >= 0 && $row['level'] < 2) { ?>
                                    <button type='button' class="btn btn-primary" id="rankup-<?php echo $row['uID'];?>" value="rankup" onclick="memberManagment('<?php echo $row['uID'];?>',2);"><i class="fas fa-chevron-up"></i></button>
                                <?php }}?>
                            </td>
                        </tr>
                    <?php } }?>
                    </tbody>
                </table>
        </tr>
        <tr class="col" style="float:right">
                <div class="row d-flex">
                    <div class="col-md-12">
                        <div class="card px-3 py-2">
                            <h5 class="mt-3">Új felhasználó hozzáadása</h5>
                            <div class="form-input"> <i class="fa fa-envelope"></i> <input type="text" id="email" class="form-control" placeholder="Email Cím"> </div>
                            <div class="form-input"> <i class="fa fa-user"></i> <input type="text" id="ts" class="form-control" placeholder="TeamSpeak azonosító"> </div>
                            <button class="btn btn-primary mt-4 signup" onclick="addNewUser()">Meghívó elküldése</button>
                        </div>
                    </div>
                </div>
        </tr>
    </table>
</div>






</body>
<?php include('components/footer.php'); ?>


