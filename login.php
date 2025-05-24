<?php
include 'inc/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sdt = $_POST['sdt'];
  $pass = $_POST['pass']; // Giữ nguyên mật khẩu người dùng nhập
  $login_check = $us->login_user($sdt, $pass); // Truyền mật khẩu gốc vào để kiểm tra với password_verify()
}

?>
    
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center mb-4">
            <h1 class="mb-2 bread">Đăng nhập</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Đăng nhập  <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
			<div class="container">
				<div class="row d-flex align-items-stretch no-gutters">
					<div class="col-md-6 pt-5 px-2 pb-2 p-md-5 order-md-last">
            <h2 class="h4 mb-2 mb-md-5 font-weight-bold">Đăng nhập</h2>
            <span  > <?php 
				    if(isset($login_check))
				        {
				    	echo $login_check ;
				        }
			?></span>
						<form action="login.php" method="post">
              <div class="form-group">
                <input type="text" name=sdt class="form-control" placeholder="Số điện thoại">
              </div>
              <div class="form-group">
                <input type="password" name=pass class="form-control" placeholder="Mật khẩu">
              </div>
            
              <div class="form-group">
                <input type="submit" value="Đăng nhập" class="btn btn-primary py-3 px-5">
                <hr>
                <button style="border: none;"><a href="dangky.php" style="    border: none;  color: blue; text-decoration: underline;">Đăng kí</a></button>
              </div>
            </form>
					</div>
			
				</div>
			</div>
		</section>
	
    <?php
  include 'inc/footer.php';
  ?>