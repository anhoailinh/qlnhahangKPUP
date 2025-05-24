<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include_once 'inc/connect.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách đơn hàng</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người đặt</th>
                        <th>Bàn</th>
                        <th>Thời gian</th>
                        <th>Tổng</th>
                        <th>Giảm giá</th>
                        <th>Thành tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $sql = "SELECT dh.id, dh.thoi_gian, dh.tong, dh.tong_tien, dh.trang_thai, 
               kh.ten AS ten_khach_hang, 
               b.ten_ban, 
               gg.ten
        FROM don_hang dh
        JOIN khach_hang kh ON dh.user_id = kh.id
        LEFT JOIN ban b ON dh.ban_id = b.id
        LEFT JOIN giamgia gg ON dh.khuyenmai_id = gg.id
        ORDER BY dh.thoi_gian DESC";

                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['ten_khach_hang']; ?></td>
<td><?php echo $row['ten_ban']; ?></td>
<td><?php echo date('d/m/Y H:i', strtotime($row['thoi_gian'])); ?></td>
<td><?php echo number_format($row['tong']) . 'đ'; ?></td>
<td><?php echo $row['ten'] ?? 'Không'; ?></td>
<td><?php echo number_format($row['tong_tien']) . 'đ'; ?></td>

                    <td>
                        <form method="POST" action="capnhat_trangthai_donhang.php">
                            <input type="hidden" name="donhang_id" value="<?php echo $row['id']; ?>">
                            <select name="trang_thai" onchange="this.form.submit()">
                                <option value="Chờ xử lý" <?php if ($row['trang_thai'] == 'Chờ xử lý') echo 'selected'; ?>>Chờ xử lý</option>
                                <option value="Đang chuẩn bị" <?php if ($row['trang_thai'] == 'Đang chuẩn bị') echo 'selected'; ?>>Đang chuẩn bị</option>
                                <option value="Hoàn tất" <?php if ($row['trang_thai'] == 'Hoàn tất') echo 'selected'; ?>>Hoàn tất</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="donhang_detail.php?id=<?php echo $row['id']; ?>">Xem</a>
                    </td>
                    <td>
                        <a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?');" href="donhangdelete.php?id=<?php echo $row['id']; ?>">Xóa</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="10">Chưa có đơn hàng nào.</td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
