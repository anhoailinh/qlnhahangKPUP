<?php
include 'inc/header.php'; // Include header

include 'connect.php';

if (!isset($_SESSION['customer_login']) || $_SESSION['customer_login'] !== true) {
    echo "<script>
        alert('Bạn cần đăng nhập để đặt bàn.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$user_id = (int)$_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $so_nguoi = (int)$_POST['so_nguoi'];
    $thoi_gian = mysqli_real_escape_string($conn, $_POST['thoi_gian']);
    $ghi_chu = mysqli_real_escape_string($conn, $_POST['ghi_chu']);
    $ban_id = (int)$_POST['ban_id'];

    // ✅ Kiểm tra xem bàn đã được đặt trong khoảng ±2 tiếng chưa
    $kiemtra_sql = "SELECT * FROM dat_ban 
                    WHERE ban_id = $ban_id 
                    AND ABS(TIMESTAMPDIFF(MINUTE, '$thoi_gian', thoi_gian)) < 120";

    $kiemtra_result = mysqli_query($conn, $kiemtra_sql);

    if (mysqli_num_rows($kiemtra_result) > 0) {
        echo "<script>
        alert('Bàn này đã được đặt trong khoảng 2 tiếng quanh thời gian bạn chọn. Vui lòng chọn thời gian khác hoặc bàn khác.');
        window.location.href = 'book.php'; // Điều hướng lại trang để người dùng có thể chọn lại
      </script>";

    } else {
        // Nếu không bị trùng thời gian thì tiến hành đặt bàn
        $sql = "INSERT INTO dat_ban (user_id, ban_id, so_nguoi, thoi_gian, ghi_chu, trang_thai) 
        VALUES ('$user_id', '$ban_id', '$so_nguoi', '$thoi_gian', '$ghi_chu', 'chờ xác nhận')";


        if (mysqli_query($conn, $sql)) {
            mysqli_query($conn, "UPDATE ban SET trang_thai = 'da_dat' WHERE id = $ban_id");
            echo "<p style='color:green;'>✅ Đặt bàn thành công!</p>";
        } else {
            echo "<p style='color:red;'>❌ Lỗi: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>


<!-- Section Hero -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Đặt bàn</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Đặt bàn <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>



<div class="so-do-ban-wrapper">
    <div class="so-do-ban">
        <?php
        $ds_ban = mysqli_query($conn, "SELECT * FROM ban");
        while ($ban = mysqli_fetch_assoc($ds_ban)) {
            $trang_thai_class = ($ban['trang_thai'] == 'da_dat') ? 'da-dat' : '';
            $trang_thai_hien_thi = ($ban['trang_thai'] == 'da_dat') ? 'Đã đặt' : 'Trống';
            echo "<div class='ban $trang_thai_class'>Bàn {$ban['ten_ban']}<br><small>($trang_thai_hien_thi)</small></div>";
        }
        ?>
    </div>
</div>


<!-- ✅ Form đặt bàn -->
<form method="POST" class="dat-ban-form">
<h2 class="form-title">Đặt bàn</h2>

    <label for="ban_id">Bàn số:</label>
    <select name="ban_id" id="ban_id" required>
        <?php
      $result = mysqli_query($conn, "SELECT * FROM ban WHERE trang_thai = 'trong'");
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='{$row['id']}'>Bàn: {$row['ten_ban']}</option>";
      }
?>      
    </select>

    <label for="so_nguoi">Số người:</label>
    <input type="number" name="so_nguoi" id="so_nguoi" min="1" required>

    <label for="thoi_gian">Thời gian:</label>
    <input type="datetime-local" name="thoi_gian" id="thoi_gian" required>

    <label for="ghi_chu">Ghi chú:</label>
    <textarea name="ghi_chu" id="ghi_chu" rows="3" cols="50"></textarea>

    <button type="submit" class="submit-btn">Đặt bàn</button>
</form>

<!-- 
 -->
 <h3 class="table-title">Danh sách bàn bạn đã đặt</h3>
<table class="booking-table">
    <tr class="table-header">
        <th>Bàn số</th>
        <th>Số người</th>
        <th>Thời gian</th>
        <th>Ghi chú</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>
    <?php
    $ds_datban = mysqli_query($conn, "SELECT dat_ban.*, ban.ten_ban FROM dat_ban JOIN ban ON dat_ban.ban_id = ban.id WHERE user_id = $user_id ORDER BY thoi_gian DESC");
    while ($row = mysqli_fetch_assoc($ds_datban)) {
        echo "<tr>
            <td>{$row['ten_ban']}</td>
            <td>{$row['so_nguoi']}</td>
            <td>{$row['thoi_gian']}</td>
            <td>{$row['ghi_chu']}</td>
            <td>{$row['trang_thai']}</td>
            <td>
                <a href='sua_datban.php?id={$row['id']}' class='action-link'>Sửa</a> | 
                <a href='xoa_datban.php?id={$row['id']}' class='action-link' onclick=\"return confirm('Bạn chắc chắn muốn xoá đặt bàn này?');\">Xoá</a>
            </td>
        </tr>";
    }
    ?>
</table>



<?php
include 'inc/footer.php'; // Include footer
?>