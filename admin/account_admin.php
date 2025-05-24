<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<?php 
    // Xử lý xóa tài khoản
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);

        $sql = "DELETE FROM tb_admin WHERE id_admin = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            echo "<script>alert('Xóa tài khoản thành công!'); window.location.href = 'account_admin.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa tài khoản!');</script>";
        }
        $stmt->close();
    }

    // Lấy dữ liệu từ bảng tb_admin
    $sql = "SELECT id_admin, Name_admin, adminuser, role FROM tb_admin";
    $result = $conn->query($sql);
?> 

<div class="grid_10">
    <div class="box round first grid">
        <h2 style="display: flex; justify-content: space-between;">Danh sách tài khoản admin </h2>
        <a href="accountadd_admin.php" class="btn-them">+ Thêm</a>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Tên Admin</th>
                        <th>Tên đăng nhập</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["Name_admin"] ?? '') ?></td>
                            <td><?= htmlspecialchars($row["adminuser"] ?? '') ?></td>
                            <td><?= isset($row["role"]) ? ($row["role"] == 1 ? 'Admin' : 'Nhân viên') : '' ?></td>

                            <td>
                                <a href="accountedit_admin.php?id=<?= urlencode($row['id_admin']) ?>">Sửa</a> | 
                                <a href="account_admin.php?delete_id=<?= urlencode($row['id_admin']) ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                   Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">Không có dữ liệu</td></tr>
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
