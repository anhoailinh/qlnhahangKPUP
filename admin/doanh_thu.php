<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include_once 'inc/connect.php'; ?>


<?php
include_once 'inc/connect.php';

$ngay = isset($_GET['ngay']) ? $_GET['ngay'] : '';
$thang = isset($_GET['thang']) ? $_GET['thang'] : '';

// Câu truy vấn gốc
$sql = "
    SELECT 
        DATE(dh.thoi_gian) AS ngay,
        COUNT(*) AS so_don,
        SUM(dh.tong_tien) AS tong_doanh_thu
    FROM don_hang dh
    WHERE dh.trang_thai = 'Hoàn tất'
";

// Nếu chọn ngày thì chỉ lọc theo ngày
if (!empty($ngay)) {
    $sql .= " AND DATE(dh.thoi_gian) = '$ngay'";
}
// Nếu không chọn ngày mà có chọn tháng → lọc theo tháng
elseif (!empty($thang)) {
    $sql .= " AND DATE_FORMAT(dh.thoi_gian, '%Y-%m') = '$thang'";
}

$sql .= "
    GROUP BY DATE(dh.thoi_gian)
    ORDER BY ngay DESC
";

$result = $conn->query($sql);
?>


<div class="grid_10">
    <div class="box round first grid">
        <!-- Form lọc theo ngày -->
        <h2>Doanh thu </h2>

<form method="GET" action="">
    <label for="ngay">Lọc theo ngày:</label>
    <input type="date" id="ngay" name="ngay" value="<?php echo isset($_GET['ngay']) ? $_GET['ngay'] : ''; ?>">
    <button type="submit">Lọc theo ngày</button>
</form>

<!-- Form lọc theo tháng -->
<form method="GET" action="" style="margin-bottom: 10px;">
    <label for="thang">Lọc theo tháng:</label>
    <input type="month" id="thang" name="thang" value="<?php echo isset($_GET['thang']) ? $_GET['thang'] : ''; ?>">
    <button type="submit">Lọc theo tháng</button>
</form>

        
        <table class="doanh-thu-table">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Số Đơn</th>
                    <th>Tổng Doanh Thu (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ngay'] . "</td>";
                        echo "<td>" . $row['so_don'] . "</td>";
                        echo "<td>" . number_format($row['tong_doanh_thu'], 0, ',', '.') . " VNĐ</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

<?php
// Đóng kết nối
$conn->close();
?>
