<?php 
include 'inc/connect.php'; 

// Kiểm tra xem có tham số ID được gửi lên không
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Chuyển đổi ID thành số nguyên để tránh SQL Injection

    // Kiểm tra xem ID có tồn tại trong DB không
    $check_sql = "SELECT * FROM khach_hang WHERE id = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Nếu ID tồn tại, thực hiện xóa
        $delete_sql = "DELETE FROM khach_hang WHERE id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            echo "<script>
                alert('Xóa thành công!');
                window.location.href = 'accountlist.php'; // Quay về danh sách sau khi xóa
            </script>";
        } else {
            echo "<script>
                alert('Lỗi khi xóa, vui lòng thử lại.');
                window.location.href = 'accountlist.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Khách hàng không tồn tại!');
            window.location.href = 'accountlist.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Không có ID hợp lệ.');
        window.location.href = 'accountlist.php';
    </script>";
}

$conn->close();
?>
