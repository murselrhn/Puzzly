<?php
include("dbconnect.php");

session_start();

if (isset($_POST['add_to_cart'])) {
    // Eğer kullanıcı giriş yapmamışsa, login.php sayfasına yönlendir
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Kullanıcı giriş yapmışsa, sepete ekleme işlemi
    $user_id = $_SESSION['user_id'];
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;

    // Değişkenleri kullanarak SQL Injection saldırılarına karşı koruma ekleyin
    $user_id = mysqli_real_escape_string($con, $user_id);
    $product_id = mysqli_real_escape_string($con, $product_id);

    $insert_query = "INSERT INTO TBL_CART (user_id, product_id) VALUES ('$user_id', '$product_id')";
    $result = mysqli_query($con, $insert_query);

    if ($result) {
        echo "Ürün başarıyla sepete eklendi.";
    } else {
        echo "Ekleme hatası: " . mysqli_error($con);
    }
}

// En az ürün miktarına sahip olan 6 ürünü çek
$product_query = "SELECT * FROM TBL_PRODUCT ORDER BY product_quantity ASC LIMIT 6";
$product_result = mysqli_query($con, $product_query);

$slider_query = "SELECT * FROM TBL_PRODUCT ORDER BY product_id DESC LIMIT 2";
$slider_result = mysqli_query($con, $slider_query);



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
	
	
   
	<header class="header-section" >
		<div class="container-fluid">
			
			<div class="site-logo">
				
				<li><a href="index.php"><img src="images/logodeneme.png"  alt="logo"></a></li>
			</div>
			
			<div class="nav-switch">
				<i class="fa fa-bars"></i>
			</div>
			<div class="header-right">
				<a href="cart.php" class="card-bag"><img src="images/bag.png" alt=""></a>
				
			</div>
			
			<ul class="main-menu">
				
				<li><a href="ahşap.php">Ahşap </a></li>
				<li><a href="yetişkin.php">Yetişkin</a></li>
				<li><a href="çocuk.php">Çocuk</a></li>
				<li><a href="3d.php">3D</a></li>
				
				<?php
session_start();

// Kullanıcı giriş yapmışsa
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
?>
    <!-- Giriş yapmış kullanıcı için hoş geldin mesajı ve Logout butonu -->
    
        
        <li><a href="logout.php">Logout</a></li>
    
<?php
} else {
    // Kullanıcı giriş yapmamışsa
?>
    <!-- Giriş yapmamış kullanıcı için Login butonu -->
    
        <li><a href="login.php">Login</a></li>
   
<?php
}
?>
			</ul>
		</div>
	</header>
</section>

<section class="hero-section set-bg" data-setbg="images/back.jpg">
        <div class="hero-slider owl-carousel">
            <?php
            while ($row = mysqli_fetch_assoc($slider_result)) {
            ?>
                <div class="hs-item">
				<div class="hs-left">
    <?php
    $imagePath = 'uploads/' . $row['product_id'];

   
    if (file_exists($imagePath . '.PNG')) {
        $imagePath .= '.PNG';
    } elseif (file_exists($imagePath . '.png')) {
        $imagePath .= '.png';
    }
    ?>

    <img src="<?php echo $imagePath; ?>" width="534" height="720" alt="">
</div>
                    <div class="hs-right">
                        <div class="hs-content">
                            <div class="price">    $<?php echo $row['product_price']; ?></div>
                            <h2> <br><?php echo $row['product_name']; ?> </h2>
                            <a><form method="post" action="">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

        <button type="submit" name="add_to_cart" class="site-btn btn-line">ADD TO CART</button>
    </form></a>
                        </div>	
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
	
<section class="intro-section spad pb-0">
        <div class="section-title">
            <h2>Best Seller</h2>
        </div>
        <div class="intro-slider">
            <ul class="slidee">
                <?php
                while ($row = mysqli_fetch_assoc($product_result)) {
					$imagePath = 'uploads/' . $row['product_id'];

   
					if (file_exists($imagePath . '.PNG')) {
						$imagePath .= '.PNG';
					} elseif (file_exists($imagePath . '.png')) {
						$imagePath .= '.png';
					}
                ?>
                    <li>
                        <div class="intro-item">
                            <figure>
                                <img src="<?php echo $imagePath; ?>" style="width: 400px; height: 400px;" alt="#">
                            </figure>
                            <div class="product-info">
                                <h5><?php echo $row['product_name']; ?></h5>
                                <p>$<?php echo $row['product_price']; ?></p>
                                <a href="#" class="site-btn btn-line"><form method="post" action="">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

        <button type="submit" name="add_to_cart" class="site-btn btn-line">ADD TO CART</button>
    </form></a>
                            </div>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </section>
        
       
	<section class="footer-top-section home-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-8 col-sm-12">
					<div class="footer-widget about-widget">
						<img src="images/logodeneme.png" class="footer-logo" alt="">
						<p>Puzzly is an online sales platform that aims to bring quality puzzles to its lovers and has been serving since 2024.</p>
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
							<p>Puzzly </p>
							<p>Ankara </p>
							<p>+5424685942</p>
							<p>puzzly@gmail.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
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
mysqli_close($con);
?>