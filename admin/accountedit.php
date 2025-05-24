<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php 
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM khach_hang WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
} else {
    // Nếu không có 'id' trong URL, chuyển hướng tới trang 404
    echo "<script>window.location = '404.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra sự tồn tại và xử lý đầu vào
    $ten = isset($_POST['ten']) ? trim($_POST['ten']) : '';
    $sodienthoai = isset($_POST['sodienthoai']) ? trim($_POST['sodienthoai']) : '';
    $gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : '';
    $solandat = isset($_POST['solandat']) ? $_POST['solandat'] : 0;
    $ghichu = isset($_POST['ghichu']) ? $_POST['ghichu'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Kiểm tra và cập nhật mật khẩu mới nếu có
    if (!empty($password)) {
        // Mã hóa mật khẩu mới
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $sql = "UPDATE khach_hang SET ten=?, sodienthoai=?, gioitinh=?, solandat=?, ghichu=?, passwords=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiiss", $ten, $sodienthoai, $gioitinh, $solandat, $ghichu, $hashed_password, $id);
    } else {
        // Nếu không có mật khẩu, chỉ cập nhật thông tin khác
        $sql = "UPDATE khach_hang SET ten=?, sodienthoai=?, gioitinh=?, solandat=?, ghichu=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiis", $ten, $sodienthoai, $gioitinh, $solandat, $ghichu, $id);
    }

    // Thực thi câu truy vấn và kiểm tra kết quả
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location='accountlist.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật!');</script>";
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa tài khoản khách hàng</h2>
        <div class="block">               
            <form action="" method="POST">
                <table class="form">
                    <tr>
                        <td><label>Tên khách hàng</label></td>
                        <td><input type="text" name="ten" value="<?= htmlspecialchars($row['ten'] ?? '') ?>" required class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Số điện thoại</label></td>
                        <td><input type="text" name="sodienthoai" value="<?= htmlspecialchars($row['sodienthoai'] ?? '') ?>" required class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Giới tính</label></td>
                        <td>
                            <select name="gioitinh">
                                <option value="1" <?= ($row['gioitinh'] ?? '') == 1 ? 'selected' : '' ?>>Nam</option>
                                <option value="0" <?= ($row['gioitinh'] ?? '') == 0 ? 'selected' : '' ?>>Nữ</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Số lần đặt hàng</label></td>
                        <td><input type="number" name="solandat" value="<?= htmlspecialchars($row['solandat'] ?? '0') ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Ghi chú</label></td>
                        <td><textarea name="ghichu" class="medium"><?= htmlspecialchars($row['ghichu'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Mật khẩu mới</label></td>
                        <td><input type="password" name="password" class="medium" placeholder="Chỉ nhập nếu muốn thay đổi" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Cập nhật tài khoản" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
