<?php
include("dbconnect.php");

session_start();

// Kullanıcı giriş yapmışsa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Kullanıcının sepetindeki ürünleri çek
    $cart_query = "SELECT TBL_CART.*, TBL_PRODUCT.product_name, TBL_PRODUCT.product_price
                   FROM TBL_CART
                   INNER JOIN TBL_PRODUCT ON TBL_CART.product_id = TBL_PRODUCT.product_id
                   WHERE TBL_CART.user_id = $user_id";
    $cart_result = mysqli_query($con, $cart_query);

    if ($cart_result) {
        ?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Puzzly</title>
	<meta charset="UTF-8">
	<meta name="description" content="Puzzly">
	<meta name="keywords" content="Puzzly, Puzzle, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.css"/>
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/animate.css"/>



</head>
<body>

	<div id="preloder">
		<div class="loader"></div>
	</div>
	
	
	<header class="header-section header-normal">
		<div class="container-fluid">
			
			<div class="site-logo">
				<img src="images/logodeneme.png" width="145" height="50 " alt="logo">
			</div>
			
			<div class="nav-switch">
				<i class="fa fa-bars"></i>
			</div>
			<div class="header-right">
				<a href="cart.php" class="card-bag"><img src="images/bag.png" alt=""></a>
				
			</div>
		
			<ul class="main-menu">
				<li><a href="ahşap.php">Ahşap</a></li>
				<li><a href="yetişkin.php">Yetişkin</a></li>
				<li><a href="çocuk.php">Çocuk</a></li>
				<li><a href="3d.php">3D</a></li>
			</ul>
		</div>
	</header>




	<div class="page-info-section page-info">
		<div class="container">
			<div class="site-breadcrumb">
				<a href="index.php">Home</a> /  
				<span>Cart</span>
			</div>
		
		</div>
	</div>
	


	<div class="page-area cart-page spad">
                <div class="container">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-th">Product</th>
                                    <th>Price</th>
                                
                                    <th class="total-th">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalPrice = 0;

                                while ($cart_data = mysqli_fetch_assoc($cart_result)) {
                                    ?>
                                    <tr>
                                        <td class="product-col">
                                            <img src="uploads/<?php echo $cart_data['product_id']; ?>.PNG" alt="">
                                            <div class="pc-title">
                                                <h4><?php echo $cart_data['product_name']; ?></h4>
                                            </div>
                                        </td>
                                        <td class="price-col">$<?php echo $cart_data['product_price']; ?></td>
                                        <td class="quy-col">
                                        >
                                        </td>
                                        <td class="total-col">$<?php
                                            $itemTotal = $cart_data['product_price'] * "1";
                                            echo $itemTotal;
                                            $totalPrice += $itemTotal;
                                        ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
			
		</div>
		<div class="card-warp">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<div class="shipping-info">
							<h4>Shipping method</h4>
							<p> </p>
							<div class="shipping-chooes">
								
								<div class="sc-item">
									<input type="radio" name="sc" id="two">
									<label for="two">Standard delivery<span>Free</span></label>
								</div>
								
							</div>
						
						</div>
					</div>
					<div class="offset-lg-2 col-lg-6">

					<div class="cart-total-details">
                        <h4>Toplam Fiyat</h4>
						<ul class="cart-total-card">
                        <li><p><?php echo "$" . $totalPrice; ?></p></li></ul>
                        <a class="site-btn btn-full" href="checkout.php">Ödemeye İlerle</a>
                    </div>
                </div>
						
							
							
						
						
					
				</div>
			</div>
		</div>
	</div>
	


	
	<section class="footer-top-section home-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-8 col-sm-12">
					<div class="footer-widget about-widget">
						<img src="images/logodeneme.png" class="footer-logo" alt="">
						<p>Donec vitae purus nunc. Morbi faucibus erat sit amet congue mattis. Nullam fringilla faucibus urna, id dapibus erat iaculis ut. Integer ac sem.</p>
						<div class="cards">
							<img src="images/5.png" alt="">
							<img src="images/4.png" alt="">
							<img src="images/3.png" alt="">
							<img src="images/2.png" alt="">
							<img src="images/1.png" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-6">
					<div class="footer-widget">
						<h6 class="fw-title">usefull Links</h6>
						<ul>
							<li><a href="#">Partners</a></li>
							<li><a href="#">Bloggers</a></li>
							<li><a href="#">Support</a></li>
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Press</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-6">
					<div class="footer-widget">
						<h6 class="fw-title">Sitemap</h6>
						<ul>
							<li><a href="#">Partners</a></li>
							<li><a href="#">Bloggers</a></li>
							<li><a href="#">Support</a></li>
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Press</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-6">
					<div class="footer-widget">
						<h6 class="fw-title">Shipping & returns</h6>
						<ul>
							<li><a href="#">About Us</a></li>
							<li><a href="#">Track Orders</a></li>
							<li><a href="#">Returns</a></li>
							<li><a href="#">Jobs</a></li>
							<li><a href="#">Shipping</a></li>
							<li><a href="#">Blog</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-6">
					<div class="footer-widget">
						<h6 class="fw-title">Contact</h6>
						<div class="text-box">
							<p>Puzzley </p>
							<p>Ankara </p>
							<p>+5424685942</p>
							<p>dondurma@gmail.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>







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
<?php
    } else {
        echo "Ürünleri getirme hatası: " . mysqli_error($con);
    }
} else {
    // Kullanıcı giriş yapmamışsa, yönlendirme veya mesaj gösterme işlemleri buraya eklenebilir.
    
	header("Location: login.php");
}

mysqli_close($con);
?>