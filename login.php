<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("dbconnect.php");

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = mysqli_real_escape_string($con, htmlspecialchars($_POST['mail']));
    $password = mysqli_real_escape_string($con, htmlspecialchars($_POST['password']));

    // Kullanıcıyı veritabanında kontrol et
    $check_user_query = "SELECT * FROM TBL_USERS WHERE mail = '$mail'";
    $check_user_result = mysqli_query($con, $check_user_query);

    if ($check_user_result) {
        $user = mysqli_fetch_assoc($check_user_result);

        // Girilen şifre veritabanındaki şifre ile eşleşiyorsa
        if ($password == $user['password']) {
            // Giriş başarılı, kullanıcı oturumunu başlat veya başka bir işlem yap
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Kullanıcı rolüne göre yönlendirme yap
            if ($_SESSION['role'] == 'admin') {
                header("Location: adminindex.html");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            // Şifre eşleşmiyor
            $login_error = "Hatalı şifre. Lütfen tekrar deneyin.";
        }
    } else {
        // Veritabanı sorgusu başarısız oldu
        $login_error = "Giriş işlemi sırasında bir hata oluştu.";
    }
}

// Veritabanı bağlantısını kapat
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <link rel="stylesheet" href="css/mdb.min.css" />
</head>
<body>
    <header>
        <style>
            #intro {
                background: url(/images/back.jpg);
                height: 100vh;
            }
          
        </style>

        <div id="intro" class="bg-image shadow-2-strong">
            <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-md-8">
                            <form class="bg-white rounded shadow-5-strong p-5" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <!-- Email Address -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="email" id="form1Example1" class="form-control" name="mail" />
                                    <label class="form-label" for="form1Example1">Email address</label>
                                </div>

                                <!-- Password -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="password" id="form1Example2" class="form-control" name="password" />
                                    <label class="form-label" for="form1Example2">Password</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block" data-mdb-ripple-init>Login</button>
                                </form>
                                
                                
                          
                                <a href="signin.php"> <button type="submit" class="btn btn-primary btn-block" >Sign in</button></a>
                           


                                <?php
                                if (isset($login_error)) {
                                    echo "<div class='alert alert-danger mt-3'>$login_error</div>";
                                }
                                ?>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
