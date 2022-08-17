<?php
// Çıkış yapmak isteyen kullanıcının Session'ı sonlandırılıyor
session_start();
$_SESSION["ID"]="";
header('Location: giris.php');
exit;
?>