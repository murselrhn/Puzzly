<?php
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'Luckyduck99?');
    define('DB_DATABASE', 'puzzlyv1');
    define('DB_SERVER', 'localhost');
    
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if (mysqli_connect_errno()) {
        $response["messageType"] = "error";
        $response["messageHeader"] = "Failed to connect to database";
        $response["message"] = mysqli_connect_error();
        echo $response["message"];
        return;
    } 
?>