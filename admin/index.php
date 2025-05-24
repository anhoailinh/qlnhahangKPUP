<?php
include 'inc/header.php';
include 'inc/sidebar.php';

// Kết nối CSDL
include 'inc/connect.php';

// Truy vấn số bàn trống
$sql_trong = "SELECT COUNT(*) as so_trong FROM ban WHERE trang_thai = 'trong'";
$result_trong = mysqli_query($conn, $sql_trong);
$row_trong = mysqli_fetch_assoc($result_trong);
$so_trong = $row_trong['so_trong'];

// Truy vấn số bàn đã đặt
$sql_dat = "SELECT COUNT(*) as so_da_dat FROM ban WHERE trang_thai = 'da_dat'";
$result_dat = mysqli_query($conn, $sql_dat);
$row_dat = mysqli_fetch_assoc($result_dat);
$so_da_dat = $row_dat['so_da_dat'];

// Truy vấn tổng số bàn
$sql_total_ban = "SELECT COUNT(*) as tong_ban FROM ban";
$result_total_ban = mysqli_query($conn, $sql_total_ban);
$row_total_ban = mysqli_fetch_assoc($result_total_ban);
$tong_ban = $row_total_ban['tong_ban'];

// Tổng số khách hàng
$sql_khach = "SELECT COUNT(*) as tong_khach FROM khach_hang";
$result_khach = mysqli_query($conn, $sql_khach);
$tong_khach = mysqli_fetch_assoc($result_khach)['tong_khach'];

// Tổng số món ăn
$sql_monan = "SELECT COUNT(*) as tong_mon FROM monan";
$result_monan = mysqli_query($conn, $sql_monan);
$tong_mon = mysqli_fetch_assoc($result_monan)['tong_mon'];

// Tổng số loại món
$sql_loai = "SELECT COUNT(*) as tong_loai FROM loai_mon";
$result_loai = mysqli_query($conn, $sql_loai);
$tong_loai = mysqli_fetch_assoc($result_loai)['tong_loai'];

// Tổng số món đang bán
$sql_ban = "SELECT COUNT(*) as mon_dang_ban FROM monan WHERE tinhtrang = '1'";
$result_ban = mysqli_query($conn, $sql_ban);
$mon_dang_ban = mysqli_fetch_assoc($result_ban)['mon_dang_ban'];

// Tổng số món đặc biệt
$sql_special = "SELECT COUNT(*) as mon_dac_biet FROM monan WHERE special = '1'";
$result_special = mysqli_query($conn, $sql_special);
$mon_dac_biet = mysqli_fetch_assoc($result_special)['mon_dac_biet'];

// Đếm số đơn hàng trong ngày hôm nay
$sql_today = "SELECT COUNT(*) as don_hom_nay FROM don_hang WHERE DATE(thoi_gian) = CURDATE()";
$result_today = mysqli_query($conn, $sql_today);
$don_hom_nay = mysqli_fetch_assoc($result_today)['don_hom_nay'];


mysqli_close($conn);
?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Trang tổng quan admin</h2>

        <div class="contentt">
          <div class="block">
            <h3>Thống kê tổng quan</h3>
            <ul style="font-size: 16px; line-height: 1.8;">
                <li><strong>Đơn hàng hôm nay:</strong> 
               
              </li>
                <li><strong>Tổng khách hàng:</strong> <?= $tong_khach ?></li>
                <li><strong>Tổng món ăn:</strong> <?= $tong_mon ?></li>
                <li><strong>Tổng loại món:</strong> <?= $tong_loai ?></li>
                <li><strong>Món đang bán:</strong> <?= $mon_dang_ban ?></li>
                <li><strong>Món đặc biệt:</strong> <?= $mon_dac_biet ?></li>
                <li><strong>Tổng số bàn:</strong> <?= $tong_ban ?></li> <!-- Hiển thị tổng số bàn -->
            </ul>
        </div>

        <div class="block">
            <h3>Biểu đồ trạng thái bàn</h3>
            <canvas id="banChart" style="max-width: 300px; max-height: 300px;"></canvas>
        </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('banChart').getContext('2d');
    const banChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Bàn trống', 'Bàn đã đặt'],
            datasets: [{
                data: [<?= $so_trong ?>, <?= $so_da_dat ?>],
                backgroundColor: ['#4CAF50', '#F44336'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Tình trạng các bàn hiện tại'
                }
            }
        }
    });
</script>
