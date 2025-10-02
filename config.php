<?php
$servername = "localhost";
$username = "root";  
$password = "";
$dbname = "shop_qa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

session_start();  // Để quản lý session user và giỏ hàng
?>