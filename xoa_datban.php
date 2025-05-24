<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['customer_login'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_GET['id'];

// Lấy bàn_id trước khi xoá
$get_ban = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ban_id FROM dat_ban WHERE id = $id"));
$ban_id = (int)$get_ban['ban_id'];

mysqli_query($conn, "DELETE FROM dat_ban WHERE id = $id");
// Cập nhật lại trạng thái bàn thành 'trong'
mysqli_query($conn, "UPDATE ban SET trang_thai = 'trong' WHERE id = $ban_id");

header("Location: book.php"); // Điều hướng về lại trang đặt bàn
