<?php
include 'inc/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM giamgia WHERE id = $id";
    if ($conn->query($sql)) {
        echo "<script>alert('Xóa thành công'); window.location.href='kmlist.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Không tìm thấy ID cần xoá";
}
?>
