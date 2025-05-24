<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['ten'] ?? '';
    $sodienthoai = $_POST['sodienthoai'] ?? '';
    $gioitinh = $_POST['gioitinh'] ?? '';
    $solandat = $_POST['solandat'] ?? 0;
    $ghichu = $_POST['ghichu'] ?? '';
    $password = $_POST['passwords'] ?? '';

    if (!empty($ten) && !empty($sodienthoai) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO khach_hang (ten, sodienthoai, gioitinh, solandat, ghichu, passwords) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiss", $ten, $sodienthoai, $gioitinh, $solandat, $ghichu, $hashed_password);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Thêm tài khoản thành công!');
                window.location.href='datbanadd.php?skip=1';
            </script>";
        
        
            

        } else {
            echo "<script>alert('Lỗi khi thêm tài khoản!');</script>";
        }
    } else {
        echo "<script>alert('Tên, Số điện thoại và Mật khẩu không được để trống!');</script>";
    }
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm tài khoản khách hàng</h2>
        <div class="block">               
            <form action="" method="POST">
                <table class="form">
                    <tr>
                        <td><label>Tên khách hàng</label></td>
                        <td><input type="text" name="ten" required class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Số điện thoại</label></td>
                        <td><input type="text" name="sodienthoai" required class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Giới tính</label></td>
                        <td>
                            <select name="gioitinh">
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Số lần đặt hàng</label></td>
                        <td><input type="number" name="solandat" value="0" class="medium" /></td>
                    </tr>
                    <tr>
                        <td><label>Ghi chú</label></td>
                        <td><textarea name="ghichu" class="medium"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Mật khẩu</label></td>
                        <td><input type="password" name="passwords" required class="medium" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Thêm khách hàng" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
