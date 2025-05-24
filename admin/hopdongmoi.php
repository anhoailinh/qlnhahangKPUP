<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php' ?>
<?php include '../classes/mon.php' ?>
<?php include '../classes/cart.php' ?>
<?php include_once '../helpers/format.php' ?>
 <?php $fm = new Format();
 $hopdong = new cart();
 
 
	 
 ?> 
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Mã hợp đồng</th>
					<th>Tên khách hàng</th>
					<th>Giờ</th>
					<th>Ngày</th>
					<th>Nội dung</th>
                    <th>Số lượng khách </th>
                    <th>Tiền cọc </th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
				</tr>
			</thead>
			<tbody>
			<?php
				
				$listhopdong = $hopdong->show_hopdong();
				if($listhopdong){
					$i=0;
					while($result=$listhopdong->fetch_assoc()){ 
						$i++;
			?>
				<tr class="odd gradeX">
					<td><?php echo $result['sesis']?></td>
					<td><?php echo $result['ten']?></td>
					<td><?php echo $result['tg']?></td>
					<td><?php echo $result['dates']?></td>
					<td><?php echo $fm->textShorten($result['noidung'],50) ?></td>
                    <td><?php echo $result['so_user']?></td>
                    <td><?php echo $fm->formatMoney($result['Sum(thanhtien)'])?></td>
				
					<td><?php
					if($result['tinhtrang']==1){
						echo "Đã duyệt";
					}
					else{
						echo "Chưa duyệt";
					}
					?>
					</td>
					<td><a href="hopdongdit.php?id_mon=<?php echo $result['sesis']?>">Chi tiết</a> ||<!--<a onclick="return confirm('bạn muốn xóa ?')" href="?delid=<?php echo $result['id_mon']?>">Delete</a>--></td>
				</tr>
				<?php
				}}
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
