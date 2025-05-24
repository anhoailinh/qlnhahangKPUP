<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include 'inc/connect.php';?>
<?php
// Truy vấn danh sách mã giảm giá
$sql = "SELECT * FROM giamgia ORDER BY ngay_bat_dau DESC";
$result = $conn->query($sql);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách mã giảm giá</h2>
        
      

        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tên</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
					<th>Đơn tối thiểu</th>
					<th>Ngày bắt đầu</th>
					<th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    
				</tr>
			</thead>
			<tbody>
			<?php
				if ($result && $result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
			?>
				<tr class="odd gradeX">
					<td><?php echo $row['id']; ?></td>
					<td><?php echo htmlspecialchars($row['ten']); ?></td>
                    <td><?php echo $row['loai'] == 'phantram' ? 'Phần trăm' : 'Tiền mặt'; ?></td>
                    <td><?php echo $row['loai'] == 'phantram' ? $row['giatri'] . '%' : number_format($row['giatri'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?php echo number_format($row['don_toi_thieu'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['ngay_bat_dau'])); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['ngay_ket_thuc'])); ?></td>
                    <td><?php echo $row['trang_thai'] == 1 ? 'Hiển thị' : 'Ẩn'; ?></td>
                    
				</tr>
			<?php
					}
				} else {
					echo '<tr><td colspan="9" style="text-align:center;">Không có mã giảm giá nào</td></tr>';
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
