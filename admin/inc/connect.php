<?php
$server = 'nhahangkpup.mysql.database.azure.com';
$port = 3306;
$user = 'nhahangkpup'; // username theo dạng username@hostname trên Azure
$pass = 'Linh3011';
$database = 'gs_restaurant';

// Khởi tạo mysqli
$conn = mysqli_init();
if (!$conn) {
    die('mysqli_init failed');
}

// Bật SSL (không dùng file chứng chỉ, vì ssl-mode=require là bắt buộc SSL nhưng Azure cho phép kết nối không cần client cert)
$conn->ssl_set(NULL, NULL, NULL, NULL, NULL);

// Kết nối với flag MYSQLI_CLIENT_SSL
if (!$conn->real_connect($server, $user, $pass, $database, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Thiết lập charset UTF-8
mysqli_query($conn, "SET NAMES 'utf8'");


?>
