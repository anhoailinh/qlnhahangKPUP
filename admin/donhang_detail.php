<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include_once '../connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Không tìm thấy đơn hàng.</p>";
    exit();
}

$donhang_id = intval($_GET['id']);

// Truy vấn thông tin đơn hàng
$sql = "SELECT dh.id, dh.thoi_gian, dh.tong, dh.tong_tien, dh.trang_thai,
               kh.ten AS ten_khach_hang, b.ten_ban, gg.ten AS ten_giamgia, gg.giatri
        FROM don_hang dh
        JOIN khach_hang kh ON dh.user_id = kh.id
        LEFT JOIN ban b ON dh.ban_id = b.id
        LEFT JOIN giamgia gg ON dh.khuyenmai_id = gg.id
        WHERE dh.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donhang_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Đơn hàng không tồn tại.</p>";
    exit();
}

$donhang = $result->fetch_assoc();
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Chi tiết đơn hàng #<?php echo $donhang['id']; ?></h2>
        <div class="block">
            <p><strong>Người đặt:</strong> <?php echo $donhang['ten_khach_hang']; ?></p>
            <p><strong>Bàn:</strong> <?php echo $donhang['ten_ban'] ?? 'Không có'; ?></p>
            <p><strong>Thời gian:</strong> <?php echo date('d/m/Y H:i', strtotime($donhang['thoi_gian'])); ?></p>
            <p><strong>Tổng tiền:</strong> <?php echo number_format($donhang['tong']) . 'đ'; ?></p>
            <p><strong>Giảm giá:</strong> <?php echo $donhang['ten_giamgia'] ? $donhang['ten_giamgia'] . " (" . $donhang['giatri'] . "%)" : 'Không'; ?></p>
            <p><strong>Thành tiền sau giảm:</strong> <?php echo number_format($donhang['tong_tien']) . 'đ'; ?></p>
            <p><strong>Trạng thái:</strong> <?php echo $donhang['trang_thai']; ?></p>
        </div>

        <hr>

        <h3>Danh sách món ăn</h3>
<table class="data display">
    <thead>
        <tr style="
    border: 1px solid black;
    background: #4760a2;
    color: white;
">
            <th>STT</th>
            <th>Tên món</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql_ct = "SELECT m.name_mon, m.gia_mon, ctdh.so_luong
               FROM chi_tiet_don_hang ctdh
               JOIN monan m ON ctdh.mon_an_id = m.id_mon
               WHERE ctdh.don_hang_id = ?";
    $stmt_ct = $conn->prepare($sql_ct);
    $stmt_ct->bind_param("i", $donhang_id);
    $stmt_ct->execute();
    $result_ct = $stmt_ct->get_result();

    if ($result_ct->num_rows > 0) {
        $stt = 0;
        while ($row_ct = $result_ct->fetch_assoc()) {
            $stt++;
            $thanh_tien = $row_ct['so_luong'] * $row_ct['gia_mon'];
            echo "<tr>
                    <td>{$stt}</td>
                    <td>{$row_ct['name_mon']}</td>
                    <td>{$row_ct['so_luong']}</td>
                    <td>" . number_format($row_ct['gia_mon']) . "đ</td>
                    <td>" . number_format($thanh_tien) . "đ</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Không có món nào trong đơn hàng.</td></tr>";
    }
    ?>
    </tbody>
</table>
<a href="bill.php?donhang_id=<?php echo $donhang['id']; ?>" class="btn btn-info btn-sm">Hóa Đơn</a>


    </div>
</div>

<?php
include 'inc/footer.php';
?>
