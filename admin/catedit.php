<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php';?>
<?php
$loai = new loaimon();
if(!isset($_GET['id_loai']) || $_GET['id_loai']==NULL){
    echo "<script>window.location = 'catlist.php'</script>";
}else{
    $id= $_GET['id_loai'];
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $tenloai = $_POST['tenloai'];
    $ghichu = $_POST['ghichu'];

    $updatetloai = $loai->update_loai($tenloai,$ghichu,$id);
}

	
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa Loại món</h2>
             
               <div class="block copyblock"> 
               <?php
                if(isset($updatetloai)){
                    echo $updatetloai;
                }
                ?>
                <?php
                $get_ten_loai = $loai->getloaibyid($id);
                if ($get_ten_loai){
                    while($result = $get_ten_loai->fetch_assoc()){

                ?>
                <div class="form-container">
    <form action="" method="post">
        <table class="form">					
            <tr>
                <td>
                    <input type="text" value="<?php echo $result['name_loai']?>" name="tenloai" placeholder="Sửa loại món" class="medium" />
                </td>
                <td>
                    <input type="text" name="ghichu" placeholder="Sửa ghi chú" class="medium" />
                </td>
            </tr>
            <tr> 
                <td>
                    <input type="submit" name="submit" value="Sửa" style="color: white; padding: 10px 30px;"/>
                </td>
                <td>
                <a href="catlist.php" class="back-btn">Quay Lại</a>
                </td>
            </tr>
            
        </table>
    </form>
</div>

                    <?php
                    }
                }
                    ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>