<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/connect.php'; ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm tin tức mới</h2>
        <div class="block"> 

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tieude = mysqli_real_escape_string($conn, $_POST['tieude']);
                $mota = mysqli_real_escape_string($conn, $_POST['mota']);
                $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);

                // Xử lý ảnh
                $imgName = $_FILES['img']['name'];
                $imgTmp = $_FILES['img']['tmp_name'];
                $uploadDir = "../images/blog/";
                $uploadPath = $uploadDir . basename($imgName);

                if (move_uploaded_file($imgTmp, $uploadPath)) {
                    $sql = "INSERT INTO blog (tieude, mota, noidung, img) 
                            VALUES ('$tieude', '$mota', '$noidung', '$imgName')";
                    
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>
                                alert('Thêm tin tức thành công!');
                                window.location.href = 'bloglist.php';
                              </script>";
                    
                    } else {
                        echo "<span class='error'>Thêm thất bại: " . mysqli_error($conn) . "</span>";
                    }
                } else {
                    echo "<span class='error'>Tải ảnh lên thất bại!</span>";
                }
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="form">					
                    <tr>
                        <td>
                            <label>Tiêu đề</label>
                        </td>
                        <td>
                            <input type="text" name="tieude" placeholder="Nhập tiêu đề..." class="medium" required />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Mô tả</label>
                        </td>
                        <td>
                            <textarea name="mota" rows="4" cols="60" required></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Nội dung</label>
                        </td>
                        <td>
                            <textarea name="noidung" rows="8" cols="80" required></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Ảnh</label>
                        </td>
                        <td>
                            <!-- Image Preview Section -->
                            <div id="imagePreviewContainer">
                                <img id="imagePreview" src="" alt="Image Preview" style="width: 100px; height: auto; display: none;"/>
                            </div>
                            <input type="file" name="img" accept="image/*" required id="imageInput" />
                        </td>
                    </tr>

                    <tr> 
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Lưu" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

<script>
// JavaScript to show the image preview when a file is selected
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';  // Show the image preview
        };
        reader.readAsDataURL(file);
    }
});
</script>
