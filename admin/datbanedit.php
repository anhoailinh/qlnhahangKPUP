<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include_once '../connect.php';

if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    echo "<script>window.location='datbanlist.php';</script>";
} else {
    $id = $_GET['id'];
}

// Lấy thông tin đặt bàn cần sửa
$sql = "SELECT * FROM dat_ban WHERE id = $id";
$result = $conn->query($sql);
$datBan = $result->fetch_assoc();

// Nếu submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ban_moi = $_POST['ban_id'];
    $so_nguoi = $_POST['so_nguoi'];
    $ghi_chu = $_POST['ghi_chu'];
    $created_at = date('Y-m-d H:i:s'); // Tự động cập nhật giờ hiện tại

    // Nếu đổi bàn thì cập nhật trạng thái bàn cũ và bàn mới
    if ($ban_moi != $datBan['ban_id']) {
        // Bàn cũ thành 'trống'
        $conn->query("UPDATE ban SET trang_thai = 'trong' WHERE id = {$datBan['ban_id']}");
        // Bàn mới thành 'da_dat'
        $conn->query("UPDATE ban SET trang_thai = 'da_dat' WHERE id = $ban_moi");
    }

    // Update dữ liệu đặt bàn
    $update_sql = "UPDATE dat_ban 
                   SET ban_id = $ban_moi, so_nguoi = $so_nguoi, ghi_chu = '$ghi_chu', created_at = '$created_at' 
                   WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        $success_message = "✅ Cập nhật đặt bàn thành công!";
        // Lấy lại thông tin mới
        $sql = "SELECT * FROM dat_ban WHERE id = $id";
        $result = $conn->query($sql);
        $datBan = $result->fetch_assoc();
    } else {
        $error_message = "❌ Lỗi cập nhật: " . $conn->error;
    }
}

// Lấy danh sách bàn trống + bàn hiện tại của đơn đặt
$ban_sql = "SELECT * FROM ban WHERE trang_thai = 'trong' OR id = {$datBan['ban_id']}";
$ban_result = $conn->query($ban_sql);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa đặt bàn</h2>

        <?php if (isset($success_message)) echo "<div style='color: green; margin-bottom: 10px;'>$success_message</div>"; ?>
        <?php if (isset($error_message)) echo "<div style='color: red; margin-bottom: 10px;'>$error_message</div>"; ?>

        <form action="" method="post">
            <table class="form">
                <tr>
                    <td><label>Bàn:</label></td>
                    <td>
                        <select name="ban_id" required>
                            <?php 
                            if ($ban_result && $ban_result->num_rows > 0) {
                                while ($ban = $ban_result->fetch_assoc()) {
                                    $selected = ($ban['id'] == $datBan['ban_id']) ? 'selected' : '';
                                    echo "<option value='{$ban['id']}' $selected>{$ban['ten_ban']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Số người:</label></td>
                    <td><input type="number" name="so_nguoi" value="<?php echo $datBan['so_nguoi']; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Ghi chú:</label></td>
                    <td><textarea name="ghi_chu"><?php echo htmlspecialchars($datBan['ghi_chu']); ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Cập nhật" class="btn-them"/>
                        <a href="booktable.php" class="btn-them" style="background-color: gray;">Quay lại</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
