<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php' ?>
<?php
$loai = new loaimon();
if(isset($_GET['delid'])){
	$id= $_GET['delid'];
	$delloai = $loai->del_loai($id);
}
	
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách loại </h2>
				<a href="catadd.php" class="btn-them">+ Thêm</a>
                <div class="block">
				<?php
                if(isset($delloai)){
                    echo $delloai;
					
                }
			
                ?>        

				
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$show_loai = $loai->show_loai();
						if($show_loai){
							$i=0;
							while($result = $show_loai->fetch_assoc()){
								$i++;						
						
					?>
						<tr class="odd gradeX">
							<td><?php echo $i ?></td>
							<td><?php echo $result['name_loai']?></td>
							<td><a href="catedit.php?id_loai=<?php echo $result['id_loai']?>">Edit</a> 
							|| <a onclick="return confirm('bạn thật sự muốn xóa không?')" href="?delid=<?php echo $result['id_loai']?>">Delete</a></td>
						</tr>
						<?php
							}
						}
						?>
					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
	$(document).ready(function () {
	    setupLeftMenu();

	    $('.datatable').dataTable();
	    setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php';?>

