<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include 'inc/connect.php'; ?>
<?php include_once '../helpers/format.php' ?>



<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách món</h2>
        <a href="blogadd.php" class="btn-them">+ Thêm</a>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                <tr>
    <th style="width: 5%;">STT</th>
    <th style="width: 20%;">Tiêu đề</th>
    <th style="width: 20%;">Mô tả</th>
    <th style="width: 30%;">Nội dung</th>
    <th style="width: 15%;">Hình ảnh</th>
    <th style="width: 10%;">Hành động</th>
</tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM blog ORDER BY id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $i = 0;
                        while($row = $result->fetch_assoc()) {
                            $i++;
                           
                            echo "<tr class='gradeX odd'>";
                            echo "<td>" .$i . "</td>";
                            echo "<td>" . htmlspecialchars($row['tieude']) . "</td>";
                            // echo "<td>" . htmlspecialchars($row['mota']) . "</td>";
                            echo "<td>".substr($row['mota'], 0, 100)."...</td>";
                            echo "<td>".substr($row['noidung'], 0, 100)."...</td>";
                            echo "<td class='center'><img src='../images/blog/" . htmlspecialchars($row['img']) . "'     width='100px'></td>";
                            echo "<td>
                                    <a href='blogedit.php?id=" . $row['id'] . "'>Sửa</a> | 
                                    <a onclick=\"return confirm('Bạn có chắc muốn xoá?')\" href='blogdelete.php?id=" . $row['id'] . "'>Xoá</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
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
