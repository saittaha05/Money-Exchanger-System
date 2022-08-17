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
    <title>Panel Sayfası</title>
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
<!-- Sarraf işlemi -->
<form action="" method='POST'>
    Sarraf adı giriniz: <input type="text" name="sarraf" id="sarraf"><br>
    <button type='submit'>Ekle</button>
</form>
<table class="redTable">
    <thead>
        <tr>
            <td>ID</td>
            <td>Sarraf</td>
            <td>Silme</td>
            <td>Düzenleme</td>
        </tr>
    </thead>
    <tbody>
    <?php 
        $iid=1;
        $sarraf=$database->select('389209_tbl_sarraflar', '*');
        foreach($sarraf as $sarraff){
            echo '
            <tr>
                <td>'.$iid.'</td>
                <td>'.$sarraff['sarraf'].'</td>
                <td><a href="sarrafsil.php?id='.$sarraff["id"].'"><button type="button" style="color:red;">Sil</button></a></td>
                <td><a href="sarrafduzenle.php?id='.$sarraff["id"].'"><button type="button" style="color:blue;">Düzenle</button></a></td>
            </tr>';
            $iid++;
        }
    ?>
    </tbody>
</table><br><br><br>
<!-- Döviz işlemi -->
<form action="" method='POST'>
    Döviz adını giriniz: <input type="text" name="dovizad" id="dovizad"><br>
    Alış Fiyatı : <input type="text" name="alisfiyati" id="alisfiyati"><br>
    Satış Fiyatı : <input type="text" name="satisfiyati" id="satisfiyati"><br>
    Şube seçiniz:
    <select name="sube">
        <?php
        $subee = $database->select("389209_tbl_sarraflar", "*");
        foreach ($subee as $csube) {
            echo '<option value="'.$csube['id'].'">'.$csube['sarraf'].'</option>';
        }
        ?>
    </select><br>
    <button type='submit'>Ekle</button>
</form>
<table class="redTable">
    <thead>
        <tr>
            <td>ID</td>
            <td>Döviz Adı</td>
            <td>Alış Fiyatı</td>
            <td>Satış Fiyatı</td>
            <td>Şube</td>
            <td>Silme</td>
            <td>Düzenleme</td>
        </tr>
    </thead>
    <tbody>
    <?php
        $idd=1;
        $dovizz=$database->select('389209_tbl_doviz', '*');
        foreach($dovizz as $dovizzz){
            $subecek=$database->get('389209_tbl_sarraflar','*',["id"=>$dovizzz['sube']]);
            echo '
            <tr>
                <td>'.$idd.'</td>
                <td>'.$dovizzz['doviz_ad'].'</td>
                <td>'.$dovizzz['alis_fiyat'].'</td>
                <td>'.$dovizzz['satis_fiyat'].'</td>
                <td>'.$subecek['sarraf'].'</td>
                <td><a href="dovizsil.php?id='.$dovizzz["id"].'"><button type="button" style="color:red;">Sil</button></a></td>
                <td><a href="dovizduzenle.php?id='.$dovizzz["id"].'"><button type="button" style="color:blue;">Düzenle</button></a></td>
            </tr>';
            $idd++;
        }
    ?>
    </tbody>
</table>
</body>
</html>
<?php 
//Sarraf ekleme
$ysarraf='';
if (isset($_POST['sarraf'])) {
    if ($_POST['sarraf']!='') {
        $ysarraf=$_POST['sarraf'];
        $database->insert("389209_tbl_sarraflar",["sarraf"=>$ysarraf]);
        $sonEklenenid = $database->id();
        if ($sonEklenenid>0) {
            echo '<script>alert("Kayıt başarılı bir şekilde eklendi.")</script>';
        }else {
            echo '<script>alert("Kayıt beklerken hata oluştu.")</script>';
        }
    }else {
        echo '<script>alert("Boş alanlar mevcut")</script>';
    }
}

// Döviz ekleme
$ydovizad='';
$yalisfiyat='';
$ysatisfiyat='';
$ysube='';
if (isset($_POST['dovizad']) && isset($_POST['alisfiyati']) && isset($_POST['satisfiyati']) && isset($_POST['sube'])) {
    if ($_POST['dovizad']!='' && $_POST['alisfiyati']!='' && $_POST['satisfiyati']!='' && $_POST['sube']!='') {
        $ydovizad=$_POST['dovizad'];
        $yalisfiyat=$_POST['alisfiyati'];
        $ysatisfiyat=$_POST['satisfiyati'];
        $ysube=$_POST['sube'];
        $database->insert("389209_tbl_doviz",["doviz_ad"=>$ydovizad, "alis_fiyat"=>$yalisfiyat, "satis_fiyat"=>$ysatisfiyat, "sube"=>$ysube]);
        $sonEklenenid = $database->id();
        if ($sonEklenenid>0) {
            echo '<script>alert("Kayıt başarılı bir şekilde eklendi.")</script>';
        }else {
            echo '<script>alert("Kayıt beklerken hata oluştu.")</script>';
        }
    }else {
        echo '<script>alert("Boş alanlar mevcut")</script>';
    }
}


?>