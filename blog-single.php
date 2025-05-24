<?php
include 'inc/header.php';
include('connect.php'); // Kết nối CSDL

// Lấy id từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM blog WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $tieude = $row['tieude'];
    $mota = $row['mota'];
    $noidung = $row['noidung'];
    $img = $row['img'];
} else {
    echo "Không tìm thấy bài viết.";
    exit;
}
?>

    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container" >
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center mb-4">
            <h1 class="mb-2 bread">Tin tức</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="blog.php">Tin tức <i class="ion-ios-arrow-forward"></i></a></span> <span>Blog Single<i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section">
			<div class="container">
				<div class="row" style="margin: 21px 160px;">
        <div class=" ftco-animate">
  <h2 style="
    text-align: center;
" class="mb-3"><?php echo $tieude; ?></h2>
  <p><strong><?php echo $mota; ?></strong></p>
  <p style="
    text-align: center;
">
    <img src="images/blog/<?php echo $img; ?>" alt="" class="img-fluid">
  </p>
  <p><?php echo nl2br($noidung); ?></p>
</div>


          
        </div>
			</div>
		</section>
    <?php
  include 'inc/footer.php';
  ?>