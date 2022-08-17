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
error_reporting(0);

if(isset($_GET["id"])){
    $silineceksarraf=$_GET["id"];
    $sarrafsilme=$database->get("389209_tbl_sarraflar","*", ["id" => $silineceksarraf]);
    $dovizsilme=$database->get("389209_tbl_doviz","*", ["sube" => $silineceksarraf]);
    if($sarrafsilme>0){
        $data = $database->delete("389209_tbl_sarraflar", ["id" => $silineceksarraf]);
        $datta = $database->delete("389209_tbl_doviz", ["sube" => $silineceksarraf]);
        echo '<script>alert("Kayıt silme başarılı.")</script>';
    }else{
        header('Location: panel.php?m=sarrafsilmehatasi');
    }
}
?>