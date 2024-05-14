<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Edit</title>
</head>
<body>

<?php
include("dbconnect.php");

if(isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Form gönderildiyse güncelleme işlemini yap
        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $product_pieces = $_POST['product_pieces'];
        $product_brand = $_POST['product_brand'];
        $product_price = $_POST['product_price'];
        $product_quantity = $_POST['product_quantity'];

        $update_query = "UPDATE TBL_PRODUCT
                         SET product_name = '$product_name', product_category = '$product_category', product_pieces = '$product_pieces', 
                             product_brand = '$product_brand', product_price = '$product_price', product_quantity = '$product_quantity'
                         WHERE product_id = $product_id";

        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            echo "Ürün başarıyla güncellendi.";
            header("refresh:2;url=productread.php");
        } else {
            echo "Ürün güncelleme işlemi başarısız: " . mysqli_error($con);
        }
    } else {
        // Form gönderilmediyse, mevcut kullanıcı verilerini getir ve düzenleme formunu göster
        $select_query = "SELECT * FROM TBL_PRODUCT WHERE product_id = $product_id";
        $result = mysqli_query($con, $select_query);

        if ($result) {
            $product_data = mysqli_fetch_assoc($result);
            ?>
            <h2>Edit Product</h2>
            <form method="post" action="">
                <label for="product_name">Name:</label>
                <input type="text" name="product_name" value="<?php echo $product_data['product_name']; ?>"><br>

                <label for="product_category">Category:</label>
                <input type="text" name="product_category" value="<?php echo $product_data['product_category']; ?>"><br>

                <label for="product_pieces">Pieces:</label>
                <input type="number" name="product_pieces" value="<?php echo $product_data['product_pieces']; ?>"><br>

                <label for="product_brand">Brand:</label>
                <input type="text" name="product_brand" value="<?php echo $product_data['product_brand']; ?>"><br>

                <label for="product_price">Price:</label>
                <input type="text" name="product_price" value="<?php echo $product_data['product_price']; ?>"><br>

                <label for="product_quantity">Quantity:</label>
                <input type="number" name="product_quantity" value="<?php echo $product_data['product_quantity']; ?>"><br>

                <input type="submit" value="Update">
            </form>
            <?php
        } else {
            echo "Ürün bilgilerini getirme hatası: " . mysqli_error($con);
        }
    }
} else {
    echo "Geçersiz Ürün ID parametresi.";
}

mysqli_close($con);
?>

</body>
</html>
