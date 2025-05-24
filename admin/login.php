<?php
// Kết nối database
include 'inc/connect.php';
session_start();

// Kiểm tra khi người dùng bấm nút đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminuser = $_POST['adminuser'];
    $adminpass = $_POST['adminpass'];

    // Escape dữ liệu để tránh SQL Injection
    $adminuser = mysqli_real_escape_string($conn, $adminuser);

    // Câu lệnh truy vấn lấy thông tin user
    $sql = "SELECT * FROM tb_admin WHERE adminuser = '$adminuser' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($adminpass, $row['adminpass'])) {
            // Đăng nhập thành công, lưu session
            $_SESSION['adminlogin'] = true;
            $_SESSION['adminId'] = $row['id_admin'];
            $_SESSION['adminName'] = $row['Name_admin'];
            $_SESSION['adminUser'] = $row['adminuser'];
            $_SESSION['adminRole'] = $row['role'];

            // Chuyển hướng theo role
            if ($row['role'] == 1) {
                header('Location: index.php');
                exit();
            } else {
                header('Location: staff/index.php');
                exit();
            }
        } else {
            $login_check = "<span style='color:red;'>Sai mật khẩu!</span>";
        }
    } else {
        $login_check = "<span style='color:red;'>Tài khoản không tồn tại!</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
    <div class="container">
        <section id="content">
            <form action="login.php" method="post">
                <h1>Admin Login</h1>
                <?php if (isset($login_check)) echo $login_check; ?>
                <div>
                    <input type="text" placeholder="Username" required="" name="adminuser"/>
                </div>
                <div>
                    <input type="password" placeholder="Password" required="" name="adminpass"/>
                </div>
                <div>
                    <input type="submit" value="Log in" />
                </div>
            </form>
            <div class="button">
                <a href="#"></a>
            </div>
        </section>
    </div>
</body>
</html>
