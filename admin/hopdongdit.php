<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../classes/cart.php' ?>
<?php
$hopdong = new cart();
if(!isset($_GET['id_mon']) || $_GET['id_mon']==NULL){
    echo "<script>window.location = 'productlist.php'</script>";
}else{
    $id= $_GET['id_mon'];
}
	if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit'])){
        $tinhtrang = $_POST['tinhtrang'];
		$updatehopdong = $hopdong->update_tinhtrang($id,$tinhtrang) ;
	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Hợp đồng</h2>
        <div class="block"> 
        <?php

            $gethopdong = $hopdong->show_thongtinid($id);
            if($gethopdong){
                while($result = $gethopdong->fetch_assoc()){
            
        ?>  

                
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Mã hợp đồng <?php echo $result['tinhtrang']; ?></label>
                    </td>
                    <td>
                        <input type="text" name="id" value="<?php echo $result['sesis'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Tên khách hàng</label>
                    </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $result['ten'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Giờ</label>
                    </td>
                    <td>
                        <input type="text" name="time" value="<?php echo $result['tg'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Ngày</label>
                    </td>
                    <td>
                        <input type="text" name="date" value="<?php echo $result['dates'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Nội dung</label>
                    </td>
                    <td>
                        <input type="text" name="des" value="<?php echo $result['noidung'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>số lượng khách </label>
                    </td>
                    <td>
                        <input type="text" name="date" value="<?php echo $result['so_user'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <?php

            $gethopdong = $hopdong->show_thongtinid($id);
            if($gethopdong){
            while($result = $gethopdong->fetch_assoc()){

            ?>  
                <tr>
                    <td>
                        <label>Món ăn  </label>
                    </td>
                    <td>
                        <input type="text" name="date" value="<?php echo $result['name_mon'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                    <td>
                        <input type="text" name="soluong" value="<?php echo $result['soluong'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                    <td>
                        <input type="text" name="gia" value="<?php echo $result['thanhtien'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                        
                    </td>
                </tr>
                <?php
            }
        }
            ?>
			
                <tr>
                    <td>
                        <label>Tiền cọc</label>
                    </td>
                    <td>
                    <input type="text" name="gia" value="<?php echo $result['Sum(thanhtien)'] ?>" class="medium"  onclick="return confirm('Không đươc đổi tên ?')"/>
                    </td>
                </tr>
				

              
                <tr>
                    <td>
                        <label>Trạng thái </label>
                    </td>
                    <td> <?php  $a = isset($result['tinhtrang'])?$result['tinhtrang']: 0;?>
                        <select id="select" name="tinhtrang">
                            <option>----chọn trạng thái-----</option>
                            <?php if($a==1){?>
                                  <option selected value="1">Đã duyệt </option>
                                  <option   value="0">Chưa duyệt</option>
                            <?php }
                            else {?>

                            <option  value="1">Đã duyệt </option>
                            <option selected value="0">Chưa duyệt</option>
                            <?php }?>
                        </select>
                    </td>
                </tr>
				<!-- <tr>
                    <td>
                        <label>Product Type</label>
                    </td>
                    <td>
                        <select id="select" name="select">
                            <option>Select Type</option>
                            <option value="1">Featured</option>
                            <option value="2">Non-Featured</option>
                        </select>
                    </td>
                </tr> -->

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" value="update" /> <?php
                if(isset($updatehopdong)){
                    echo $updatehopdong;
                }
                ?>    
                    </td>
                </tr>
            </table>
            </form>
            <?php
            }
        }
            ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


