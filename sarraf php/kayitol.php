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

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing true enables exceptions
$mail = new PHPMailer(true);

//KOD ÜRETME
$kodOlusturma1 = date('d.m.Y H:i:s');
$kodOlusturma2 = rand(0,20000);
$aktivasyon_dkod = hash('sha256', $kodOlusturma2.$kodOlusturma1);

$ad_soyad="";
$email="";
$sifre="";

$hedef_klasor="yuklenenler/";
$hedef_dosya=$hedef_klasor.basename($_FILES["fileToUpload"]["name"]);
$yuklemeyeUygunluk = 1;
$durum="";

//uygunluk kontrol dosya var mı
if(file_exists($hedef_dosya)){
    $yuklemeyeUygunluk=0;
    $durum.="Aynı dosya Var.";
}

//uygunluk kontrol boyut max 10mb mı (1 mb için x6 sıfır)
if($_FILES["fileToUpload"]["size"]>10000000){
    $yuklemeyeUygunluk=0;
    $durum.="Dosya boyutu 10MB üstünde.";
}

//uygunluk kontrol dosya resim mi
$resimKontrol=mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
if(strpos($resimKontrol, "image") != false){
    $yuklemeyeUygunluk=0;
    $durum.="Resim dosyası değil.";
}

//dosya uzantı uygunluk
$resimDosyaTur = strtolower(pathinfo($hedef_dosya,PATHINFO_EXTENSION));
if($resimDosyaTur!="jpg" && $resimDosyaTur!="jpeg" && $resimDosyaTur!="png" && $resimDosyaTur!="gif"){
    $yuklemeyeUygunluk=0;
    $durum.="png, jpg, jpeg ve gif uzantılı olmalı.";
}

if ($yuklemeyeUygunluk==1){
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $hedef_dosya)){
        if(isset($_POST["ad_soyad"]) && isset($_POST["email"]) && isset($_POST["sifre"])){
            if($_POST["ad_soyad"] !="" && $_POST["email"] !="" && $_POST["sifre"] !="" ){
                $ad_soyad=$_POST["ad_soyad"];
                $email=$_POST["email"];
                $sifre=$_POST["sifre"];

                $database->insert("389209_tbl_kullanicilar",["ad_soyad"=> $ad_soyad, "email"=> $email, "sifre"=>$sifre, "fotograf"=> $hedef_dosya, "aktivasyon"=> $aktivasyon_dkod]);
                $son_eklenen_id = $database->id();
                if($son_eklenen_id>0){
                    #try-catch
                    try {
                        //Server settings
                        $mail->SMTPDebug = 0;      //SMTP::DEBUG_SERVER;             // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'finalitp@gmail.com';                     // SMTP username
                        $mail->Password   = '16101610';                                // SMTP password
                        $mail->CharSet = 'utf-8';
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for PHPMailer::ENCRYPTION_SMTPS above

                        //Recipients
                        $mail->setFrom('finalitp@gmail.com', 'DÖVİZ WEB SİTE');
                        $mail->addAddress($email, $ad_soyad);     // Add a recipient
                        // $mail->addAddress('ellen@example.com');               // Name is optional
                        // $mail->addReplyTo('info@example.com', 'Information');
                        // $mail->addCC('cc@example.com');
                        // $mail->addBCC('bcc@example.com');

                        // Attachments
                        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

// Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Here is the subject';
                        $mail->Body    ='Kayıt olduğunuz için teşekkürler, <br> Hesabınızı aktif etmek için <a href="http://localhost/389209/aktif_@.php?email='.$email.'&kod='.$aktivasyon_dkod.'"><b>tıklayınız</b>.</a>';

                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 

                        $mail->send();
                        echo '<script>alert("Aktivasyon bağlantısı mailiniz gönderilmiştir")</script>';
                        // echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

                    }
                    //e posta gönderme sonu

                }else{
                    echo '<script>alert("Kayıt oluşturulurken hata!Lütfen tekrar deneyiniz.")</script>';
                }
            }else{
              echo '<script>alert("lütfen alanları eksiksiz doldurunuz.")</script>';
            }
        }
    }else {
      echo '<script>alert("HATA!")</script>';
    }
}else{
  echo '<script>alert("kriterler sağlanamadı")</script>';
  echo $durum;
}
?>
                
            }
        }
    }

}
?>