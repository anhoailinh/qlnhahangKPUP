<?php
include 'inc/connect.php';

// Kiểm tra nếu có ID được truyền vào
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header("Location: bloglist.php");
    exit;
}

$id = $_GET['id'];

// Xóa bài viết khỏi cơ sở dữ liệu
$sql = "DELETE FROM blog WHERE id = '$id' LIMIT 1";
if ($conn->query($sql)) {
    echo "<script>
            alert('Xóa bài viết thành công!');
            window.location.href = 'bloglist.php';
          </script>";
} else {
    echo "<script>
            alert('Có lỗi xảy ra khi xóa bài viết!');
            window.location.href = 'bloglist.php';
          </script>";
}
?>
