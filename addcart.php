<?php
session_start();
include 'connect.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['customer_login']) || $_SESSION['customer_login'] !== true) {
    echo "<script>alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.'); window.location.href = 'login.php';</script>";
    exit;
}



$user_id = (int)$_SESSION['customer_id'];  // Lấy user_id từ session

// Lấy thông tin sản phẩm từ form
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Lấy giá của sản phẩm
    $sql = "SELECT gia_mon FROM monan WHERE id_mon = $product_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $price_at_time = $product['gia_mon'];

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $check_cart = "SELECT * FROM giohang WHERE user_id = $user_id AND product_id = $product_id";
        $check_result = $conn->query($check_cart);

        if ($check_result && $check_result->num_rows > 0) {
            // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
            $update_cart = "UPDATE giohang SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
            if ($conn->query($update_cart)) {
                echo "<script>
                        alert('Cập nhật giỏ hàng thành công.');
                        window.location.href = 'cartt.php';
                      </script>";
            } else {
                echo "<p>Đã có lỗi xảy ra khi cập nhật giỏ hàng.</p>";
            }
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $added_at = date("Y-m-d H:i:s");
            $insert_cart = "INSERT INTO giohang (user_id, product_id, quantity, price_at_time, added_at) 
                            VALUES ($user_id, $product_id, $quantity, $price_at_time, '$added_at')";
            if ($conn->query($insert_cart)) {
                echo "<script>
                        alert('Thêm sản phẩm vào giỏ hàng thành công.');
                        window.location.href = 'cartt.php';
                      </script>";
            } else {
                echo "<p>Đã có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.</p>";
            }
        }
    } else {
        echo "<p>Sản phẩm không tồn tại.</p>";
    }
} else {
    echo "<p>Vui lòng chọn sản phẩm và số lượng.</p>";
}

echo "<p><a href='cartt.php'>Xem giỏ hàng</a></p>";
echo "<p><a href='menu.php'>Quay lại thực đơn</a></p>";
?>
