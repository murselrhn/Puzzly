<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel - Products</title>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/adminpanel.min.css" rel="stylesheet">

</head>

    


    <body id="page-top">

<div id="wrapper">


    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminindex.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel </div>
        </a>

        
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Pages
        </div>

        <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Home</span></a>
            </li>

        <li class="nav-item">
            <a class="nav-link" href="productread.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Products</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="userread.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Users</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="orderread.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Order</span></a>
        </li>
    </ul>
 
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            <div class="container-fluid">
            <?php
    include("dbconnect.php");
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $query = "SELECT * FROM TBL_PRODUCT;";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<table border='1'>";
        echo "<tr><th>Product ID</th><th>Name</th><th>Category</th><th>Pieces</th><th>Brand</th><th>Price</th><th>Image</th><th>Quantity</th><th>Actions</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['product_id'] . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td>" . $row['product_category'] . "</td>";
            echo "<td>" . $row['product_pieces'] . "</td>";
            echo "<td>" . $row['product_brand'] . "</td>";
            echo "<td>" . $row['product_price'] . "</td>";
            
            $imagePath = 'uploads/' . $row['product_id'];

            // Dosya adını kontrol et
            if (file_exists($imagePath . '.PNG')) {
                $imagePath .= '.PNG';
            } elseif (file_exists($imagePath . '.png')) {
                $imagePath .= '.png';
            } else {
                // Dosya bulunamazsa, varsayılan bir resim belirleyebilir veya başka bir işlem yapabilirsiniz.
                $imagePath = 'path/to/default-image.png';
            }
            
            echo "<td><img src='$imagePath' style='width: 50px; height: 50px;'></td>";
            
            
            
            echo "<td>" . $row['product_quantity'] . "</td>";
            echo "<td><button onclick='editProduct(".$row['product_id'].")'>Edit</button> <button onclick='deleteProduct(".$row['product_id'].")'>Delete</button></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
    ?>



    <button onclick="addUser()">Add Product</button>

<script>
    function editProduct(productId) {
        window.location.href = 'editproduct.php?product_id=' + productId;
    }

    function deleteProduct(productId) {
        window.location.href = 'deleteproduct.php?product_id=' + productId;
    }

    function addUser() {
        window.location.href = 'addproduct.php';
    }
</script>

            </div>


        </div>
</div>

<script src="js/adminpanel.min.js"></script>
</body>
</html>
