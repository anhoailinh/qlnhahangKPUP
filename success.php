<?php
include 'inc/header.php';
Session::checkSession();


?>
<?php
if(isset($_GET['idorder']) && $_GET['idorder']=='order'){
	$userid= session::get('id');

}
if($_SERVER['REQUEST_METHOD']==='POST'){
 
	$time = $_POST['timebook'];
	$date=$_POST['datebook'];
	$khach=$_POST['khach'];
	$noidung=$_POST['noidung'];
	$insert_order = $ct->insert_order($userid,$time,$date,$khach,$noidung);
   $del_cart = $ct->del_all_cart();
   header('location: success.php');
  }


?>

    
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center mb-4">
            <h1 class="mb-2 bread">Book a Table</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Reservation <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section ftco-no-pt ftco-no-pb">
			<div class="container-fluid px-0">
				<div class="row">
                <h1><img height="300" width="300" src="images/success.png"> </h1>
                <div><h2> Request for reservation has been sent.</h2>
                <hr>
                <h3> Please transfer the deposit to your account: </h3>
                <hr>
                <h4> Ngân hàng    : BIDV </h4>
                <h4>STK           : 821999</h4>
                <h4>Chủ tài khoản : DANG NHU VU</h4>
             </div>
			</div>
		</section>
		<?php
  include 'inc/footer.php';
  ?>