<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once 'inc/connect.php'; ?>
<?php
// Đếm số bàn đã đặt (có đặt bàn trong bảng dat_ban)
$sqlDat = "SELECT COUNT(DISTINCT ban_id) AS da_dat FROM dat_ban";
$resDat = $conn->query($sqlDat);
$rowDat = $resDat->fetch_assoc();
$soBanDaDat = $rowDat['da_dat'];

// Tổng số bàn trong hệ thống
$sqlTong = "SELECT COUNT(*) AS tong_ban FROM ban";
$resTong = $conn->query($sqlTong);
$rowTong = $resTong->fetch_assoc();
$tongBan = $rowTong['tong_ban'];

// Bàn trống = tổng số bàn - số bàn đã đặt
$soBanTrong = $tongBan - $soBanDaDat;
?>



<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách đặt bàn</h2>
        <p style="margin: 10px 0; font-size: 16px;">
    ⭕️ <strong>Bàn trống:</strong> <?php echo $soBanTrong; ?> &nbsp;&nbsp;
     ✅<strong>Bàn đã đặt:</strong> <?php echo $soBanDaDat; ?>
</p>
        <a href="datbanadd.php" class="btn-them">+ Thêm</a>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người đặt</th>
                        <th>Số điện thoại</th>
                        <th>Bàn</th>
                        <th>Số người</th>
                        <th>Ghi chú</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $sql = "SELECT db.*, kh.ten,kh.sodienthoai, b.ten_ban 
        FROM dat_ban db
        LEFT JOIN khach_hang kh ON db.user_id = kh.id
        LEFT JOIN ban b ON db.ban_id = b.id
        ORDER BY db.created_at DESC";

                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['ten']; ?></td>
                        <td><?php echo $row['sodienthoai']; ?></td>
                        <td><?php echo $row['ten_ban']; ?></td>
                        <td><?php echo $row['so_nguoi']; ?></td>
                        <td><?php echo $row['ghi_chu']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                        <td>
    <form method="POST" action="capnhat_trangthai_datban.php">
        <input type="hidden" name="datban_id" value="<?php echo $row['id']; ?>">
        <select name="trang_thai" onchange="this.form.submit()">
            <option value="Chờ xác nhận" <?php if ($row['trang_thai'] == 'Chờ xác nhận') echo 'selected'; ?>>Chờ xác nhận</option>
            <option value="Đã xác nhận" <?php if ($row['trang_thai'] == 'Đã xác nhận') echo 'selected'; ?>>Đã xác nhận</option>
        </select>
    </form>
</td>

                        
                        <td>
                            <a href="datbanedit.php?id=<?php echo $row['id']; ?>">Sửa</a> |
                            <a onclick="return confirm('Bạn có chắc muốn xóa không?');" 
                               href="datbandelete.php?id=<?php echo $row['id']; ?>">Xóa</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="8">Chưa có dữ liệu đặt bàn.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>

<?php include 'inc/footer.php';?>
