<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM giamgia WHERE id = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten'];
    $loai = $_POST['loai'];
    $giatri = $_POST['giatri'];
    $don_toi_thieu = $_POST['don_toi_thieu'];
    $so_lan = $_POST['so_lan'];
    $ngay_bat_dau = $_POST['ngay_bat_dau'];
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
    $trang_thai = $_POST['trang_thai'];

    $sql = "UPDATE giamgia SET ten='$ten', loai='$loai', giatri='$giatri', don_toi_thieu='$don_toi_thieu',
            so_lan='$so_lan', ngay_bat_dau='$ngay_bat_dau', ngay_ket_thuc='$ngay_ket_thuc', trang_thai='$trang_thai'
            WHERE id = $id";

    if ($conn->query($sql)) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='kmlist.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa mã giảm giá</h2>
        <div class="block">               
            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>Tên:</td>
                        <td><input type="text" name="ten" value="<?= $data['ten'] ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Loại:</td>
                        <td>
                            <select name="loai">
                                <option value="tienmat" <?= $data['loai']=='tienmat'?'selected':'' ?>>Tiền mặt</option>
                                <option value="phantram" <?= $data['loai']=='phantram'?'selected':'' ?>>Phần trăm</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Giá trị:</td>
                        <td><input type="number" name="giatri" value="<?= $data['giatri'] ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Đơn tối thiểu:</td>
                        <td><input type="number" name="don_toi_thieu" value="<?= $data['don_toi_thieu'] ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Số lần:</td>
                        <td><input type="number" name="so_lan" value="<?= $data['so_lan'] ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Ngày bắt đầu:</td>
                        <td><input type="datetime-local" name="ngay_bat_dau" value="<?= date('Y-m-d\TH:i', strtotime($data['ngay_bat_dau'])) ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Ngày kết thúc:</td>
                        <td><input type="datetime-local" name="ngay_ket_thuc" value="<?= date('Y-m-d\TH:i', strtotime($data['ngay_ket_thuc'])) ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select name="trang_thai">
                                <option value="1" <?= $data['trang_thai']==1?'selected':'' ?>>Hiển thị</option>
                                <option value="0" <?= $data['trang_thai']==0?'selected':'' ?>>Ẩn</option>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <td></td>
                        <td><input type="submit" class="btn btn-success" value="Cập nhật" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
