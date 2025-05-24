<?php
// Kết nối cơ sở dữ liệu
include 'inc/header.php';
include 'inc/sidebar.php';
include_once '../connect.php';

$donhang_id = intval($_GET['donhang_id']);

// Truy vấn đơn hàng cùng tên khách hàng
$sql = "SELECT dh.*, kh.ten AS ten_khach_hang 
        FROM don_hang dh 
        JOIN khach_hang kh ON dh.user_id = kh.id 
        WHERE dh.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donhang_id);
$stmt->execute();
$result = $stmt->get_result();
$donHang = $result->fetch_assoc();
$stmt->close();

if (!$donHang) {
    echo "Không tìm thấy đơn hàng.";
    exit;
}

// Tính giảm giá
$giamGia = $donHang['tong'] - $donHang['tong_tien'];

// Lấy tên bàn
$ban_id = $donHang['ban_id'];
$ten_ban = "Không rõ";
$sqlBan = "SELECT ten_ban FROM ban WHERE id = ?";
$stmtBan = $conn->prepare($sqlBan);
$stmtBan->bind_param("i", $ban_id);
$stmtBan->execute();
$stmtBan->bind_result($ten_ban);
$stmtBan->fetch();
$stmtBan->close();

// Truy vấn chi tiết món ăn
$sql_chi_tiet = "
    SELECT ctdh.mon_an_id, ctdh.so_luong, ctdh.trang_thai_mon, ma.name_mon, ma.gia_mon
    FROM chi_tiet_don_hang ctdh
    JOIN monan ma ON ctdh.mon_an_id = ma.id_mon
    WHERE ctdh.don_hang_id = ?
";
$stmtChiTiet = $conn->prepare($sql_chi_tiet);
$stmtChiTiet->bind_param("i", $donhang_id);
$stmtChiTiet->execute();
$chiTietResult = $stmtChiTiet->get_result();




?>


   
</section>
<div class="grid_10">
    <div class="box round first grid">
      
    <div class="bill-container">
        <h1>Hoá Đơn Đơn Hàng</h1>

        <div class="order-info">
            <p><strong>ID Đơn Hàng:</strong> <?php echo $donHang['id']; ?></p>
            <p><strong>Mã khách hàng:</strong> <?php echo $donHang['user_id']; ?></p>
            <p><strong>Tên khách hàng:</strong> <?php echo $donHang['ten_khach_hang']; ?></p>

            <p><strong>Bàn:</strong> <?php echo $ten_ban; ?></p>


            <p><strong>Thời Gian:</strong> <?php echo $donHang['thoi_gian']; ?></p>
            <p><strong>Trạng Thái:</strong> <?php echo $donHang['trang_thai']; ?></p>
            <table class="order-details">
    <thead>
        <tr>
            <th>Tên Món Ăn</th>
            <th>Giá</th>

            <th>Số Lượng</th>
            <th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $chiTietResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name_mon']; ?></td>
                <td><?php echo number_format($row['gia_mon'], 0, ',', '.'); ?>VNĐ</td>

                <td><?php echo $row['so_luong']; ?></td>
                <td><?php echo number_format($row['gia_mon'] * $row['so_luong'], 0, ',', '.'); ?>VNĐ</td>

            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
            <!-- <p><strong>Khuyến Mãi ID:</strong> <?php //echo $donHang['khuyenmai_id']; ?></p> -->
            <p><strong>Tổng:</strong> <?php echo number_format($donHang['tong'], 0, ',', '.'); ?> VNĐ</p>
            <p><strong>Giảm Giá:</strong> <?php echo number_format($giamGia, 0, ',', '.'); ?> VNĐ</p>
            <p><strong>Tổng Tiền:</strong> <?php echo number_format($donHang['tong_tien'], 0, ',', '.'); ?> VNĐ</p>
        </div>

        


    </div>
   
    </div>
    </div>



<?php
include 'inc/footer.php';
?>

