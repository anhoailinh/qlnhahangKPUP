<?php
// Kết nối cơ sở dữ liệu
include 'inc/header.php';
include 'connect.php';  // Thêm kết nối đến cơ sở dữ liệu của bạn

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
    echo "<script>alert('Giỏ hàng không hợp lệ hoặc trống.'); window.history.back();</script>";
    exit;
}

// Validate tổng và tổng tiền
if (!is_numeric($tong) || !is_numeric($tong_tien)) {
    echo "<script>alert('Giá trị tổng và tổng tiền không hợp lệ.'); window.history.back();</script>";
    exit;
}

$ban_id = $_POST['ban_id'] ?? null;

if (!$ban_id || $ban_id == 0) {
    echo "<script>alert('Vui lòng chọn bàn đã đặt hợp lệ!'); window.history.back();</script>";
    exit;
}

    // Thời gian và trạng thái
    $thoi_gian = date("Y-m-d H:i:s");
    $trang_thai = 'Đã đặt';

    // Bắt đầu giao dịch
    $conn->begin_transaction();
$finalAmount = $_POST['finalAmount'] ?? 0;
    try {
        // Chèn đơn hàng vào bảng don_hang
        $sql_don_hang = "INSERT INTO don_hang (ban_id, user_id, thoi_gian, trang_thai, khuyenmai_id, tong, tong_tien)
                 VALUES ('$ban_id', '$user_id', '$thoi_gian', '$trang_thai', '$khuyenmai_id', '$tong', '$tong_tien')";


        if ($conn->query($sql_don_hang) === TRUE) {
            $don_hang_id = $conn->insert_id;

            // Chèn chi tiết đơn hàng vào bảng chi_tiet_don_hang
            foreach ($gio_hang as $key => $item) {
                print_r(value: $gio_hang);
                $giohang_id = $item['giohang_id'];  // Sử dụng giohang_id từ giỏ hàng
                $product_id = $item['product_id'];  // ID sản phẩm
                $so_luong = $item['quantity'];
                $trang_thai_mon = 'Đã đặt';
            echo "Tổng: " . $tong . "<br>";
echo "Tổng tiền (sau giảm giá): " . $tong_tien . "<br>";

                $sql_chi_tiet = "INSERT INTO chi_tiet_don_hang (don_hang_id, mon_an_id, so_luong, trang_thai_mon)
                                 VALUES ('$don_hang_id', '$product_id', '$so_luong', '$trang_thai_mon')";
            
                if (!$conn->query($sql_chi_tiet)) {
                    throw new Exception("Lỗi khi thêm chi tiết đơn hàng: " . $conn->error);
                }
                
                // Sau khi thêm vào chi_tiet_don_hang, xóa món khỏi bảng giohang
                $sql_xoa_giohang = "DELETE FROM giohang WHERE product_id = '$product_id'"; // Sử dụng giohang_id để xóa đúng mục trong giỏ hàng
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






<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Giỏ hàng</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Giỏ hàng <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-cart">
    
<form action="cartt.php" method="POST" id="checkoutForm">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th><input type="checkbox" id="selectAll"> Chọn tất cả</th>
                                <th></th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $subtotal = 0;
                                if ($result_cart && $result_cart->num_rows > 0) {
                                    while ($row = $result_cart->fetch_assoc()) {
                                        $total_price = $row['soluong'] * $row['gia_mon'];
                                        $subtotal += $total_price;
                            ?>
                                <tr class="text-center">
                                    <td class="select-product">
                                        <input type="checkbox" class="item-check" name="selected_items[]" value="<?php echo $row['id']; ?>" data-price="<?php echo $total_price; ?>" data-cartid="<?php echo $row['id'];?>" data-product_id="<?php echo $row['product_id'] ?>">
                                    </td>
                                    <td>
                                        <img style="width: 100px;" src="images/food/<?php echo $row['images'] ?>" alt="">
                                    </td>
                                    <td class="product-name">
                                        <h3><?php echo $row['name_mon'] ?></h3>
                                    </td>
                                    <td class="price"><?php echo number_format($row['gia_mon'], 0, ',', '.') . " VNĐ" ?></td>
                                    <td class="quantity">
                                        <input type="number" class="form-control quantity-input" name="quantities[<?php echo $row['id']; ?>]" data-cartid="<?php echo $row['id'] ?>" value="<?php echo $row['soluong'] ?>" min="1" max="50">
                                    </td>
                                    <td class="total">
                                        <?php echo number_format($total_price, 0, ',', '.') . " VNĐ"; ?>
                                    </td>
                                    <td class="product-remove">
                                        <a onclick="return confirm('Bạn có muốn xóa sản phẩm khỏi giỏ hàng không?')" href="?delid=<?php echo $row['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Giỏ hàng của bạn trống.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Thanh toán -->
    <div class="row justify-content-end">
        <div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
            <div class="cart-total mb-3">
                <h3>Thanh toán</h3>
                <p class="d-flex">
                    <span>Tổng:</span>
                    <span id="tongTien">0 VNĐ</span>
                </p>
                <p class="d-flex">
                    <span>Discount</span>
                    <span>:
                        <select id="discountSelect" class="form-control" name="discount_id">
                            <option value="0">Chọn mã giảm giá</option>
                            <?php
                            if ($result_discounts && $result_discounts->num_rows > 0) {
                                while ($row = $result_discounts->fetch_assoc()) {
                                    $hienThiGiatri = $row['loai'] === 'phantram'
                                        ? $row['giatri'] . '%'
                                        : number_format($row['giatri'], 0, ',', '.') . ' VNĐ';

                                    echo "<option value='{$row['id']}' 
                                                 data-giatri='{$row['giatri']}' 
                                                 data-loai='{$row['loai']}'
                                                 data-dontt='{$row['don_toi_thieu']}'>"
                                         . "{$row['ten']} - Giảm {$hienThiGiatri}</option>";
                                }
                            }
                            ?>
                        </select>
                    </span>
                </p>
                <span>Bàn đã đặt:</span>
                <span>
                    <select class="form-control" name="ban_id" required>
                        <option value="0">Chọn bàn đã đặt trước</option>
                        <?php if (!empty($ds_ban)) {
                            foreach ($ds_ban as $ban) {
                                echo '<option value="' . htmlspecialchars($ban['id']) . '">' . htmlspecialchars($ban['ten']) . '</option>';
                            }
                        } else {
                            echo '<option>Không có bàn nào</option>';
                        } ?>
                    </select>
                </span>

                <hr>
                <p class="d-flex total-price">
                    <span>Tổng thanh toán:</span>
                    <span id="tongTien2">0 VNĐ</span>
                </p>
            </div>

            <p class="text-center">
                <button type="submit" class="btn btn-primary py-3 px-4">Thanh toán</button>
            </p>
        </div>
    </div>

    <!-- Các trường ẩn cho tổng số tiền và các dữ liệu khác -->
    <input type="hidden" name="tong" id="tongInput">
    <input type="hidden" name="tong_tien" id="tongTienInput">
    <input type="hidden" name="gio_hang" id="gioHangInput">
    
    <input type="hidden" name="total_amount" value="<?php echo $subtotal; ?>">
</form>

        </div>
    </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function tinhTong() {
        let tong = 0;

        // Tính tổng tiền được chọn
        $('.item-check:checked').each(function () {
            tong += $(this).data('price');
        });

        $('#tongTien').text(" " + tong.toLocaleString() + " VNĐ");

        // Ẩn/hiện option không đủ điều kiện
        $('#discountSelect option').each(function () {
            let minAmount = parseInt($(this).data('dontt')) || 0;
            if (tong >= minAmount || $(this).val() == 0) {
                $(this).show(); // đủ điều kiện
            } else {
                $(this).hide(); // không đủ điều kiện => ẩn
            }
        });

        // Nếu chọn mã hợp lệ thì tính giảm giá
        let selected = $('#discountSelect option:selected');
        let giatri = parseInt(selected.data('giatri')) || 0;
        let loai = selected.data('loai');
        let minAmount = parseInt(selected.data('dontt')) || 0;

        let finalAmount = tong;

        if (tong >= minAmount && $('#discountSelect').val() !== "0") {
            if (loai === 'phantram') {
                finalAmount = tong - (tong * giatri / 100);
            } else if (loai === 'tienmat') {
                finalAmount = tong - giatri;
            }
        }

        // Không cho giá âm
        if (finalAmount < 0) finalAmount = 0;

        $('#tongTien2').text(" " + finalAmount.toLocaleString() + " VNĐ");
    }

    // Trigger tính lại khi có sự kiện
    $('.item-check').on('change', tinhTong);
    $('#selectAll').on('change', function () {
        $('.item-check').prop('checked', this.checked);
        tinhTong();
    });
    $('#discountSelect').on('change', tinhTong);

    // Gọi ngay để cập nhật nếu có dữ liệu sẵn
    tinhTong();
});

// Khi số lượng thay đổi
$('.quantity-input').on('change', function () {
    const cartId = $(this).data('cartid');
    const quantity = $(this).val();

    $.ajax({
        url: 'update_quantity.php',
        method: 'POST',
        data: {
            cartid: cartId,
            quantity: quantity
        },
        success: function (response) {
            if (response.status === 'success') {
                location.reload(); // Reload lại trang để cập nhật giỏ hàng
            } else {
                alert('Cập nhật thất bại: ' + response.message);
            }
        },
        error: function () {
            alert('Lỗi kết nối máy chủ.');
        }
    });
});


document.getElementById("checkoutForm").addEventListener("submit", function(e) {
    const selectedItems = [];
    document.querySelectorAll(".item-check:checked").forEach(checkbox => {
        const cartId = checkbox.getAttribute("data-cartid");  // GiohangId
        const productId = checkbox.getAttribute("data-product_id");  // Product ID mới
        const giohangId = checkbox.getAttribute("data-giohangid"); // Lấy giohangId chính xác
        const quantityInput = document.querySelector(`.quantity-input[data-cartid="${cartId}"]`);
        const quantity = quantityInput ? quantityInput.value : 1;

        selectedItems.push({
            product_id: productId,  // Thêm product_id vào mảng dữ liệu
            quantity: parseInt(quantity),
            giohang_id: giohangId,  // Thêm giohang_id vào dữ liệu gửi về
        });
    });

    // Lưu giỏ hàng vào trường ẩn
    document.getElementById("gioHangInput").value = JSON.stringify(selectedItems);

    // Tính tổng tiền và lưu vào trường ẩn
    const tongTien = document.getElementById("tongTien").textContent.replace(' VNĐ', '').replace(',', '');
    const finalAmount = document.getElementById("tongTien2").textContent.replace(/[^\d]/g, '');

    document.getElementById("tongTienInput").value = finalAmount ;
    document.getElementById("tongInput").value = tongTien;
});



document.querySelectorAll('.item-check').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const cartId = this.getAttribute('data-cartid');
        const price = this.getAttribute('data-price');
        const productId = this.getAttribute('data-product_id'); // <-- lấy thêm thuộc tính mới

        console.log('Cart ID:', cartId);
        console.log('Price:', price);
        console.log('Product ID (from attribute):', productId);

        // Nếu bạn đã có productId từ data-attribute thì không cần fetch nữa
        // nhưng nếu bạn vẫn muốn kiểm tra chính xác từ server thì giữ lại đoạn fetch
    });
});


document.getElementById("orderForm").addEventListener("submit", function(e) {
    const selectedItems = [];
    document.querySelectorAll(".item-check:checked").forEach(checkbox => {
        const cartId = checkbox.getAttribute("data-cartid"); // Lấy cartId
        const price = checkbox.getAttribute("data-price");  // Lấy giá
        const productId = checkbox.getAttribute("data-product_id");  // Lấy thêm thuộc tính mới data-product_id
        const quantityInput = document.querySelector(`.quantity-input[data-cartid="${cartId}"]`);
        const quantity = quantityInput ? quantityInput.value : 1;

        selectedItems.push({
            product_id: productId,  // Sử dụng product_id thay vì cartId
            quantity: parseInt(quantity),
            price: parseFloat(price)
        });
    });

    // Gán JSON vào hidden input
    document.getElementById("gio_hang_input").value = JSON.stringify(selectedItems);
});



</script>

<?php
include 'inc/footer.php';
?>
