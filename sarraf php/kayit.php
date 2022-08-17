<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>giriş</title>
</head>
<body>
    <form action="kayitol.php" method="post" enctype="multipart/form-data">
        ad_soyad : <input type="text" name ="ad_soyad"><br>
        e-mail : <input type="text" name="email"><br>
        sifre: <input type="text" name="sifre"><br>
        fotograf: 
        <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
        <input type="submit" value="kayıt ol">
        
</form> 
    <a href="giris.php"><input type="submit" value="giriş yap"></a>

    
</body>
</html>