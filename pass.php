<?php
include 'inc/header.php';
include 'connect.php'; // Kết nối với cơ sở dữ liệu

// Lấy customer_id từ session
$id = Session::get('customer_id');

// Kiểm tra nếu customer_id không tồn tại trong session
if (empty($id)) {
    echo "<script>window.location = '404.php'</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy mật khẩu cũ và mới từ form
    $pass0 = $_POST['pass0']; // Mật khẩu cũ
    $pass1 = $_POST['pass1']; // Mật khẩu mới
    $repass = $_POST['repass']; // Xác nhận mật khẩu mới

    // Truy vấn lấy mật khẩu hiện tại của người dùng
    $query = "SELECT passwords FROM khach_hang WHERE id = '$id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Kiểm tra mật khẩu cũ
        if (!password_verify($pass0, $row['passwords'])) {
            $result_message = "<span class='text-danger'>❌ Mật khẩu cũ không đúng</span>";
        } elseif ($pass1 !== $repass) {
            $result_message = "<span class='text-warning'>⚠️ Mật khẩu mới không khớp</span>";
        } else {
            // Mã hóa mật khẩu mới
            $hashed_pass = password_hash($pass1, PASSWORD_DEFAULT);

            // Cập nhật mật khẩu mới
            $update_query = "UPDATE khach_hang SET passwords = '$hashed_pass' WHERE id = '$id'";
            if ($conn->query($update_query) === TRUE) {
                $result_message = "<span class='text-success'>✅ Đổi mật khẩu thành công!</span>";
            } else {
                $result_message = "<span class='text-danger'>❌ Cập nhật thất bại, vui lòng thử lại</span>";
            }
        }
    } else {
        $result_message = "<span class='text-danger'>❌ Không tìm thấy người dùng</span>";
    }
}

?>

<style>
  label {
    color: black;
    font-weight: bold;
  }
</style>

<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate text-center mb-4">
        <h1 class="mb-2 bread">Change Password</h1>
        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Change Password<i class="ion-ios-arrow-forward"></i></span></p>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
  <div class="container">
    <div class="row d-flex align-items-stretch no-gutters">
      <div class="col-md-6 pt-5 px-2 pb-2 p-md-5 order-md-last">
        <h2 class="h4 mb-2 mb-md-5 font-weight-bold">Change Password</h2>
        <span><?php if (isset($result_message)) echo $result_message; ?></span>
        <form class="login-form" action="" method="post">
          <div class="form-group">
            <label class="text-uppercase">Current Password</label>
            <input type="password" name="pass0" class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label class="text-uppercase">New Password</label>
            <input type="password" name="pass1" class="form-control" placeholder="">
          </div>
          
          <div class="form-group">
            <label class="text-uppercase">Confirm New Password</label>
            <input type="password" name="repass" class="form-control" placeholder="">
          </div>

          <div class="form-check">
            <input type="submit" value="Change Password" class="btn btn-primary py-3 px-5">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php
include 'inc/footer.php';
?>
