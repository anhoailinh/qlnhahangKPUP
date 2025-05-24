<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php
include '../lib/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name_admin = $_POST['name_admin'];
    $adminuser = $_POST['adminuser'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu bằng password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $db = new Database();
    $query = "INSERT INTO tb_admin (Name_admin, adminuser, adminpass) VALUES (?, ?, ?)";
    $stmt = $db->link->prepare($query);
    $stmt->bind_param("sss", $name_admin, $adminuser, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm tài khoản thành công!'); window.location='account_admin.php';</script>";

        
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm tài khoản Admin</h2>
        <div class="block">  
            <form action="" method="POST">
                <table class="form">                   
                    <tr>
                        <td><label>Tên Admin:</label></td>
                        <td><input type="text" name="name_admin" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Tên đăng nhập:</label></td>
                        <td><input type="text" name="adminuser" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Mật khẩu:</label></td>
                        <td><input type="password" name="password" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="Thêm mới" class="btn-submit" />
                            <button type="button" class="btn-submit" onclick="window.location.href='account_admin.php';">Quay lại</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
