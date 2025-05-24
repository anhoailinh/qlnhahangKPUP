<?php
include 'inc/header.php';
include('connect.php'); // Kết nối CSDL
?>
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate text-center mb-4">
            <h1 class="mb-2 bread">Tin Tức</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span> <span>Tin tức <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section bg-light">
  <div class="container">
    <div class="row">
      <?php
      $query = "SELECT * FROM blog ORDER BY id DESC";
      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          ?>
          <div class="col-md-4 ftco-animate">
            <div class="blog-entry">
              <a href="blog-single.php?id=<?php echo $row['id']; ?>" class="block-20" style="background-image: url('images/blog/<?php echo $row['img']; ?>');">
              </a>
              <div class="text pt-3 pb-4 px-4">
                
                <h3 class="heading"><a href="blog-single.php?id=<?php echo $row['id']; ?>"><?php echo $row['tieude']; ?></a></h3>
                <p><?php echo mb_strimwidth($row['mota'], 0, 100, '...'); ?></p>
                <p class="clearfix">
                  <a href="blog-single.php?id=<?php echo $row['id']; ?>" style=" color: #4646ff;">Xem thêm >></a>
                  
                </p>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        echo "<p>Chưa có tin tức nào!</p>";
      }
      ?>
    </div>
  </div>
</section>

    <?php
  include 'inc/footer.php';
  ?>