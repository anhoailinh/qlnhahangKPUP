<?php

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['customer_login']) || $_SESSION['customer_login'] !== true) {
    echo "<script>
        alert('Bạn cần đăng nhập để xem giỏ hàng.');
        window.location.href = 'login.php';
    </script>";
    exit;
}


$user_id = (int)$_SESSION['customer_id'];  // Lấy user_id từ session

// Xử lý xóa sản phẩm trong giỏ hàng
// Xử lý xóa sản phẩm trong giỏ hàng
if (isset($_GET['delid'])) {
    $cart_id = (int)$_GET['delid'];
    $delete_cart = "DELETE FROM giohang WHERE id = $cart_id AND user_id = $user_id";
    if ($conn->query($delete_cart)) {
        header("Location: cartt.php"); // ✅ Redirect lại chính trang này để làm sạch URL và không hiển thị gì
        exit;
    }
}


// Lấy giỏ hàng của người dùng, sắp xếp theo thời gian thêm vào giỏ (cập nhật sẽ đẩy sản phẩm lên đầu)
// Lấy giỏ hàng của người dùng, sắp xếp theo thời gian thêm vào giỏ (cập nhật sẽ đẩy sản phẩm lên đầu)
$get_cart = "SELECT giohang.id, giohang.quantity AS soluong, giohang.product_id, monan.name_mon, monan.gia_mon, monan.images 
            FROM giohang
            JOIN monan ON giohang.product_id = monan.id_mon
            WHERE giohang.user_id = $user_id
            ORDER BY giohang.added_at DESC"; // Sắp xếp theo added_at (thời gian mới nhất sẽ ở đầu)

$result_cart = $conn->query($get_cart);
$subtotal = 0;  // Khai báo biến tổng tiền

// Cập nhật số lượng sản phẩm trong giỏ hàng và thời gian
if (isset($_POST['update_cart'])) {
    $cart_id = (int)$_POST['cartid'];
    $quantity = (int)$_POST['soluong'];

    // Cập nhật lại số lượng và thời gian thêm món vào giỏ hàng
    $update_cart = "UPDATE giohang 
                    SET quantity = $quantity, added_at = NOW()  // Cập nhật lại thời gian
                    WHERE id = $cart_id AND user_id = $user_id";

    if ($conn->query($update_cart)) {
        // Nếu thành công, sắp xếp lại giỏ hàng theo thời gian
        header("Location: cartt.php"); // Tải lại trang giỏ hàng để thấy sự thay đổi
        exit; // Dừng lại để tránh thực thi thêm mã sau khi tải lại trang
    } else {
        echo "<p>Đã có lỗi xảy ra khi cập nhật số lượng.</p>";
    }
}

// Lấy các mã giảm giá còn hiệu lực từ bảng giamgia
$get_discounts = "SELECT id, ten, giatri, loai, don_toi_thieu, ngay_bat_dau, ngay_ket_thuc 
                  FROM giamgia 
                  WHERE trang_thai = 1 AND CURDATE() BETWEEN ngay_bat_dau AND ngay_ket_thuc";

$result_discounts = $conn->query($get_discounts);

$ds_ban = []; // Mảng chứa cả ban_id và ten_ban

$get_table = "SELECT ban_id FROM dat_ban WHERE user_id = $user_id";
$result_table = $conn->query($get_table);

if ($result_table && $result_table->num_rows > 0) {
    while ($row = $result_table->fetch_assoc()) {
        $ban_id = $row['ban_id'];
        $get_table_name = "SELECT ten_ban FROM ban WHERE id = $ban_id";
        $result_table_name = $conn->query($get_table_name);

        if ($result_table_name && $result_table_name->num_rows > 0) {
            $row_table_name = $result_table_name->fetch_assoc();
            $ds_ban[] = [
                'id' => $ban_id,
                'ten' => $row_table_name['ten_ban']
            ];
        }
    }
}


