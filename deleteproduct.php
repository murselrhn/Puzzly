<?php
include("dbconnect.php"); 

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    
    $product_id = $_GET['product_id'];

   
    $delete_query = "DELETE FROM TBL_PRODUCT WHERE product_id = $product_id";

 
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        
        echo "Ürün başarıyla silindi.";

        // 2 saniye bekle ve ardından userread.php sayfasına yönlendir
        header("refresh:1;url=productread.php");
    } else {
        echo "Ürün silme işlemi başarısız: " . mysqli_error($con);
    }
} else {
    echo "Geçersiz ürün ID parametresi.";
}

// Veritabanı bağlantısını kapat
mysqli_close($con);
?>

