<?php
// If you installed via composer, just use this code to require autoloader on the top of your projects.
require 'Medoo.php';
session_start();
 
// Using Medoo namespace
use Medoo\Medoo;
 
$database = new Medoo([
    // required
    'database_type' => 'mysql',
    'database_name' => 'php_final',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
 
    // [optional]
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
    'port' => 3306

]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>GİRİŞ</h1>
    <form action="" method="post">
        email: <input type="text" name="email"><br>
        sifre: <input type="password" name="sifre"><br>
        <input type="submit" value="GİRİŞ">
        <a href="kayit.php">KAYIT</a><br>
        <a href="hatirlat.php">ŞİFREMİ UNUTTUM</a>
    </form>

</body>
</html>
<?php
 $email="";
 $sifre="";
 if(isset($_POST["email"]) && isset($_POST["sifre"])){
    if($_POST["email"]!="" && $_POST["sifre"]!=""){
        $email=$_POST["email"];
        $sifre=$_POST["sifre"];
        $kullanicilar=$database->get("389209_tbl_kullanicilar","*",["AND"=>["email"=>$email,"sifre"=>$sifre]]);
        if($kullanicilar['id']!=""){
            if($kullanicilar['aktif_mi']==1){
                $_SESSION["ID"]=$kullanicilar['id'];
                header('location:panel.php');
                exit;
            }else{
                echo '<script> allert("hesabınız henüz aktif değil.")</script>';
            }
        }else{
            echo '<script> allert("BİLGİLERİNİZ HATALI TEKRAR DENEYİNİZ.")</script>';
        }
    }else{
        echo '<script> allert("lütfen boş alan bırakmayınız. bilgilerinizi eksiksiz girdiğinizden emin olun.")</script>';
    }
 }
?>
