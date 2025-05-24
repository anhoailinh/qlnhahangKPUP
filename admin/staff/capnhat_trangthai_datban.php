<?php
include_once 'inc/connect.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['datban_id'];
    $trang_thai = mysqli_real_escape_string($conn, $_POST['trang_thai']);

    $sql = "UPDATE dat_ban SET trang_thai = '$trang_thai' WHERE id = $id";
    mysqli_query($conn, $sql);
}

// Sau khi cập nhật, quay lại trang danh sách
header('Location: booktable.php');
exit;
