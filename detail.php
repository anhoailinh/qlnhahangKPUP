<?php
include 'inc/header.php';
include 'connect.php';

if (isset($_GET['monid'])) {
    $id_mon = (int)$_GET['monid'];

    // Truy vấn kết hợp bảng monan và loai_mon
    $sql = "SELECT monan.*, loai_mon.name_loai 
            FROM monan
            LEFT JOIN loai_mon ON monan.id_loai = loai_mon.id_loai 
            WHERE monan.id_mon = $id_mon";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $mon = $result->fetch_assoc();
    } else {
        echo "<p>Không tìm thấy món ăn.</p>";
        exit;
    }
} else {
    echo "<p>Không có món ăn được chọn.</p>";
    exit;
}
?>

<!-- Section Hero -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Chi tiết</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Chi tiết <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Cột ảnh món ăn -->
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="images/food/<?php echo $mon['images']; ?>" class="image-popup">
                    <img src="images/food/<?php echo $mon['images']; ?>" class="img-fluid" alt="Ảnh món">
                </a>
            </div>

            <!-- Cột thông tin món ăn -->
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h2><?php echo htmlspecialchars($mon['name_mon']); ?></h2>
                <h4>Loại món: <?php echo htmlspecialchars($mon['name_loai'] ?? 'Chưa phân loại'); ?></h4>
                <p class="price"><span><?php echo number_format($mon['gia_mon'], 0, ',', '.') ?> VNĐ</span></p>
                <p><?php echo nl2br(htmlspecialchars($mon['ghichu_mon'])); ?></p>

                <!-- Form thêm vào giỏ hàng -->
                <form action="addcart.php" method="POST">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input type="hidden" name="product_id" value="<?php echo $mon['id_mon'] ?>">
                            <label for="quantity">Số lượng:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="20" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary py-3 px-5" style="margin-top: 30px;">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </form>

                <h6 class="mt-4">Mô tả chi tiết:</h6>
                <p><?php echo nl2br(htmlspecialchars($mon['detail'] ?? 'Không có mô tả thêm.')); ?></p>
            </div>
        </div>
    </div>
</section>

<?php
include 'inc/footer.php'; // Include footer
?>
