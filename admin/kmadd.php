<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten'];
    $loai = $_POST['loai'];
    $giatri = $_POST['giatri'];
    $don_toi_thieu = $_POST['don_toi_thieu'];
    $so_lan = $_POST['so_lan'];
    $ngay_bat_dau = $_POST['ngay_bat_dau'];
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
    $trang_thai = $_POST['trang_thai'];

    $sql = "INSERT INTO giamgia (ten, loai, giatri, don_toi_thieu, so_lan, ngay_bat_dau, ngay_ket_thuc, trang_thai) 
            VALUES ('$ten', '$loai', '$giatri', '$don_toi_thieu', '$so_lan', '$ngay_bat_dau', '$ngay_ket_thuc', '$trang_thai')";

    if ($conn->query($sql)) {
        echo "<script>alert('Thêm thành công!'); window.location.href='giamgialist.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm mã giảm giá</h2>
        <div class="block">               
            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>Tên:</td>
                        <td><input type="text" name="ten" required class="medium" /></td>
                    </tr>
                    <tr>
                        <td>Loại:</td>
                        <td>
                            <select name="loai">
                                <option value="tienmat">Tiền mặt</option>
                                <option value="phantram">Phần trăm</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Giá trị:</td>
                        <td><input type="number" name="giatri" required /></td>
                    </tr>
                    <tr>
                        <td>Đơn tối thiểu:</td>
                        <td><input type="number" name="don_toi_thieu" required /></td>
                    </tr>
                    <tr>
                        <td>Số lần:</td>
                        <td><input type="number" name="so_lan" value="1" required /></td>
                    </tr>
                    <tr>
                        <td>Ngày bắt đầu:</td>
                        <td><input type="datetime-local" name="ngay_bat_dau" required /></td>
                    </tr>
                    <tr>
                        <td>Ngày kết thúc:</td>
                        <td><input type="datetime-local" name="ngay_ket_thuc" required /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select name="trang_thai">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <td></td>
                        <td><input type="submit" class="btn btn-primary" value="Thêm" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
