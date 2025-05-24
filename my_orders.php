<?php
include 'inc/header.php';
include 'connect.php';

// Lấy user ID nếu bạn có hệ thống đăng nhập (ví dụ dùng session)
$user_id = $_SESSION['customer_id']; // ✅ Đúng theo session đang dùng

 // hoặc bỏ dòng này nếu không có session

// Lấy danh sách đơn hàng
$sql = "SELECT dh.id, dh.thoi_gian, dh.tong_tien, kh.ten AS ten_khach_hang, b.ten_ban
        FROM don_hang dh
        JOIN khach_hang kh ON dh.user_id = kh.id
        LEFT JOIN ban b ON dh.ban_id = b.id
        WHERE dh.user_id = ?
        ORDER BY dh.id DESC";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // comment dòng này nếu không lọc theo user
$stmt->execute();
$result = $stmt->get_result();
?>
<!-- Section Hero -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');  height: 130px; " data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
  
</section>


<section class="ssbill">
    <div class="bill-container">
        <h1>Danh Sách Hóa Đơn</h1>

        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên Khách Hàng</th>
                    <th>Bàn</th>
                    <th>Thời Gian</th>
                    <th>Tổng Tiền</th>
                    <th>Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['ten_khach_hang']; ?></td>
                        <td><?php echo $row['ten_ban']; ?></td>
                        <td><?php echo $row['thoi_gian']; ?></td>
                        <td><?php echo number_format($row['tong_tien'], 0, ',', '.'); ?> VNĐ</td>
                        <td><a href="bill.php?donhang_id=<?php echo $row['id']; ?>">Xem</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
include 'inc/footer.php';
$conn->close();
?>
