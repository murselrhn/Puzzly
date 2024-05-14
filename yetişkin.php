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

$brands_query = "SELECT DISTINCT product_brand FROM TBL_PRODUCT WHERE product_category = 'YETİŞKİN'";
$brands_result = mysqli_query($con, $brands_query);

$pieces_query = "SELECT DISTINCT product_pieces FROM TBL_PRODUCT WHERE product_category = 'YETİŞKİN'";
$pieces_result = mysqli_query($con, $pieces_query);

$prices_query = "SELECT DISTINCT product_price FROM TBL_PRODUCT WHERE product_category = 'YETİŞKİN'";
$prices_result = mysqli_query($con, $prices_query);

$itemsPerPage = 12;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$totalItemsQuery = "SELECT COUNT(*) as total FROM TBL_PRODUCT WHERE product_category = 'YETİŞKİN'";
$totalItemsResult = mysqli_query($con, $totalItemsQuery);
$totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];

$totalPages = ceil($totalItems / $itemsPerPage);

if (!is_numeric($current_page) || $current_page < 1 || $current_page > $totalPages) {
    $current_page = 1;
}

$startFrom = ($current_page - 1) * $itemsPerPage;

$select_query = "SELECT * FROM TBL_PRODUCT WHERE product_category = 'YETİŞKİN'";

// Filtreleme seçeneklerini kontrol et
if (!empty($_GET['filter_brand']) && $_GET['filter_brand'] != 'All Brands') {
    $selected_brand = $_GET['filter_brand'];
    $select_query .= " AND product_brand = '$selected_brand'";
}

if (!empty($_GET['filter_pieces']) && $_GET['filter_pieces'] != 'All Pieces') {
    $selected_pieces = $_GET['filter_pieces'];
    $select_query .= " AND product_pieces = '$selected_pieces'";
}

if (!empty($_GET['filter_price']) && $_GET['filter_price'] != 'All Prices') {
    $selected_price = $_GET['filter_price'];
    $select_query .= " AND product_price = '$selected_price'";
}

$select_query .= " LIMIT $startFrom, $itemsPerPage";

$result = mysqli_query($con, $select_query);

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
	   

	
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.css"/>
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/animate.css"/>

	
</head>
<body>
	
	
	
	
	<header class="header-section header-normal">
		<div class="container-fluid">
			
			<div class="site-logo">
				<li><a href="index.php"><img src="images/logodeneme.png" width="145" height="50 " alt="logo"></a></li>
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
	


	
	<div class="page-info-section page-info-big">
		<div class="container">
			<h2>YETİŞKİN</h2>
			<div class="site-breadcrumb">
				<a href="">Home</a> / 
				<span>YETİŞKİN</span>
			</div>
			<img src="uploads/33.PNG" width="500" height="500" alt="" class="cata-top-pic">
		</div>
	</div>
	


	
	<div class="page-area categorie-page spad">
		<div class="container">
		<div class="categorie-filter-warp">
    <p> </p>
    <div class="cf-right">
        <form action="" method="GET">
            <select name="filter_brand">
                <option>All Brands</option>
                <?php
                while ($brand_data = mysqli_fetch_assoc($brands_result)) {
                    $selected = (isset($_GET['filter_brand']) && $_GET['filter_brand'] == $brand_data['product_brand']) ? 'selected' : '';
                    echo "<option value='{$brand_data['product_brand']}' $selected>{$brand_data['product_brand']}</option>";
                }
                ?>
            </select>
            <select name="filter_pieces">
                <option>All Pieces</option>
                <?php
                while ($piece_data = mysqli_fetch_assoc($pieces_result)) {
                    $selected = (isset($_GET['filter_pieces']) && $_GET['filter_pieces'] == $piece_data['product_pieces']) ? 'selected' : '';
                    echo "<option value='{$piece_data['product_pieces']}' $selected>{$piece_data['product_pieces']}</option>";
                }
                ?>
            </select>
            <select name="filter_price">
                <option>All Prices</option>
                <?php
                while ($price_data = mysqli_fetch_assoc($prices_result)) {
                    $selected = (isset($_GET['filter_price']) && $_GET['filter_price'] == $price_data['product_price']) ? 'selected' : '';
                    echo "<option value='{$price_data['product_price']}' $selected>{$price_data['product_price']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Filter">
        </form>
    </div>
</div>
	<div class="row">		
        <?php
        if ($result) {
            while ($product_data = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-3">
                    <div class="product-item">
					<figure>
    <?php
    $imagePath = 'uploads/' . $product_data['product_id'];

    // Dosya adını kontrol et
    if (file_exists($imagePath . '.PNG')) {
        $imagePath .= '.PNG';
    } elseif (file_exists($imagePath . '.png')) {
        $imagePath .= '.png';
    }
    ?>

    <img src="<?php echo $imagePath; ?>" height="362" width="267" alt="">
</figure>
                        <div class="product-info">
                            <h6><?php echo $product_data['product_name']; ?></h6>
                            <p>$<?php echo $product_data['product_price']; ?></p>
                            <form method="post" action="">
        <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
        <button type="submit" name="add_to_cart" class="site-btn btn-line">ADD TO CART</button>
    </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "Ürünleri getirme hatası: " . mysqli_error($con);
        }
        ?>
    </div>

    <!-- Sayfalama bağlantıları -->
   <div class="site-pagination">
        <?php
        for ($i = 1; $i <= $totalPages; $i++) {
            echo ($i == $current_page) ? "<span class='active'>$i.</span>" : "<a href='?page=$i'>$i.</a>";
        }
        ?>
    </div>

		</div>
	</div>
	
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