// // Xử lý thanh toán
// if (isset($_POST['pay'])) {
//     $totalAmount = $_POST['total_amount']; // Tổng tiền thanh toán
//     $discountId = $_POST['discount_id']; // Mã giảm giá (nếu có)
//     $orderDate = date("Y-m-d H:i:s");

//     // Insert vào bảng hóa đơn
//     $insert_order = "INSERT INTO hoadon (user_id, total_amount, discount_id, order_date) 
//                      VALUES ($user_id, $totalAmount, $discountId, '$orderDate')";

//     if ($conn->query($insert_order)) {
//         $orderId = $conn->insert_id; // Lấy ID của hóa đơn vừa tạo

//         // Lấy các sản phẩm từ giỏ hàng
//         $cart_query = "SELECT id, product_id, quantity, total_price FROM giohang WHERE user_id = $user_id";
//         $cart_result = $conn->query($cart_query);
//         if ($cart_result && $cart_result->num_rows > 0) {
//             while ($cart_item = $cart_result->fetch_assoc()) {
//                 // Thêm sản phẩm vào bảng chi tiết hóa đơn
//                 $insert_order_detail = "INSERT INTO chi_tiet_hoadon (order_id, product_id, quantity, price)
//                                         VALUES ($orderId, {$cart_item['product_id']}, {$cart_item['quantity']}, {$cart_item['total_price']})";

//                 $conn->query($insert_order_detail);
//             }
//         }

//         // Xóa sản phẩm đã thanh toán khỏi giỏ hàng
//         $delete_cart = "DELETE FROM giohang WHERE user_id = $user_id";
//         $conn->query($delete_cart);

//         // Chuyển hướng đến trang hóa đơn
//         header("Location: bill.php?order_id=$orderId");
//         exit;
//     } else {
//         echo "<p>Lỗi trong việc thanh toán, vui lòng thử lại!</p>";
//     }
// }



// Đơn hàng
// Lấy giá trị từ form (Giả sử các giá trị này được gửi qua POST)
// Đơn hàng
// Lấy giá trị từ form (Giả sử các giá trị này được gửi qua POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $khuyenmai_id = $_POST['discount_id'] ?? 0;
    $tong = $_POST['tong'] ?? 0;
    $tong_tien = $_POST['tong_tien'] ?? 0;
    $gio_hang_json = $_POST['gio_hang'] ?? '[]';
    $gio_hang = json_decode($gio_hang_json, true);

    // Validate giỏ hàng
    if (!is_array($gio_hang) || empty($gio_hang)) {
        die('Giỏ hàng không hợp lệ hoặc trống.');
    }

    // Validate tổng và tổng tiền
    if (!is_numeric($tong) || !is_numeric($tong_tien)) {
        die('Giá trị tổng và tổng tiền không hợp lệ.');
    }

    $ban_id = $_POST['ban_id'] ?? null;

    if (!$ban_id || $ban_id == 0) {
        die('Vui lòng chọn bàn đã đặt hợp lệ!');
    }

    // Thời gian và trạng thái
    $thoi_gian = date("Y-m-d H:i:s");
    $trang_thai = 'Đã đặt';

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Chèn đơn hàng vào bảng don_hang
        $sql_don_hang = "INSERT INTO don_hang (ban_id, user_id, thoi_gian, trang_thai, khuyenmai_id, tong, tong_tien)
                 VALUES ('$ban_id', '$user_id', '$thoi_gian', '$trang_thai', '$khuyenmai_id', '$tong', '$tong_tien')";


        if ($conn->query($sql_don_hang) === TRUE) {
            $don_hang_id = $conn->insert_id;

            // Chèn chi tiết đơn hàng vào bảng chi_tiet_don_hang
            foreach ($gio_hang as $key => $item) {
                $giohang_id = $item['giohang_id'];  // Sử dụng giohang_id từ giỏ hàng
                $product_id = $item['product_id'];  // ID sản phẩm
                $so_luong = $item['quantity'];
                $trang_thai_mon = 'Đã đặt';
            
                $sql_chi_tiet = "INSERT INTO chi_tiet_don_hang (don_hang_id, mon_an_id, so_luong, trang_thai_mon)
                                 VALUES ('$don_hang_id', '$product_id', '$so_luong', '$trang_thai_mon')";
            
                if (!$conn->query($sql_chi_tiet)) {
                    throw new Exception("Lỗi khi thêm chi tiết đơn hàng: " . $conn->error);
                }
                
                // Sau khi thêm vào chi_tiet_don_hang, xóa món khỏi bảng giohang
                $sql_xoa_giohang = "DELETE FROM giohang WHERE id = '$giohang_id'"; // Sử dụng giohang_id để xóa đúng mục trong giỏ hàng
                if (!$conn->query($sql_xoa_giohang)) {
                    throw new Exception("Lỗi khi xóa món khỏi giỏ hàng: " . $conn->error);
                }
            }

            // Commit giao dịch
            $conn->commit();

            // Chuyển hướng đến bill.php với tham số donhang_id
            echo "<script>
                    alert('Đơn hàng đã được thêm thành công!');
                    window.location.href = 'bill.php?donhang_id=" . $don_hang_id . "'; // Chuyển hướng tới trang bill.php với donhang_id
                  </script>";

        } else {
            throw new Exception("Lỗi khi thêm đơn hàng: " . $conn->error);
        }
    } catch (Exception $e) {
        // Rollback giao dịch khi có lỗi
        $conn->rollback();
        echo $e->getMessage();
    }
}


