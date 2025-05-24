<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php';?>
<?php
$loai = new loaimon();
	if($_SERVER['REQUEST_METHOD']==='POST'){
		$tenloai = $_POST['tenloai'];
		$ghichu = $_POST['ghichu'];

		$insertloai = $loai->insert_loai($tenloai,$ghichu) ;
	}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm Loại món</h2>
             
               <div class="block copyblock"> 
               <?php
                if(isset($insertloai)){
                    echo $insertloai;
                }
                ?>
                 <div class="form-container">
        <form action="catadd.php" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <input type="text" name="tenloai" placeholder="Thêm loại món" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="ghichu" placeholder="Thêm ghi chú" class="medium" />
                    </td>
                </tr>
                <tr> 
                    <td>
                        <input class="btnsave" type="submit" name="submit" value="Save" style="color: white; padding: 10px 30px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="catlist.php" class="back-btn">Quay Lại</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>