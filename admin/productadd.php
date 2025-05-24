<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php' ?>
<?php include '../classes/mon.php' ?>
<?php
$monan = new mon();
	if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit'])){

		$insermonan = $monan->insert_mon($_POST,$_FILES) ;
	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm món ăn</h2>
        <div class="block">   
                
         <form action="productadd.php" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Tên món</label>
                    </td>
                    <td>
                        <input type="text" name="name_mon" placeholder="Enter Name..." class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Loại món</label>
                    </td>
                    <td>
                        <select id="select" name="loaimon">
                            <option>-----Chọn loại món-----</option>
                            <?php
                                $loaimon= new loaimon();
                                $listmon = $loaimon->show_loai();
                                if($listmon){
                                    while($result = $listmon->fetch_assoc()){

                                    
                                
                                ?>
                            <option value="<?php echo $result['id_loai']?>"><?php echo $result['name_loai']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
				<!-- <tr>
                    <td>
                        <label>Brand</label>
                    </td>
                    <td>
                        <select id="select" name="select">
                            <option>Select Brand</option>
                            <option value="1">Brand One</option>
                            <option value="2">Brand Two</option>
                            <option value="3">Brand Three</option>
                        </select>
                    </td>
                </tr> -->
                <tr>
                    <td>
                        <label>Giá</label>
                    </td>
                    <td>
                        <input type="text" name="gia" placeholder="Enter Price..." class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Ghi chú</label>
                    </td>
                    <td>
                        <textarea name="ghichu" class="tinymce"></textarea>
                    </td>
                </tr>
			
            
                <tr>
                    <td>
                        <label>Tải hình </label>
                    </td>
                    <td>
                        <input type="file" name="image" />
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <label>Trạng thái </label>
                    </td>
                    <td>
                        <select id="select" name="tinhtrang">
                            <option>----chọn trạng thái-----</option>
                            <option value="1">Phục vụ </option>
                            <option value="0">Ngưng phục vụ</option>
                        </select>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Save" /> <?php
                if(isset($insermonan)){
                    echo $insermonan;
                }
                ?>    
                    </td>
                </tr>
            </table>
            </form>
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


