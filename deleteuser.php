<?php
include("dbconnect.php"); // Veritabanı bağlantısını sağlayan dosyanızı ekleyin

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    // URL'den gelen 'user_id' parametresini kontrol et
    $user_id = $_GET['user_id'];

    // Kullanıcıyı silen SQL sorgusu
    $delete_query = "DELETE FROM TBL_USERS WHERE user_id = $user_id";

    // Sorguyu çalıştır
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        // Kullanıcı başarıyla silindi.
        echo "Kullanıcı başarıyla silindi.";

        // 2 saniye bekle ve ardından userread.php sayfasına yönlendir
        header("refresh:1;url=userread.php");
    } else {
        echo "Kullanıcı silme işlemi başarısız: " . mysqli_error($con);
    }
} else {
    echo "Geçersiz kullanıcı ID parametresi.";
}

// Veritabanı bağlantısını kapat
mysqli_close($con);
?>

