<?php
include("dbconnect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen diğer verileri al
    $product_name = $_POST["product_name"];
    $product_category = $_POST["product_category"];
    $product_pieces = $_POST["product_pieces"];
    $product_brand = $_POST["product_brand"];
    $product_price = $_POST["product_price"];
    $product_quantity = $_POST["product_quantity"];

    // Resim yükleme işlemi
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Resmi kontrol et
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check !== false) {
            echo "Dosya bir resim - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Dosya bir resim değil.";
            $uploadOk = 0;
        }
    }

    // Dosya zaten var mı kontrol et
    if (file_exists($target_file)) {
        echo "Üzgünüz, dosya zaten var.";
        $uploadOk = 0;
    }

    // Dosya boyutunu kontrol et (örneğin 500 KB)
    if ($_FILES["product_image"]["size"] > 5000000) {
        echo "Üzgünüz, dosya çok büyük.";
        $uploadOk = 0;
    }

    // İzin verilen dosya türlerini kontrol et (örneğin sadece jpg, jpeg, png)
    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Üzgünüz, sadece JPG, JPEG, PNG dosyalarına izin verilir.";
        $uploadOk = 0;
    }

    // Hata varsa mesajı göster
    if ($uploadOk == 0) {
        echo "Üzgünüz, dosyanız yüklenmedi.";
    // Başarılıysa resmi yükle ve veritabanına kaydet
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // SQL sorgusu
            $insert_query = "INSERT INTO TBL_PRODUCT (product_name, product_category, product_pieces, product_brand, product_price, product_quantity, product_image) VALUES ('$product_name', '$product_category', $product_pieces, '$product_brand', $product_price, $product_quantity, '$target_file')";

            // Sorguyu çalıştır
            $result = mysqli_query($con, $insert_query);

            if ($result) {
                echo "Ürün başarıyla eklendi.";
                header("Location: productread.php"); // Sayfayı yeniden yönlendir
            } else {
                echo "Ürün eklenirken bir hata oluştu: " . mysqli_error($con);
            }
        } else {
            echo "Üzgünüz, dosya yüklenirken bir hata oluştu.";
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
</head>

<body>

    <h2>Ürün Ekle</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="product_name">Ürün Adı:</label>
        <input type="text" name="product_name" required><br>

        <label for="product_category">Ürün Kategori:</label>
        <input type="text" name="product_category" required><br>

        <label for="product_pieces">Ürün Adedi:</label>
        <input type="number" name="product_pieces" required><br>

        <label for="product_brand">Ürün Marka:</label>
        <input type="text" name="product_brand" required><br>

        <label for="product_price">Ürün Fiyat:</label>
        <input type="text" name="product_price" required><br>

        <label for="product_quantity">Ürün Miktarı:</label>
        <input type="number" name="product_quantity" required><br>

        <label for="product_image">Ürün Resmi:</label>
        <input type="file" name="product_image" accept="image/*" required><br>

        <input type="submit" value="Ekle">
    </form>
    </body>

</html>
