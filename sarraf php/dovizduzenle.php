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
    <title>Döviz Düzenleme Sayfası</title>
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
<?php include('baglantilar.html'); ?>
<!-- Döviz işlemi -->
<form action="" method='POST'>
    <?php
        $dovizcekmee=$database->get("389209_tbl_doviz","*", ["id" => $_GET["id"]]);
        echo '
        <input type="text" name="gdovizad" id="gdovizad" value="'.$sdovizcekmee['doviz_ad'].'"><br>
        <input type="text" name="galisfiyati" id="galisfiyati" value="'.$sdovizcekmee['alis_fiyat'].'"><br>
        <input type="text" name="gsatisfiyati" id="gsatisfiyati" value="'.$sdovizcekmee['satis_fiyat'].'"><br>
        ';
    ?>
    <select name="gsube">
        <?php
        $subee = $database->select("389209_tbl_sarraflar", "*");
        foreach ($subee as $csube) {
            echo '<option value="'.$csube['id'].'">'.$csube['sarraf'].'</option>';
        }
        ?>
    </select>
    <button type='submit'>Düzenle</button>
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
        $dovizId=1;
        $dovizz=$database->select('389209_tbl_doviz', '*');
        foreach($dovizz as $dovizzz){
            $subecek=$database->get('389209_tbl_sarraflar','*',["id"=>$dovizzz['sube']]);
            echo '
            <tr>
                <td>'.$dovizId.'</td>
                <td>'.$dovizzz['doviz_ad'].'</td>
                <td>'.$dovizzz['alis_fiyat'].'</td>
                <td>'.$dovizzz['satis_fiyat'].'</td>
                <td>'.$subecek['sarraf'].'</td>
            </tr>';
            $dovizId++;

        }
    ?>
    </tbody>
</table>
</body>
</html>
<?php 
// Döviz güncelleme
$gdovizad='';
$galisfiyat='';
$gsatisfiyat='';
$gsube='';
if (isset($_POST['gdovizad']) && isset($_POST['galisfiyati']) && isset($_POST['gsatisfiyati']) && isset($_POST['gsube'])) {
    if ($_POST['gdovizad']!='' && $_POST['galisfiyati']!='' && $_POST['gsatisfiyati']!='' && $_POST['gsube']!='') {
        $gdovizad=$_POST['gdovizad'];
        $galisfiyat=$_POST['galisfiyati'];
        $gsatisfiyat=$_POST['gsatisfiyati'];
        $gsube=$_POST['gsube'];
        $database->update("389209_tbl_doviz",["doviz_ad"=>$gdovizad, "alis_fiyat"=>$galisfiyat, "satis_fiyat"=>$gsatisfiyat, "sube"=>$gsube],["id"=>$_GET["id"]]);
        echo '<script>alert("Güncelleme işlemi başarılı bir şekilde gerçekleşti.")</script>';
    }else {
        echo '<script>alert("Boş alanlar mevcut")</script>';
    }
}
?>