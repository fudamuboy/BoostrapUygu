<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hobiler";
    
    try {
        // PDO bağlantısı oluşturuluyor
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Yeni veri ekleme işlemi
            if (isset($_POST["ad"]) && isset($_POST["soyad"]) && isset($_POST["mail"]) && isset($_POST["cinsiyet"])) {
                $ad = $_POST["ad"];
                $soyad = $_POST["soyad"];
                $mail = $_POST["mail"];
                $cinsiyet = $_POST["cinsiyet"];
                $hobiler = isset($_POST["hobiler"]) ? json_encode($_POST["hobiler"], JSON_UNESCAPED_UNICODE) : null;
    
                // `4` tablo ismini backtick ile çevreledik
                $sql = "INSERT INTO `4` (ad, soyad, mail, cinsiyet, hobi)
                        VALUES (:ad, :soyad, :mail, :cinsiyet, :hobiler)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':ad', $ad);
                $stmt->bindParam(':soyad', $soyad);
                $stmt->bindParam(':mail', $mail);
                $stmt->bindParam(':cinsiyet', $cinsiyet);
                $stmt->bindParam(':hobiler', $hobiler);
    
                $stmt->execute();
                echo "Yeni kayıt başarıyla eklendi.<br>";
            }
    
            // Veri silme işlemi
            if (isset($_POST["sil_mail"])) {
                $sil_mail = $_POST["sil_mail"];
    
                $sql = "DELETE FROM `4` WHERE mail = :sil_mail";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':sil_mail', $sil_mail);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    echo "Kayıt başarıyla silindi.<br>";
                } else {
                    echo "Kayıt silinemedi.<br>";
                }
            }
    
            // Veri güncelleme işlemi
            if (isset($_POST["guncelle_ad"]) && isset($_POST["yeni_soyad"]) && isset($_POST["yeni_mail"])) {
                $guncelle_ad = $_POST["guncelle_ad"];
                $yeni_soyad = $_POST["yeni_soyad"];
                $yeni_mail = $_POST["yeni_mail"];
    
                $sql = "UPDATE `4` SET soyad = :yeni_soyad, mail = :yeni_mail WHERE ad = :guncelle_ad";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':guncelle_ad', $guncelle_ad);
                $stmt->bindParam(':yeni_soyad', $yeni_soyad);
                $stmt->bindParam(':yeni_mail', $yeni_mail);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    echo "Kayıt başarıyla güncellendi.<br>";
                } else {
                    echo "Güncelleme işlemi başarısız.<br>";
                }
            }
        }
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
    
    // Bağlantıyı kapat
    $conn = null;
    ?>
