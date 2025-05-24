<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include_once '../connect.php';

if (!isset($_GET['id']) || $_GET['id'] == NULL) {
    header("Location: banlist.php");
    exit();
}

$id = $_GET['id'];
$success_message = '';
$error_message = '';

// Xử lý khi bấm nút cập nhật
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_ban = $_POST['ten_ban'];
    $trang_thai = $_POST['trang_thai'];

    $update_sql = "UPDATE ban SET ten_ban = '$ten_ban', trang_thai = '$trang_thai' WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        $success_message = "<div style='padding: 15px; background-color: #4CAF50; color: white; font-size: 18px; margin-bottom: 20px;'>
                                ✅ Cập nhật bàn thành công!
                            </div>";
    } else {
        $error_message = "<div style='padding: 15px; background-color: #f44336; color: white; font-size: 18px; margin-bottom: 20px;'>
                                ❌ Lỗi khi cập nhật: " . $conn->error . "
                          </div>";
    }
}

// Lấy dữ liệu cũ để đổ lên form
$sql = "SELECT * FROM ban WHERE id = $id";
$result = $conn->query($sql);
$ban = $result->fetch_assoc();
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa thông tin bàn</h2>

        <?php
        if (!empty($success_message)) {
            echo $success_message;
        }
        if (!empty($error_message)) {
            echo $error_message;
        }
        ?>

        <div class="block copyblock"> 
            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>Tên bàn:</td>
                        <td><input type="text" name="ten_ban" value="<?php echo htmlspecialchars($ban['ten_ban']); ?>" class="medium" /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select name="trang_thai">
                                <option value="trong" <?php if ($ban['trang_thai'] == 'trong') echo 'selected'; ?>>Trống</option>
                                <option value="da_dat" <?php if ($ban['trang_thai'] == 'da_dat') echo 'selected'; ?>>Đã đặt</option>
                            </select>
                        </td>
                    </tr>
					<tr> 
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Cập nhật" class="btn-them" />
                            <a href="table.php" class="btn-them" style="text-decoration: none;">Quay lại danh sách</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
