<?php
include 'inc/header.php'; // Include header

include 'connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['customer_login']) || $_SESSION['customer_login'] !== true) {
    echo "<p>Bạn cần đăng nhập để sửa đặt bàn.</p>";
    echo "<p><a href='login.php'>Đăng nhập</a></p>";
    exit;
}

$user_id = (int)$_SESSION['customer_id'];

// Lấy ID đặt bàn từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin đặt bàn từ cơ sở dữ liệu
$sql = "SELECT * FROM dat_ban WHERE id = $id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);
$dat_ban = mysqli_fetch_assoc($result);

// Nếu không tìm thấy đặt bàn, quay lại trang trước
if (!$dat_ban) {
    echo "<p>Không tìm thấy đặt bàn.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $so_nguoi = (int)$_POST['so_nguoi'];
    $thoi_gian = mysqli_real_escape_string($conn, $_POST['thoi_gian']);
    $ghi_chu = mysqli_real_escape_string($conn, $_POST['ghi_chu']);
    $ban_id = (int)$_POST['ban_id']; // Lấy giá trị ban_id từ form
    $old_ban_id = $dat_ban['ban_id']; // Lấy ID bàn cũ

    // Nếu bàn cũ khác bàn mới, cập nhật trạng thái bàn cũ thành 'trống'
    if ($old_ban_id != $ban_id) {
        // Cập nhật trạng thái bàn cũ thành 'trống'
        $update_old_ban_sql = "UPDATE ban SET trang_thai = 'trong' WHERE id = $old_ban_id";
        mysqli_query($conn, $update_old_ban_sql);
    }

    // Cập nhật thông tin đặt bàn
    $update_dat_ban_sql = "UPDATE dat_ban SET so_nguoi = '$so_nguoi', thoi_gian = '$thoi_gian', ghi_chu = '$ghi_chu', ban_id = '$ban_id' WHERE id = $id";
    if (mysqli_query($conn, $update_dat_ban_sql)) {
        // Cập nhật trạng thái bàn mới thành 'đã đặt'
        $update_ban_sql = "UPDATE ban SET trang_thai = 'da_dat' WHERE id = $ban_id";
        if (mysqli_query($conn, $update_ban_sql)) {
            // Thông báo thành công và điều hướng về trang book.php
            echo "<script>
                    alert('✅ Đặt bàn đã được cập nhật thành công!');
                    window.location.href = 'book.php';
                  </script>";
        } else {
            echo "<p class='error'>❌ Lỗi cập nhật trạng thái bàn mới: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p class='error'>❌ Lỗi cập nhật thông tin đặt bàn: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!-- Section Hero -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Sửa bàn đã đặt</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Sửa bàn <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<!-- Form sửa đặt bàn -->
<form method="POST" class="sua-dat-ban-form">
<h2 style="text-align: center;">Sửa đặt bàn</h2>
    <label>Số người:</label>
    <input type="number" name="so_nguoi" value="<?php echo $dat_ban['so_nguoi']; ?>" min="1" required>

    <label>Thời gian:</label>
    <input type="datetime-local" name="thoi_gian" value="<?php echo date('Y-m-d\TH:i', strtotime($dat_ban['thoi_gian'])); ?>" required>

    <label>Ghi chú:</label>
    <textarea name="ghi_chu" rows="3" cols="50"><?php echo $dat_ban['ghi_chu']; ?></textarea>

    <!-- Thêm trường Chọn bàn -->
    <label>Chọn bàn:</label>
    <select name="ban_id" required>
        <?php
        // Lấy danh sách bàn từ bảng ban, loại bỏ bàn đã đặt (ngoài bàn hiện tại)
        $ban_sql = "SELECT * FROM ban WHERE id != {$dat_ban['ban_id']} AND trang_thai != 'da_dat' OR id = {$dat_ban['ban_id']}";
        $ban_result = mysqli_query($conn, $ban_sql);

        // Kiểm tra xem có bàn không
        if (mysqli_num_rows($ban_result) > 0) {
            while ($ban = mysqli_fetch_assoc($ban_result)) {
                // Kiểm tra nếu bàn hiện tại là bàn đã đặt
                $selected = ($dat_ban['ban_id'] == $ban['id']) ? 'selected' : '';
                echo "<option value='{$ban['id']}' $selected>{$ban['ten_ban']}</option>";
            }
        } else {
            echo "<option value=''>Không có bàn nào</option>";
        }
        ?>
    </select> <br><br>

    <button type="submit">Cập nhật</button>
</form>

<?php
include 'inc/footer.php'; // Include footer
?>