?>




<!-- Section Hero -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Specialties</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Detail <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>


<!-- Section Product Details -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <?php
            // Lấy thông tin chi tiết món
            $get_detail = $mon->get_detail($id);
            if ($get_detail) {
                while ($result_detail = $get_detail->fetch_assoc()) {
            ?>
            <div class="col-lg-6 mb-5 ftco-animate">
                <form action="" method="POST">
                    <a href="images/menu-2.jpg" class="image-popup">
                        <img src="images/food/<?php echo $result_detail['images'] ?>" class="img-fluid" alt="Ảnh món">
                    </a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h2><?php echo $result_detail['name_mon'] ?></h2>
                <h4>Loại món: <?php echo $result_detail['name_loai']; ?> </h4>
                <p class="price"><span><?php echo $fm->formatMoney($result_detail['gia_mon']) ?> VNĐ</span></p>
                <p><?php echo $result_detail['ghichu_mon'] ?></p>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group d-flex"></div>
                    </div>


                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
                        <div>
                            <!-- Hidden input chứa id món -->
                            <input type="hidden" name="id_mon" value="<?php echo $result_detail['id_mon'] ?>">
                            <!-- Input số lượng -->
                            <input type="number" name="soluong" class="form-control input-number" value="1" min="1" max="20">
                        </div>
                        <!-- Button thêm vào giỏ -->
                        <input style="margin-left: 15px;" type="submit" name="submit" value="Add to cart" class="btn btn-primary py-3 px-5">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex"></div>
                    </div>
                    <h6><br></h6>
                    <p>Mô tả chi tiết: <?php echo $result_detail['detail']; ?></p>
                </div>
                </form>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>


<?php
include 'inc/footer.php'; // Include footer
?>



<div class="detail-container">
    <h2><?= htmlspecialchars($mon['name_mon']) ?></h2>
    <img src="images/food/<?= htmlspecialchars($mon['images']) ?>" alt="<?= htmlspecialchars($mon['name_mon']) ?>" class="detail-image">
    <p><strong>Giá:</strong> <?= number_format($mon['gia_mon'], 0, ',', '.') ?> VNĐ</p>
    <p><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($mon['ghichu_mon'])) ?></p>

    <form action="addcart.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $mon['id_mon'] ?>">  <!-- Thông tin sản phẩm -->
        <input type="number" name="quantity" value="1" min="1" required> <!-- Số lượng sản phẩm -->
        <button type="submit">Thêm vào giỏ hàng</button>
    </form>



    <p><a href="menu.php" class="btn">← Quay lại thực đơn</a></p>
</div>