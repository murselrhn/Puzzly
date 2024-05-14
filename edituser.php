<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Edit</title>
</head>
<body>

<?php
include("dbconnect.php");

if(isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Form gönderildiyse güncelleme işlemini yap
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $mail = $_POST['mail'];
        $role = $_POST['role'];

        $update_query = "UPDATE TBL_USERS 
                         SET username = '$username', password = '$password', firstname = '$firstname', 
                             lastname = '$lastname', mail = '$mail', role = '$role' 
                         WHERE user_id = $user_id";

        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            echo "Kullanıcı başarıyla güncellendi.";
            header("refresh:2;url=userread.php"); // 2 saniye bekleyip userread.php'ye yönlendir
        } else {
            echo "Kullanıcı güncelleme işlemi başarısız: " . mysqli_error($con);
        }
    } else {
        // Form gönderilmediyse, mevcut kullanıcı verilerini getir ve düzenleme formunu göster
        $select_query = "SELECT * FROM TBL_USERS WHERE user_id = $user_id";
        $result = mysqli_query($con, $select_query);

        if ($result) {
            $user_data = mysqli_fetch_assoc($result);
            ?>
            <h2>Edit User</h2>
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $user_data['username']; ?>"><br>

                <label for="password">Password:</label>
                <input type="password" name="password" value="<?php echo $user_data['password']; ?>"><br>

                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" value="<?php echo $user_data['firstname']; ?>"><br>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" value="<?php echo $user_data['lastname']; ?>"><br>

                <label for="mail">Mail:</label>
                <input type="email" name="mail" value="<?php echo $user_data['mail']; ?>"><br>

                <label for="role">Role:</label>
                <input type="text" name="role" value="<?php echo $user_data['role']; ?>"><br>

                <input type="submit" value="Update">
            </form>
            <?php
        } else {
            echo "Kullanıcı bilgilerini getirme hatası: " . mysqli_error($con);
        }
    }
} else {
    echo "Geçersiz kullanıcı ID parametresi.";
}

// Veritabanı bağlantısını kapat
mysqli_close($con);
?>

</body>
</html>
