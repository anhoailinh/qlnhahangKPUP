<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include 'inc/connect.php';
include_once '../helpers/format.php';

// Kiểm tra nếu có ID được truyền vào
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header("Location: bloglist.php");
    exit;
}

$id = $_GET['id'];

// Lấy thông tin bài viết từ cơ sở dữ liệu
$sql = "SELECT * FROM blog WHERE id = '$id' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: bloglist.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tieude = $_POST['tieude'];
    $mota = $_POST['mota'];
    $noidung = $_POST['noidung'];
    $img = $_FILES['img']['name'];
    $img_tmp = $_FILES['img']['tmp_name'];

    // Nếu có ảnh mới được tải lên
    if ($img != '') {
        // Kiểm tra loại tệp và kích thước tệp
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        $file_extension = strtolower(pathinfo($img, PATHINFO_EXTENSION));

        // Kiểm tra nếu tệp là một hình ảnh hợp lệ
        if (in_array($file_extension, $allowed_extensions)) {
            // Tạo tên ảnh mới để tránh trùng lặp
            $new_img_name = uniqid() . '.' . $file_extension;
            // Di chuyển ảnh vào thư mục
            if (move_uploaded_file($img_tmp, '../images/blog/' . $new_img_name)) {
                // Cập nhật thông tin vào cơ sở dữ liệu
                $sql_update = "UPDATE blog SET tieude = '$tieude', mota = '$mota', noidung = '$noidung', img = '$new_img_name' WHERE id = '$id'";
            } else {
                echo "<script>alert('Lỗi khi tải ảnh lên.');</script>";
                exit; // Dừng thực thi nếu tải ảnh thất bại
            }
        } else {
            echo "<script>alert('Chỉ hỗ trợ tải lên các tệp hình ảnh như JPG, PNG, GIF.');</script>";
            exit; // Dừng thực thi nếu tệp không phải hình ảnh hợp lệ
        }
    } else {
        // Nếu không có ảnh mới, chỉ cập nhật các trường khác
        $sql_update = "UPDATE blog SET tieude = '$tieude', mota = '$mota', noidung = '$noidung' WHERE id = '$id'";
    }

    // Thực thi câu lệnh SQL
    if ($conn->query($sql_update)) {
        echo "<script>
                alert('Cập nhật tin tức thành công!');
                window.location.href = 'bloglist.php';
              </script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật.');</script>";
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa bài viết</h2>
        <div class="block">
            <form action="blogedit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td><label>Tiêu đề</label></td>
                        <td><input type="text" name="tieude" value="<?php echo htmlspecialchars($row['tieude']); ?>" class="medium" required /></td>
                    </tr>
                    <tr>
                        <td><label>Mô tả</label></td>
                        <td><textarea name="mota" rows="4" cols="60" required><?php echo htmlspecialchars($row['mota']); ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Nội dung</label></td>
                        <td><textarea name="noidung" rows="8" cols="80" required><?php echo htmlspecialchars($row['noidung']); ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Hình ảnh</label></td>
                        <td>
                            <img id="preview-img" src="../images/blog/<?php echo htmlspecialchars($row['img']); ?>" width="100px" alt="Blog Image" />
                            <input type="file" name="img" id="img" onchange="previewImage()" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Cập nhật" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="bloglist.php" style="color: #3b2faa; text-decoration: underline;">Quay lại</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
// Hàm để hiển thị ảnh preview khi người dùng chọn file mới
function previewImage() {
    const file = document.getElementById('img').files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result; // Cập nhật ảnh mới lên thẻ img
    }

    if (file) {
        reader.readAsDataURL(file); // Đọc file ảnh dưới dạng base64
    }
}
</script>

<?php include 'inc/footer.php'; ?>
