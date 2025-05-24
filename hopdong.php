<?php
include 'inc/header.php';
Session::checkSession();

?>
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
 
	$time = $_POST['timebook'];
	$date=$_POST['datebook'];
	$khach=$_POST['khach'];
	$noidung=$_POST['noidung'];
	$insert_order = $ct->insert_order($userid,$time,$date,$khach,$noidung);
   $del_cart = $ct->del_all_cart();
   header('location: success.php');
  }
  $date = getdate();
  $userid= session_id();
  $get_cart = $ct->show_thongtinid($userid);
  $result=$get_cart->fetch_assoc();


?>
<style>
h1,
h2,
h3,
h4,
h5,
h6 {
    text-align: center;
    padding: 10 10 10 10;
}

label {
    font-weight: bold;   
    position: relative;
}

table {
    width: 50rem !important;


}
.text{
    padding-left: 10rem;
}
.text1{
    color: red;

}
</style>


<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Book a Table</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Reservation <i
                            class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>
<h1><label> Nhà Hàng GS</h1>

<h2><label>HỢP ĐỒNG NHẬN TIỆC</h2>

<h5>Ngày <?php echo $date['mday'] ?> Tháng <?php echo $date['mon'] ?> Năm <?php echo $date['year'] ?></h5>


<h4><label>Đại diên nhà hàng: </label> ……Nguyễn Văn A……<label> Chức vụ:</label> … Quản Lý……<label>ĐT:</label> ………033974654………. </h4>
<h4><label>Người đặt tiệc:</label> ………………<label class="text1"> <?php echo session::get('name') ?></label>……………SĐT:………………<label class="text1"> <?php echo session::get('sdt') ?></label>……… </h4>
<h4><label>Nội dung tiệc:</label> ………<label class="text1"><?php echo $result['noidung'] ?></label>………………………………..Số lượng khách: .……<label class="text1"><?php echo $result['so_user'] ?></label>.......</h4>
<h4><label>khu vực tiệc: </label> ……………<label>Sảnh</label>……Loại bàn (tròn hoặc dài):
    ………<label>bàn.dài</label>... </h4>
<h4><label>thời gian tiệc:</label>…<label class="text1"><?php echo $result['tg'] ?> Ngày: <?php echo $result['dates'] ?></label> </h4>
<hr>

<h2><label>THỰC ĐƠN TIỆC </label></h2>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                           
                           
                                <th>Món ăn</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <?php
					
                    $userid= session_id();
                    $get_cart = $ct->show_thongtinid($userid);
                        $subtotal=0;
                        while($result=$get_cart->fetch_assoc()){
                            
                            
                    ?>

                        <tbody>
                            <tr class="text-center">
                       
                                <td class="product-name">
                                    <h3><?php echo $result['name_mon'] ?></h3>
                                </td>

                                <td class="price"><?php echo $fm->formatMoney($result['gia'])."VNĐ" ?></td>

                                    
                                 
                                        
                                    <td class="product-name">
                                    <h3><?php echo $result['soluong'] ?></h3>
                                </td>
                                      
                                  
                                    </div>
                                </td>

                                <td class="total">
                                    <?php
									$total = $result['soluong']* $result['gia'];
									echo $fm->formatMoney($total)."VNĐ";
									$subtotal += $total;
								
									?>
                                </td>
                            </tr><!-- END TR-->
                            <tr></tr>
                        </tbody>
                        <?php		
									
						}
							
                            ?>
                         
                    </table>
                    <h4><label>Tổng: <?php echo $fm->formatMoney( $subtotal) ?> VNĐ</label> </h4>

                </div>
            </div>
        </div>
    </div>
</section>


<h2><lable>(ĐƠN GIÁ CHƯA BAO GỒM 10% VAT)</lable></h2>
<h4><label>Các loại khác :</label> </h4>
<h4>Background: ……………Kích thước: ……………Nội dụng: …………………………….. </h4>
<h4>Karaoke: …………………………Dàn nhạc: ………………………………………………</h4>
<h4>Sân khấu: …………………………Phí trang trí: …………………………………………...</h4>
<h4>Phí phòng lạnh: ………………………………………trên tổng bill thanh toán.</h4>
<h4>Khuyến mãi: ………………………………………………………………………………... </h4>

<h4><label>(ĐƠN GIÁ CHƯA BAO GỒM 10% VAT)</label></h4>

<h3><label>Hai bên cùng đồng ý:</label></h3>

<label class="text">1.Trong thời gian đặt cọc, nêu bên Quý Khách đơn phương hủy tiệc vì bắt cứ lí do gì hoặc không đến đúng thời gian và
ngảy đặt tiệc thì coi như Quý Khách đã hủy tiệc. Bên nhà hàng sẽ không hoàn trả số tiền đã đặt cọc.</label>

<lable class="text">2. Trong thời gian đặt cọc, nêu có thay đổi về món ăn và thức uống Quý Khách phải liên hệ nhà hàng trước 48h đề nhà hàng
kịp thời chuẩn bị.</lable>
<hr>

<h1><a href="success.php"  class="btn btn-primary py-3 px-5"> Xác Nhận </a></h1>

</section>
<?php
  include 'inc/footer.php';
  ?>