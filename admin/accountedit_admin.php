<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include 'inc/connect.php';

// Kiểm tra xem ID có được truyền vào không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID không hợp lệ!'); window.location='accountlist.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM tb_admin WHERE id_admin = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Tài khoản không tồn tại!'); window.location='accountlist.php';</script>";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_admin = trim($_POST['name_admin']);
    $adminuser = trim($_POST['adminuser']);
    $password = trim($_POST['password']);

    // Kiểm tra mật khẩu hợp lệ nếu có nhập
    
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE tb_admin SET Name_admin=?, adminuser=?, adminpass=? WHERE id_admin=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name_admin, $adminuser, $hashed_password, $id);
        } else {
            $sql = "UPDATE tb_admin SET Name_admin=?, adminuser=? WHERE id_admin=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $name_admin, $adminuser, $id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật thành công!'); window.location='account_admin.php';</script>";
        } else {
            echo "<script>alert('Lỗi cập nhật!');</script>";
        }
    
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Chỉnh sửa tài khoản admin</h2>
        <div class="block">
            <form action="" method="POST">
                <table class="form">
                    <tr>
                        <td><label>Tên Admin</label></td>
                        <td><input type="text" name="name_admin" value="<?= htmlspecialchars($row['Name_admin']) ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Tên đăng nhập</label></td>
                        <td><input type="text" name="adminuser" value="<?= htmlspecialchars($row['adminuser']) ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Cấp bậc</label></td>
                        <td>
                            <select name="aa" required>
                                <option value="1" >Quản trị viên</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Mật khẩu mới (nếu đổi)</label></td>
                        <td><input type="password" name="password" placeholder="Nhập mật khẩu mới nếu muốn đổi"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Cập nhật"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
