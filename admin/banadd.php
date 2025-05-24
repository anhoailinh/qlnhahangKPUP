<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_ban = $_POST['ten_ban'];
    $trang_thai = $_POST['trang_thai'];

    if (empty($ten_ban)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.');</script>";
    } else {
        $sql = "INSERT INTO ban (ten_ban, trang_thai) 
                VALUES ('$ten_ban', '$trang_thai')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Thêm bàn thành công!');
                window.location.href = 'table.php';
            </script>";
        } else {
            echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
        }
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm bàn</h2>
        <div class="block copyblock"> 
            <form action="banadd.php" method="post">
                <table class="form">					
                    <tr>
                        <td>
                            <label>Tên bàn</label>
                        </td>
                        <td>
                            <input type="text" name="ten_ban" placeholder="Nhập tên bàn..." class="medium" />
                        </td>
                    </tr>
             
                    <tr>
                        <td>
                            <label>Trạng thái</label>
                        </td>
                        <td>
                            <select name="trang_thai">
                                <option value="0">Trống</option>
                                <option value="1">Đang sử dụng</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Thêm" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';?>
