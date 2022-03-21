<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//$mail->SMTPDebug = 3; // Tesztelés gomb

function generateEmail($email,$uID,$key,$ip) {
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = '-';
$mail->Password = '-';
$mail->smtpConnect = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );$mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false;


$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->From = 'test@gmail.com';
$mail->FromName = 'HighLife Mod Site';
$mail->addAddress($email);
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

$link = "http://".$ip."/generateAccount.php?u=".$uID."&k=".$key."&e=".$email;

$mail->Subject = 'HighLife Moderation Site - Meghívás';
$mail->Body    = 'Üdvözlünk! <br> 
Ezt a levelet azért kaptad, mert egy vezetőségi tag meghívott az oldalra. <br>
Ha úgy gondolod, hogy tévesen kaptad ezt az e-mailt, akkor semmi dolgod nincs, csak töröld a levelet. <br>
<br>
Ha regisztrálni szeretnél az oldalra, akkor kattints az alábbi linkre, vagy másold a böngésződ címsorába, majd kövesd a megjelenő oldalon az utasításokat: <br>
<a href="'.$link.'">'.$link.'</a> <br>
<br>
Ha hibát jelez az oldal, akkor lehet, hogy a küldő visszavonta a meghívót!<br>
<br>
Üdvözlettel: <br>
A HighLife moderátor csapat
';

if(!$mail->send()) {
    echo json_encode("mailerror");
} else {
    echo json_encode("success");
}
}
