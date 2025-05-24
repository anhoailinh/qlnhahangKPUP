<?php
include 'inc/header.php';
include 'connect.php'; // Kết nối CSDL

// Kiểm tra session customer_id
$id = Session::get('customer_id');
if (empty($id)) {
    echo "<script>window.location = '404.php'</script>";
    exit();
}

// Biến để lưu thông báo
$thongbao = "";

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = mysqli_real_escape_string($conn, $_POST['ten']);
    $sdt1 = mysqli_real_escape_string($conn, $_POST['sdt1']);
    $sex = mysqli_real_escape_string($conn, $_POST['gioitinh']);

    $sql_update = "UPDATE khach_hang SET ten = '$ten', sodienthoai = '$sdt1', gioitinh = '$sex' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql_update);

    if ($result) {
        $thongbao = "<div class='alert alert-success'>Thông tin đã được cập nhật thành công!</div>";
    } else {
        $thongbao = "<div class='alert alert-danger'>Có lỗi xảy ra khi cập nhật thông tin!</div>";
    }
}
?>

<style>
label {
    color: black;
    font-weight: bold;
}
</style>

<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Personal Information</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Personal Page <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-md-10">
                <div class="col-md-6 p-md-5">
                    <h2 class="h4 mb-2 mb-md-5 font-weight-bold">Personal Information</h2>
                    <?php echo $thongbao; ?>

                    <?php
                    $sql_select = "SELECT * FROM khach_hang WHERE id = '$id'";
                    $query = mysqli_query($conn, $sql_select);
                    if ($query && mysqli_num_rows($query) > 0) {
                        $user = mysqli_fetch_assoc($query);
                    ?>
                    <form class="login-form" action="" method="post">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="ten" value="<?php echo htmlspecialchars($user['ten']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase">Phone</label>
                            <input pattern="[0]{1}[0-9]{9}" name="sdt1" type="text" class="form-control" value="<?php echo htmlspecialchars($user['sodienthoai']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <div class="row" data-toggle="buttons">
                                <div class="col">
                                    <label class="btn btn-outline-secondary">Male
                                        <input type="radio" name="gioitinh" value="1" <?php if ($user['gioitinh'] == 1) echo 'checked'; ?>>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="btn btn-outline-secondary">Female
                                        <input type="radio" name="gioitinh" value="0" <?php if ($user['gioitinh'] == 0) echo 'checked'; ?>>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="submit" value="Cập nhật" class="btn btn-primary py-3 px-5">
                            <hr>
                            <button><a href="pass.php?id=<?php echo Session::get('customer_id'); ?>">Change Password</a></button>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>

            <!-- Danh sách party -->
            <!-- <div class="col-md-2">
                <div class="p-md-5">
                    <h2 class="h4 mb-2 mb-md-5 font-weight-bold">List Party</h2>
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>ID</th>
                                    <th>Date Book</th>
                                    <th>Number Of People</th>
                                    <th>Content</th>
                                    <th>Down payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_party = "SELECT * FROM party WHERE customer_id = '$id'";
                                $result_party = mysqli_query($conn, $sql_party);
                                if ($result_party && mysqli_num_rows($result_party) > 0) {
                                    $i = 0;
                                    while ($row = mysqli_fetch_assoc($result_party)) {
                                        $i++;
                                ?>
                                <tr class="text-center">
                                    <td><?php echo $i; ?></td>
                                    <td><a href="hopdong.php"><?php echo $row['sesis']; ?></a></td>
                                    <td><?php echo $row['dates']; ?></td>
                                    <td><?php echo $row['so_user']; ?></td>
                                    <td><?php echo $row['noidung']; ?></td>
                                    <td><?php echo number_format($row['thanhtien']) . " VNĐ"; ?></td>
                                    <td>
                                        <?php
                                        if ($row['tinhtrang'] == 0) {
                                            echo "Pending";
                                        } elseif ($row['tinhtrang'] == 1) {
                                            echo "Done";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
