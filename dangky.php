<?php
include 'inc/header.php';
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'];
    $sdt1 = $_POST['sdt1'];
    $gioitinh = $_POST['gioitinh'];
    $pass1 = $_POST['pass1'];
    $repass = $_POST['repass'];

    // Kiểm tra xác nhận mật khẩu
    if ($pass1 !== $repass) {
        echo "<script>alert('Mật khẩu không khớp!');</script>";
    } else {
        // Kiểm tra xem số điện thoại đã tồn tại chưa
        $check_sql = "SELECT * FROM khach_hang WHERE sodienthoai = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $sdt1);
        $check_stmt->execute();
        $result_check = $check_stmt->get_result();

        if ($result_check->num_rows > 0) {
            echo "<script>alert('Số điện thoại đã được đăng ký!');</script>";
        } else {
            // Mã hóa mật khẩu
            $hashed_pass = password_hash($pass1, PASSWORD_DEFAULT);

            // Lưu vào database
            $result = insert_user($ten, $sdt1, $gioitinh, $hashed_pass);
            
            if ($result) {
                echo "<script>alert('Đăng ký thành công! .'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Đăng ký không thành công. Vui lòng thử lại!');</script>";
            }
        }
    }
}

// Hàm chèn người dùng vào bảng khach_hang
function insert_user($ten, $sdt1, $gioitinh, $hashed_pass) {
    global $conn;
    $query = "INSERT INTO khach_hang (ten, sodienthoai, gioitinh, solandat, ghichu, passwords) 
              VALUES (?, ?, ?, 0, '', ?)";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param("ssis", $ten, $sdt1, $gioitinh, $hashed_pass);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}
?>


    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center mb-4">
            <h1 class="mb-2 bread">Đăng kí</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Đăng kí  <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>

<!-- HTML Form Đăng Ký -->
<section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
    <div class="container">
        <div class="row d-flex align-items-stretch no-gutters">
            <div class="col-md-6 pt-5 px-2 pb-2 p-md-5 order-md-last">
                <h2 class="h4 mb-2 mb-md-5 font-weight-bold">Đăng kí</h2>
                <span>
                    <?php
                    if (isset($result)) {
                        echo $result;
                    }
                    ?>
                </span>
                <form class="login-form" action="dangky.php" method="post">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label>Tên</label>
                                <input type="text" class="form-control" placeholder="VD: Dang Nhu Vu" required name="ten">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-uppercase">Số điện thoại</label>
                        <input name="sdt1" type="text" class="form-control" pattern="[0]{1}[0-9]{9}" placeholder="Vd: 03321144XX">
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="row" data-toggle="buttons">
                            <div class="col">
                                <label class="btn btn-outline-secondary">Nam
                                    <input checked type="radio" name="gioitinh" value="1">
                                </label>
                            </div>
                            <div class="col">
                                <label class="btn btn-outline-secondary">Nữ
                                    <input type="radio" name="gioitinh" value="0">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-uppercase">Mật khẩu</label>
                        <input type="password" name="pass1" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="text-uppercase">Nhập lại mật khẩu</label>
                        <input type="password" name="repass" class="form-control" placeholder="">
                    </div>

                    <div class="form-check">
                        <input type="submit" value="Đăng kí" class="btn btn-primary py-3 px-5">
                    </div>
                    
                </form>
                <div class="form-check">
                    <a href="login.php" class="py-3" style="color: blue; text-decoration: underline; background: none; border: none;">
                        Đăng nhập
                    </a>

                    </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'inc/footer.php';
?>
