<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/loaimon.php' ?>
<?php include '../classes/mon.php' ?>
<?php include_once '../helpers/format.php' ?>

<?php 
    $fm = new Format();
    $monan = new mon();
    
    if(isset($_GET['delid'])){
        $id = $_GET['delid'];
        $delmon = $monan->del_mon($id);
    }
?> 

<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách món</h2>
        <a href="productadd.php" class="btn-them">+ Thêm</a>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Loại</th>
                        <th>Giá</th>
                        <th>Ghi chú</th>
                        <th>Hình ảnh</th>
                        <th>Trạng thái</th>
                        <th>Món nổi bật</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $listmon = $monan->show_mon();
                        if($listmon){
                            $i = 0;
                            while($result = $listmon->fetch_assoc()){ 
                                $i++;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['name_mon']; ?></td>
                        <td><?php echo $result['name_loai']; ?></td>
                        <td><?php echo $result['gia_mon']; ?></td>
                        <td><?php echo $fm->textShorten($result['ghichu_mon'], 10); ?></td>
                        <td class="center">
                            <img height="150" width="150" src="../images/food/<?php echo $result['images']; ?>">
                        </td>
                        <td>
                            <?php echo ($result['tinhtrang'] == 1) ? "Phục vụ" : "Ngưng phục vụ"; ?>
                        </td>
                        <td>
                            <?php echo $result['special'] ; ?>
                        </td>
                        <td>
                            <a href="productdit.php?id_mon=<?php echo $result['id_mon']; ?>">Edit</a> || 
                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa món này không?');" 
                               href="?delid=<?php echo $result['id_mon']; ?>">Delete</a>
                        </td>
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
