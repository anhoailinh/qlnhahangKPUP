<?php
// Kết nối database
include 'connect.php'; // File này cần có biến $conn = new mysqli(...)


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback_submit'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $gopy  = isset($_POST['gopy']) ? trim($_POST['gopy']) : '';

    if (!empty($email) && !empty($gopy)) {
        $stmt = $conn->prepare("INSERT INTO Customercontact (email, gopy) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $gopy);

        if ($stmt->execute()) {
            echo "<script>alert('Cảm ơn bạn đã góp ý!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gửi thất bại, vui lòng thử lại.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin.');</script>";
    }

    $conn->close();
}


?>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">K-Pub - Korean Grill Pub</h2>
              <p>Địa chỉ: Tòa Nhà Quỳnh Minh, Đường Bắc Sơn, Tp. Thái Nguyên​
              </p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Giờ mở cửa</h2>
              <ul class="list-unstyled open-hours">
                <li class="d-flex"><span>Thứ 2</span><span>8:00 - 23:00</span></li>
                <li class="d-flex"><span>Thứ 3</span><span>8:00 - 23:00</span></li>
                <li class="d-flex"><span>Thứ 4 </span><span>8:00 - 23:00</span></li>
                <li class="d-flex"><span>Thứ 5 </span><span>8:00 - 23:00</span></li>
                <li class="d-flex"><span>Thứ 6 </span><span>8:00 - 23:00</span></li>
                <li class="d-flex"><span>Thứ 7 </span><span>8:00 - 23:00</span></li>
                <li class="d-flex"><span>Chủ nhật </span><span>8:00 - 23:00</span></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2"></h2>
              <div class="thumb d-sm-flex">
	            	<ul>
                  <li><a href="">Trang chủ</a></li>
                  <li><a href="">Trang chủ</a></li>
                  <li><a href="">Trang chủ</a></li>
                </ul>
	            </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Thư góp ý</h2>
            	<p>Hãy để lại ý kiến ẩn danh của bạn để chúng tôi có thể cải thiện dịch vụ tốt hơn!</p>
              <form action="index.php" method="post" class="subscribe-form">
    <div class="form-group">
        <input type="text" name="email" class="form-control mb-2 text-center" placeholder="Email" required>
        <input type="text" name="gopy" class="form-control mb-2 text-center" placeholder="Hãy để lại ý kiến...." required>
        <input type="submit" name="feedback_submit" value="Gửi" class="form-control submit px-3">
    </div>
</form>


            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

           
          </div>
        </div>
      </div>
    </footer>
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>