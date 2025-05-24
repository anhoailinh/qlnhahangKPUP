<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php' ?>
<?php include '../classes/mon.php' ?>
<?php
$monan = new mon();
if(!isset($_GET['id_mon']) || $_GET['id_mon']==NULL){
    echo "<script>window.location = 'productlist.php'</script>";
}else{
    $id= $_GET['id_mon'];
}
	if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit'])){

		$updatemonan = $monan->update_mon($_POST,$_FILES,$id) ;
	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa món ăn</h2>
        <div class="block"> 
        <?php

            $getmonbyid = $monan->getmonbyid($id);
            if($getmonbyid){
                while($result_mon = $getmonbyid->fetch_assoc()){
            
        ?>  

                
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
            <tr>
    <td>
        <label>Tên món</label>
    </td>
    <td>
        <input type="text" name="name_mon" value="<?php echo $result_mon['name_mon'] ?>" class="medium"/>
    </td>
</tr>
<tr>
<tr>
    <td>
        <label>Loại món</label>
    </td>
    <td>
        <select id="select" name="id_loai">
            <option>-----Chọn loại món-----</option>
            <?php
                $loaimon= new loaimon();
                $listmon = $loaimon->show_loai();
                if($listmon){
                    while($result = $listmon->fetch_assoc()){
            ?>
            <option
             <?php
              if($result['id_loai']==$result_mon['id_loai']){echo 'selected' ;  }
            ?>
             value="<?php echo $result['id_loai']?>"><?php echo $result['name_loai']?></option>
            <?php
                    }
                }
            ?>
        </select>
    </td>
</tr>

<tr>
    <td>
        <label>Trạng thái </label>
    </td>
    <td>
        <select id="select" name="tinhtrang">
            <option>----chọn trạng thái-----</option>
            <?php if($result_mon['tinhtrang']==1){?>
                <option selected value="1">Phục vụ </option>
                <option value="0">Ngưng phục vụ</option>
            <?php } else { ?>
                <option value="1">Phục vụ </option>
                <option selected value="0">Ngưng phục vụ</option>
            <?php } ?>
        </select>
    </td>
</tr>


		
                <tr>
                    <td>
                        <label>Giá</label>
                    </td>
                    <td>
                        <input type="text" name="gia" value="<?php echo $result_mon['gia_mon'] ?>" class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Ghi chú</label>
                    </td>
                    <td>
                        <textarea name="ghichu"  class="tinymce" ><?php echo $result_mon['ghichu_mon']?> </textarea>
                    </td>
                </tr>
			
            
                <tr>
                    <td>
                        <label>Tải hình </label>
                    </td>
                    <td>
                    <img height="150" width ="150" src="../images/food/<?php echo $result_mon['images'] ?>"><br>
                        <input type="file" name="image" />
                    </td>
                </tr>
                <tr>
    <td>
        <label>Đặc biệt</label>
    </td>
    <td>
        <select name="special">
            <option value="0" <?php if($result_mon['special'] == 0) echo 'selected'; ?>>Không</option>
            <option value="1" <?php if($result_mon['special'] == 1) echo 'selected'; ?>>Có</option>
        </select>
    </td>
</tr>


              
          
                    <td></td>
                    <td>
                    <input type="submit" name="submit" value="update" /> 
<?php
    if (isset($updatemonan)) {
        echo $updatemonan;
        if (strpos($updatemonan, 'thành công') !== false) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href='productlist.php';</script>";
        }
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


