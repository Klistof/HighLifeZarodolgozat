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
$select = mysqli_query($link,"SELECT * FROM generatetable");

?>
<div class="card">
    <h1><i class="fas fa-envelope"></i> Meghívók kezelése</h1>
    <hr>

    <div class="row">
        <div class="col" style="vertical-align: top;">
                <table class="table table-dark table-striped table-hover" style="text-align: center;">
                    <thead>
                    <tr>
                        <th scope="col">TeamSpeak Azonosító</th>
                        <th scope="col">Email Cím</th>
                        <th scope="col">Műveletek</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row=mysqli_fetch_array($select)) { ?>
                        <tr id = "row:<?php echo $row['uID'];?>">
                            <th><?php echo $row['uID'];?></th>
                            <td><?php echo $row['email'];?></td>
                            <td>
                                <button type='button' class="btn btn-danger" id="removeInvite-<?php echo $row['uID'];?>" value="delete" onclick="removeInvite('<?php echo $row['uID'];?>');"><i class="fas fa-user-times"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
        </div>
    </div>
</div>






</body>
<?php include('components/footer.php'); ?>


