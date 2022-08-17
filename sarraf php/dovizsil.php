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
    $silinecekdoviz=$_GET["id"];
    $dovizsilme=$database->get("389209_tbl_doviz","*", ["id" => $silinecekdoviz]);
    if($dovizsilme>0){
        $data = $database->delete("389209_tbl_doviz", ["id" => $silinecekdoviz]);
        echo '<script>alert("Kayıt silme başarılı.")</script>';
    }else{
        header('Location: panel.php?m=dovizsilmehatasi');
    }
}
?>