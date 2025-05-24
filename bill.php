<?php
// Kết nối cơ sở dữ liệu
include 'inc/header.php';
include 'connect.php';

// Lấy ID đơn hàng từ URL (hoặc có thể là session, hoặc input form)
$donHangId = $_GET['donhang_id']; // Ví dụ: /bill.php?donhang_id=1

// Truy vấn thông tin đơn hàng từ bảng don_hang
$sql = "SELECT * FROM don_hang WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donHangId);
$stmt->execute();
$donHangResult = $stmt->get_result();
$donHang = $donHangResult->fetch_assoc();

$giamGia = $donHang['tong'] - $donHang['tong_tien'];

// Truy vấn chi tiết đơn hàng từ bảng chi_tiet_don_hang
$sqlDetails = "SELECT * FROM chi_tiet_don_hang WHERE don_hang_id = ?";
$stmtDetails = $conn->prepare($sqlDetails);
$stmtDetails->bind_param("i", $donHangId);
$stmtDetails->execute();
$chiTietResult = $stmtDetails->get_result();

$ban_id = $donHang['ban_id'];
$sqlBan = "SELECT ten_ban FROM ban WHERE id = $ban_id";
$resultBan = $conn->query($sqlBan);

$ten_ban = "Không rõ";
if ($resultBan && $resultBan->num_rows > 0) {
    $rowBan = $resultBan->fetch_assoc();
    $ten_ban = $rowBan['ten_ban'];
}

$donhang_id = $_GET['donhang_id'];
$sql = "SELECT dh.*, kh.ten AS ten_khach_hang 
        FROM don_hang dh 
        JOIN khach_hang kh ON dh.user_id = kh.id 
        WHERE dh.id = '$donhang_id'";
$donHang = $conn->query($sql)->fetch_assoc();


$donhang_id = $_GET['donhang_id'];
$sql_chi_tiet = "
    SELECT ctdh.mon_an_id, ctdh.so_luong, ctdh.trang_thai_mon, ma.name_mon, ma.gia_mon
    FROM chi_tiet_don_hang ctdh
    JOIN monan ma ON ctdh.mon_an_id = ma.id_mon
    WHERE ctdh.don_hang_id = '$donhang_id'
";

$chiTietResult = $conn->query($sql_chi_tiet);


$stmt->close();
$stmtDetails->close();
$conn->close();



?>

<!-- Section Hero -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');  height: 130px; " data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
   
</section>

<section class="ssbill">
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
    </section>


<?php
include 'inc/footer.php';
?>

