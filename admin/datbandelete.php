<?php 
include_once '../connect.php';

// Kiểm tra có ID cần xóa không
if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    echo "<script>window.location='datbanlist.php';</script>";
    exit();
} else {
    $id = $_GET['id'];

    // Lấy thông tin đơn đặt bàn trước khi xóa để biết bàn nào
    $sql = "SELECT ban_id FROM dat_ban WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ban_id = $row['ban_id'];

        // Xóa đơn đặt bàn
        $delete_sql = "DELETE FROM dat_ban WHERE id = $id";
        if ($conn->query($delete_sql) === TRUE) {
            // Cập nhật trạng thái bàn về 'trống'
            $conn->query("UPDATE ban SET trang_thai = 'trong' WHERE id = $ban_id");

            echo "<script>alert('✅ Xóa thành công!'); window.location='booktable.php';</script>";
        } else {
            echo "<script>alert('❌ Lỗi khi xóa: ".$conn->error."'); window.location='datbanlist.php';</script>";
        }
    } else {
        echo "<script>alert('❌ Không tìm thấy đơn đặt bàn!'); window.location='datbanlist.php';</script>";
    }
}
?>
