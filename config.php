<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_qa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Chỉ start session nếu chưa có session nào đang chạy
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>