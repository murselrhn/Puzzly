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
            background:url(/images/back.jpg);
                height: 100vh;
            }
        </style>

        <div id="intro" class="bg-image shadow-2-strong">
            <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-md-8">
                          <?php
                           

                            include("dbconnect.php");

                            // Form gönderildiyse
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $firstname = mysqli_real_escape_string($con, htmlspecialchars($_POST['firstname']));
                                $lastname = mysqli_real_escape_string($con, htmlspecialchars($_POST['lastname']));
                                $username = mysqli_real_escape_string($con, htmlspecialchars($_POST['username']));
                                $mail = mysqli_real_escape_string($con, htmlspecialchars($_POST['mail']));
                                $password = mysqli_real_escape_string($con, htmlspecialchars($_POST['password']));

                                // Kullanıcı adı veya e-posta zaten var mı kontrol et
                                $check_user_query = "SELECT * FROM TBL_USERS WHERE username = '$username' OR mail = '$mail'";
                                $check_user_result = mysqli_query($con, $check_user_query);

                                if (mysqli_num_rows($check_user_result) > 0) {
                                    // Kullanıcı adı veya e-posta zaten var
                                    
                                } else {
                                    // Kullanıcıyı veritabanına ekle
                                    $insert_query = "INSERT INTO TBL_USERS (firstname, lastname, username, mail, password, role) VALUES ('$firstname', '$lastname', '$username', '$mail', '$password', 'user')";

                                    if (mysqli_query($con, $insert_query)) {
                                        // Kullanıcı başarıyla eklendi, login.php sayfasına yönlendir
                                        header("Location: login.php");
                                    } else {
                                        echo "Hata: " . mysqli_error($con);
                                    }
                                }
                            }

                            // Veritabanı bağlantısını kapat
                            mysqli_close($con);
                            ?>

                            <form class="bg-white rounded shadow-5-strong p-5" method="post" action="">
                                <!-- First Name -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="text" id="form1Example1" class="form-control" name="firstname" />
                                    <label class="form-label" for="form1Example1">First Name</label>
                                </div>

                                <!-- Last Name -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="text" id="form1Example2" class="form-control" name="lastname" />
                                    <label class="form-label" for="form1Example2">Last Name</label>
                                </div>

                                <!-- User Name -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="text" id="form1Example3" class="form-control" name="username" />
                                    <label class="form-label" for="form1Example3">User Name</label>
                                </div>

                                <!-- Email Address -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="email" id="form1Example4" class="form-control" name="mail" />
                                    <label class="form-label" for="form1Example4">Email address</label>
                                </div>

                                <!-- Password -->
                                <div class="form-outline mb-4" data-mdb-input-init>
                                    <input type="password" id="form1Example5" class="form-control" name="password" />
                                    <label class="form-label" for="form1Example5">Password</label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block" data-mdb-ripple-init>Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
