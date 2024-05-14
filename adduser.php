<?php
include("dbconnect.php");

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $mail = mysqli_real_escape_string($con, $_POST['mail']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    // Veritabanına ekleme işlemi
    $insert_query = "INSERT INTO TBL_USERS (username, password, firstname, lastname, mail, role) VALUES ('$username', '$password', '$firstname', '$lastname', '$mail', '$role')";

    if (mysqli_query($con, $insert_query)) {
        header("Location: userread.php");
    } else {
        echo "Hata: " . mysqli_error($con);
    }
}

// Veritabanı bağlantısını kapat
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Ekle</title>
</head>
<body>
    <h2>Kullanıcı Ekle</h2>
    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>First Name:</label>
        <input type="text" name="firstname" required><br>

        <label>Last Name:</label>
        <input type="text" name="lastname" required><br>

        <label>Mail:</label>
        <input type="email" name="mail" required><br>

        <label>Role:</label>
        <input type="text" name="role" required><br>

        <input type="submit" value="Ekle">
    </form>
    <br>
    
</body>
</html>
