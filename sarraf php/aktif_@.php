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
if(isset($_GET["email"]) && isset($_GET["kod"])){
    $email=$_GET["email"];
    $kod=$_GET["kod"];
    //Kayıt işlemi yapmalıyız
    $user=$database->get("389209_tbl_kullanicilar","id", ["AND" =>["email" => $email, "aktivasyon" => $kod]]);
    if($user>0){
        //aktivasyon yap
        $data = $database->update("389209_tbl_kullanicilar",["aktif_mi" => 1],["id" => $user]);
        header('Location:panel.php');
    }else{
        header('Location:giris.php?m=kullanici_hata');
    }
}
?>
