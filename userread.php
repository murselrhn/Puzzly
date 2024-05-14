<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel - Users</title>

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

        $query = "SELECT * FROM TBL_USERS;";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<table border='1'>";
            echo "<tr><th>User ID</th><th>Username</th><th>Password</th><th>First Name</th><th>Last Name</th><th>Mail</th><th>Role</th><th>Created At</th><th>Actions</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['user_id']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['password']."</td>";
                echo "<td>".$row['firstname']."</td>";
                echo "<td>".$row['lastname']."</td>";
                echo "<td>".$row['mail']."</td>";
                echo "<td>".$row['role']."</td>";
                echo "<td>".$row['created_at']."</td>";
                echo "<td><button onclick='editUser(".$row['user_id'].")'>Edit</button> <button onclick='deleteUser(".$row['user_id'].")'>Delete</button></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Error: " . mysqli_error($con);
        }

        mysqli_close($con);
    ?>
    <button onclick="addUser()">Kullanıcı Ekle</button>

<script>
    function editUser(userId) {
        window.location.href = 'edituser.php?user_id=' + userId;
    }

    function deleteUser(userId) {
        window.location.href = 'deleteuser.php?user_id=' + userId;
    }

    function addUser() {
        window.location.href = 'adduser.php';
    }
</script>

            </div>


        </div>
</div>

<script src="js/adminpanel.min.js"></script>
</body>
</html>
