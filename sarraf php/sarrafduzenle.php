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
    <title>Sarraf Düzenleme Sayfası</title>
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
<!-- Sarraf işlemi -->
<form action="" method='POST'>
    <label for="">Sarraf adı giriniz: </label>
    <?php
        $sarrafcekmee=$database->get("389209_tbl_sarraflar","sarraf", ["id" => $_GET["id"]]);
        echo '<input type="text" name="gsarraf" id="sarraf" value="'.$sarrafcekmee.'">';
    ?>
    <button type='submit'>Düzenle</button>
</form>
<table class="redTable">
    <thead>
        <tr>
            <td>ID</td>
            <td>Sarraf</td>
        </tr>
    </thead>
    <tbody>
    <?php 
        $sarrafId=1;
        $sarraf=$database->select('389209_tbl_sarraflar', '*');
        foreach($sarraf as $sarraff){
            echo '
            <tr>
                <td>'.$sarrafId.'</td>
                <td>'.$sarraff['sarraf'].'</td>
            </tr>';
            $sarrafId++;
        }
    ?>
    </tbody>
</table>
</body>
</html>
<?php 
//Sarraf güncelleme
$gsarraf='';
if (isset($_POST['gsarraf'])) {
    if ($_POST['gsarraf']!='') {
        $gsarraf=$_POST['gsarraf'];
        $data = $database->update("389209_tbl_sarraflar",["sarraf" => $gsarraf],["id" => $_GET["id"]]);
        echo '<script>alert("Güncelleme işlemi başarılı")</script>';
    }else {
        echo '<script>alert("Boş alanlar mevcut")</script>';
    }
}

?>