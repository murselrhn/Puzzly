<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("dbconnect.php");

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Kullanıcının sepetindeki ürünleri çek
    $cart_query = "SELECT TBL_CART.*, TBL_PRODUCT.product_name, TBL_PRODUCT.product_price
                   FROM TBL_CART
                   INNER JOIN TBL_PRODUCT ON TBL_CART.product_id = TBL_PRODUCT.product_id
                   WHERE TBL_CART.user_id = $user_id";
    $cart_result = mysqli_query($con, $cart_query);

    if ($cart_result) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ödeme formu gönderildiğinde yapılacak işlemler
            $cardNumber = $_POST['cardNumber'];
            $expirationDate = $_POST['expirationDate'];
            $cvv = $_POST['cvv'];
        
            // Burada ödeme işlemlerini gerçekleştirerek TBL_ORDER tablosuna cart_id ekleyebilirsiniz.
            // Örneğin:
        
            // 1. Önce $cart_id'yi almalısınız. Örneğin, son eklenen cart_id'yi alabilirsiniz.
            $get_cart_id_query = "SELECT MAX(cart_id) AS max_cart_id FROM TBL_CART";
            $get_cart_id_result = mysqli_query($con, $get_cart_id_query);
            $cart_id_row = mysqli_fetch_assoc($get_cart_id_result);
            $cart_id = $cart_id_row['max_cart_id'];
        
            // 2. Şimdi $cart_id'yi kullanarak TBL_ORDER tablosuna ekleyebilirsiniz.
            $order_insert_query = "INSERT INTO TBL_ORDER (user_id, cart_id) VALUES ($user_id, $cart_id)";
            $order_insert_result = mysqli_query($con, $order_insert_query);
        
            if ($order_insert_result) {
                echo "Ödeme işlemi başarıyla tamamlandı. Teşekkür ederiz!";
                // İsterseniz başka bir şeyler yapabilirsiniz, örneğin kullanıcıya teşekkür mesajı gösterebilirsiniz.
            } else {
                echo "Ödeme işlemi tamamlanırken bir hata oluştu: " . mysqli_error($con);
            }
        }
    } else {
        echo "Ürünleri getirme hatası: " . mysqli_error($con);
    }
} else {
    echo "Kullanıcı giriş yapmamış.";
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Puzzly</title>
    <meta charset="UTF-8">
    <meta name="description" content="Puzzly">
	<meta name="keywords" content="Puzzly, Puzzle, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->   
    <link href="img/favicon.ico" rel="shortcut icon"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/owl.carousel.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/animate.css"/>
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    
    <!-- Header section -->
    <header class="header-section header-normal">
        <div class="container-fluid">
            <!-- logo -->
            <div class="site-logo">
                <li><a href="index.php"><img src="images/logodeneme.png" width="145" height="50 " alt="logo"></a></li>
            </div>
            <!-- responsive -->
            <div class="nav-switch">
                <i class="fa fa-bars"></i>
            </div>
            <div class="header-right">
                <a href="cart.php" class="card-bag"><img src="images/bag.png" alt=""></a>
                <a href="#" class="search"><img src="images/search.png" alt=""></a>
            </div>
            <!-- site menu -->
            <ul class="main-menu">
                <li><a href="ahşap.php">Ahşap </a></li>
                <li><a href="yetişkin.php">Yetişkin</a></li>
                <li><a href="çocuk.php">Çocuk</a></li>
                <li><a href="3d.php">3D</a></li>
            </ul>
        </div>
    </header>

    <div class="page-area cart-page spad">
        <div class="container">
            <form class="checkout-form" action="" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="checkout-title">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" placeholder="First Name *">
                            </div>
                            <div class="col-md-6">
                                <input type="text" placeholder="Last Name *">
                            </div>
                            <div class="col-md-12">
                                <input type="text" placeholder="Country*">
                            </div>
                            <div class="col-md-12">
                                <input type="text" placeholder="Address *">
                            </div>
                            <div class="col-md-12">
                                <input type="text" placeholder="Zipcode *">
                            </div>
                            <div class="col-md-12">
                                <input type="text" placeholder="City Town *">
                            </div>
                            <div class="col-md-12">
                                <input type="text" placeholder="Province*">
                            </div>
                            <div class="col-md-12">
                                <input type="text" placeholder="Phone no *">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="order-card">
                            <div class="order-details">
                                <div class="od-warp">
                                    <div class="payment-container">
                                        <h2>Payment Information</h2>
                                        <hr>
                                        <label for="cardNumber">Card Number:</label>
                                        <input type="text" id="cardNumber" name="cardNumber" placeholder="Your Credit Card Number" required>
                                        <label for="expirationDate">Expiration Date:</label>
                                        <input type="text" id="expirationDate" name="expirationDate" placeholder="MM/YY" required>
                                        <label for="cvv">CVV:</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="Security Code" required>
                                    </div>
                                </div>
                            </div>
                            <button class="site-btn btn-full" type="submit">Pay</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Page -->

    <!--====== Javascripts & Jquery ======-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/sly.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
