<?php
setcookie("loggedin", "", time() - 3600);
setcookie("level", "", time() - 3600);
setcookie("username", "", time() - 3600);

header("location: ../login.php");
exit;
?>