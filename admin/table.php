<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../connect.php'; ?>

<?php
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
    // Xử lý xóa bàn
    if (isset($_GET['delid'])) {
        $id = $_GET['delid'];
        $sql = "DELETE FROM ban WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<span class='success'>Xóa bàn thành công.</span>";
        } else {
            echo "<span class='error'>Lỗi khi xóa: " . $conn->error . "</span>";
        }
    }

    // Lấy dữ liệu bàn
    $sql = "SELECT * FROM ban ORDER BY id DESC";
    $result = $conn->query($sql);
?>



<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách bàn</h2>
      
        <p style="margin: 10px 0; font-size: 16px;">
    ⭕️ <strong>Bàn trống:</strong> <?php echo $soBanTrong; ?> &nbsp;&nbsp;
     ✅<strong>Bàn đã đặt:</strong> <?php echo $soBanDaDat; ?>
</p>
        <a href="banadd.php" class="btn-them">+ Thêm</a>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên bàn</th>
                        
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_ban']); ?></td>
                            <td><?php echo $row['trang_thai'] == 'da_dat' ? 'Đã đặt' : 'Trống'; ?></td>
                            <td>
                                <a href="banedit.php?id=<?php echo $row['id']; ?>">Sửa</a> || 
                                <a onclick="return confirm('Bạn có chắc muốn xóa bàn này?')" href="?delid=<?php echo $row['id']; ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>Không có dữ liệu.</td></tr>";
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
