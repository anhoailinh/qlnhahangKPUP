<?php
include_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donhang_id = isset($_POST['donhang_id']) ? intval($_POST['donhang_id']) : 0;
    $trang_thai = isset($_POST['trang_thai']) ? trim($_POST['trang_thai']) : '';

    if ($donhang_id > 0 && in_array($trang_thai, ['Chờ xử lý', 'Đang chuẩn bị', 'Hoàn tất'])) {
        $stmt = $conn->prepare("UPDATE don_hang SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $trang_thai, $donhang_id);

        if ($stmt->execute()) {
            // Nếu đơn hàng hoàn tất, cập nhật trạng thái bàn thành 'Trống'
            if ($trang_thai === 'Hoàn tất') {
                // Truy vấn lấy ban_id từ đơn hàng
                $sql_ban = "SELECT ban_id FROM don_hang WHERE id = ?";
                $stmt_ban = $conn->prepare($sql_ban);
                $stmt_ban->bind_param("i", $donhang_id);
                $stmt_ban->execute();
                $stmt_ban->bind_result($ban_id);
                $stmt_ban->fetch(); // <-- cần fetch trước khi close
                $stmt_ban->close();

                if (!empty($ban_id)) {
                    // Cập nhật trạng thái bàn
                    $sql_update_ban = "UPDATE ban SET trang_thai = 'Trống' WHERE id = ?";
                    $stmt_update_ban = $conn->prepare($sql_update_ban);
                    $stmt_update_ban->bind_param("i", $ban_id);
                    $stmt_update_ban->execute();
                    $stmt_update_ban->close();
                }
            }

            // Quay lại trang danh sách
            header("Location: donhang_list.php");
            exit();
        }

        $stmt->close();
    } else {
        echo "Dữ liệu không hợp lệ.";
    }
} else {
    echo "Phương thức gửi không hợp lệ.";
}

$conn->close();
?>
