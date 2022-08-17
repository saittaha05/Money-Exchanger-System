<?php
// If you installed via composer, just use this code to require autoloader on the top of your projects.
require 'Medoo.php';
session_start();
 error_reporting(0);
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
if(!isset($_SESSION["ID"]) || $_SESSION["ID"]==""){
    header("Location:giris.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Listeleme Sayfası</title>
    <style>
	table.redTable {
  border: 2px solid #A40808;
  background-color: #EEE7DB;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.redTable td, table.redTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.redTable tbody td {
  font-size: 13px;
}
table.redTable tr:nth-child(even) {
  background: #F5C8BF;
}
table.redTable thead {
  background: #A40808;
}
table.redTable thead th {
  font-size: 19px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #A40808;
}
table.redTable thead th:first-child {
  border-left: none;
}

table.redTable tfoot td {
  font-size: 13px;
}
table.redTable tfoot .links {
  text-align: right;
}
table.redTable tfoot .links a{
  display: inline-block;
  background: #FFFFFF;
  color: #A40808;
  padding: 2px 8px;
  border-radius: 5px;
}
	
	</style>
</head>
<body>
    <?php include('baglantilar.html'); ?><br>
<!-- Döviz işlemi -->
<form action="" method='POST'>
    <select name="subee">
        <?php
        $subee = $database->select("389209_tbl_sarraflar", "*");
        foreach ($subee as $csube) {
            echo '<option value="'.$csube['id'].'">'.$csube['sarraf'].'</option>';
        }
        ?>
    </select>
    <button type='submit'>LİSTELE</button>
</form>
<table class="redTable">
    <thead>
        <tr>
            <td>ID</td>
            <td>Döviz Adı</td>
            <td>Alış Fiyatı</td>
            <td>Satış Fiyatı</td>
            <td>Sube</td>
        </tr>
    </thead>
    <tbody>
    <?php 
        // Optionda seçilecek olan sarrafa ait olan bütün kayıtları tabloda listeliyoruz
        $dovizler = $database->select("389209_tbl_doviz", "*", ["sube" => $_POST['subee']]);
        $id=1;
        foreach($dovizler as $dovizlerrr){
            $sarrafflar = $database->get("389209_tbl_sarraflar", "*", ["id" => $dovizlerrr["sube"]]);
            echo '
                <tr>
                <td>'.$id.'</td>
                <td>'.$dovizlerrr['doviz_ad'].'</td>
                <td>'.$dovizlerrr['alis_fiyat'].'</td>
                <td>'.$dovizlerrr['satis_fiyat'].'</td>
                <td>'.$sarrafflar['sarraf'].'</td>
            </tr>';
            $id++;
        }
    ?>
    </tbody>
</table>
</body>
</html>