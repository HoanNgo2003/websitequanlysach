<?php
$host = 'localhost';
$dbname = 'book_management';
$user = 'root'; // Username mặc định của XAMPP
$pass = '';     // Mật khẩu mặc định trống

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}
?>
