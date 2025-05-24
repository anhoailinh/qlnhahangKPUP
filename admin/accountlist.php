<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php 
    // Lấy dữ liệu từ database
    $sql = "SELECT id, ten, sodienthoai, gioitinh, solandat, ghichu FROM khach_hang";
    $result = $conn->query($sql);
?> 

<div class="grid_10">
    <div class="box round first grid">
        <h2 style="    display: flex; justify-content: space-between;">Danh sách tài khoản khách hàng </h2>
        <a href="accountadd.php" class="btn-them">+ Thêm</a>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Giới tính</th>
                        <th>Số lần đặt</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th> <!-- Cột Action -->
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["ten"] ?? '') ?></td>
                            <td><?= htmlspecialchars($row["sodienthoai"] ?? '') ?></td>
                            <td><?= ($row["gioitinh"] ?? '') == 1 ? "Nam" : "Nữ" ?></td>
                            <td><?= htmlspecialchars($row["solandat"] ?? '0') ?></td>
                            <td><?= htmlspecialchars($row["ghichu"] ?? 'Không có ghi chú') ?></td>
                            <td>
                                <a href="accountedit.php?id=<?= urlencode($row['id']) ?>">Sửa</a> | 
                                <a href="deleteaccount.php?id=<?= urlencode($row['id']) ?>" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">Không có dữ liệu</td></tr>
                <?php endif; ?>
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

<?php include 'inc/footer.php'; ?>
