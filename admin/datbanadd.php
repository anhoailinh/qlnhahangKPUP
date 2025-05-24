<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../connect.php'; ?>

<!-- Hộp thoại hỏi khách hàng đã có tài khoản chưa -->
<script>
    window.onload = function() {
        const result = confirm("Khách hàng đã có tài khoản chưa?");
        if (result) {
            // Nếu có tài khoản → hiện form chọn tài khoản đã có
            document.getElementById('form-chon-tai-khoan').style.display = 'block';
        } else {
            // Nếu chưa → chuyển đến trang tạo tài khoản mới
            window.location.href = 'khachhangadd.php';
        }
    };
</script>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm đặt bàn</h2>
        <div class="block" id="form-chon-tai-khoan" style="display: none;">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user_id = $_POST['user_id'];
                $ban_id = $_POST['ban_id'];
                $so_nguoi = $_POST['so_nguoi'];
                $thoi_gian = $_POST['thoi_gian'];
                $ghi_chu = $_POST['ghi_chu'];

                if (empty($user_id) || empty($ban_id) || empty($so_nguoi) || empty($thoi_gian)) {
                    echo "<span class='error'>Vui lòng điền đầy đủ thông tin.</span>";
                } else {
                    $sql = "INSERT INTO dat_ban (user_id, ban_id, so_nguoi, thoi_gian, ghi_chu, created_at)
                            VALUES ('$user_id', '$ban_id', '$so_nguoi', '$thoi_gian', '$ghi_chu', NOW())";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Đặt bàn thành công!'); window.location.href='booktable.php';</script>";
                    } else {
                        echo "<span class='error'>Lỗi: " . $conn->error . "</span>";
                    }
                }
            }
            ?>

            <form action="" method="POST">
                <table class="form">					
                    <tr>
                        <td class="label">Khách hàng</td>
                        <td>
                            <select name="user_id">
                                <option value="">-- Chọn khách hàng --</option>
                                <?php
                                $sqlUsers = "SELECT * FROM khach_hang ORDER BY id DESC";
                                $users = $conn->query($sqlUsers);
                                while ($row = $users->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['ten'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Chọn bàn</td>
                        <td>
                        <select name="ban_id">
    <option value="">-- Chọn bàn --</option>
    <?php
    $now = date('Y-m-d H:i:s');
    $sqlBan = "SELECT * FROM ban 
               WHERE id NOT IN (
                   SELECT ban_id FROM dat_ban 
                   WHERE thoi_gian > '$now'
               )";
    $ban = $conn->query($sqlBan);
    while ($row = $ban->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['ten_ban'] . "</option>";
    }
    ?>
</select>

                        </td>
                    </tr>
                    <tr>
                        <td class="label">Số người</td>
                        <td><input type="number" name="so_nguoi" min="1" /></td>
                    </tr>
                    <tr>
                        <td class="label">Thời gian</td>
                        <td><input type="datetime-local" name="thoi_gian" /></td>
                    </tr>
                    <tr>
                        <td class="label">Ghi chú</td>
                        <td><textarea name="ghi_chu"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Thêm đặt bàn" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);

    // Nếu có skip=1 (vừa tạo tài khoản xong) thì không hỏi lại, show luôn form
    if (urlParams.get('skip') === '1') {
        document.getElementById('form-chon-tai-khoan').style.display = 'block';
        return;
    }

    // Nếu không có ?skip → hỏi người dùng
    const result = confirm("Khách hàng đã có tài khoản chưa?");
    if (result) {
        document.getElementById('form-chon-tai-khoan').style.display = 'block';
    } else {
        // Nếu chưa có → chuyển sang khachhangadd kèm ?from=datbanadd
        window.location.href = 'khachhangadd.php?from=datbanadd';
    }
};
</script>





<?php include 'inc/footer.php';?>
