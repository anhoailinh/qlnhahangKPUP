<?php
include 'inc/header.php';
include_once 'classes/mon.php';
include_once 'classes/loaimon.php';

$mon = new mon();
$loaimon = new loaimon();
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

$key = isset($_POST['key']) ? $_POST['key'] : '';
$id_loai = isset($_GET['id_loai']) ? $_GET['id_loai'] : '';

// Lấy danh sách món
if (!empty($key)) {
    $listmon = $mon->getmonkey($key);
    $totalmon = $listmon ? $listmon->num_rows : 0;
} elseif (!empty($id_loai)) {
    $listmon = $mon->getmonbyloai_limit($id_loai, $start_from, $limit);
    $totalmon = $mon->countMonByLoai($id_loai);
} else {
    $listmon = $mon->getAllMon_limit($start_from, $limit);
    $totalmon = $mon->countAllMon();
}





?>

<!-- Hero section -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center mb-4">
                <h1 class="mb-2 bread">Thực Đơn</h1>
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="index.php">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span>
                    <span>Thực đơn <i class="ion-ios-arrow-forward"></i></span>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Nội dung chính -->
<section class="ftco-section">
    <div class="container">

    <form action="menu.php" method="post" class="form-inline justify-content-center">
    <input name="key" type="search" class="form-control mr-2" placeholder="Tìm kiếm món ăn..." value="<?= htmlspecialchars($key) ?>">
    <button type="submit" name="search_submit" class="btn btn-primary">Tìm kiếm</button>
</form>



        <!-- Tabs lọc loại món -->
        <div class="row">
            <div class="col-md-12 nav-link-wrap">
                <div class="nav nav-pills d-flex text-center justify-content-center" id="v-pills-tab" role="tablist">
                    <a class="nav-link ftco-animate <?= empty($id_loai) ? 'bg-warning text-dark' : '' ?>" href="menu.php">Tất cả</a>
                    <?php
                    $show_loai = $loaimon->show_loaimenu();
                    if ($show_loai) {
                        while ($result = $show_loai->fetch_assoc()) {
                            $activeClass = ($id_loai == $result['id_loai']) ? 'bg-warning text-dark' : '';
                            echo '<a class="nav-link ftco-animate ' . $activeClass . '" href="?id_loai=' . $result['id_loai'] . '">' . $result['name_loai'] . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Danh sách món ăn -->
        <div class="row mt-4">
            <?php
            if ($listmon && $listmon->num_rows > 0) {
                while ($result_mon = $listmon->fetch_assoc()) {
            ?>
                    <div class="col-md-6 col-lg-6 d-flex align-self-stretch mb-4">
                        <div class="menus d-sm-flex ftco-animate align-items-stretch clickable-card"
                             onclick="window.location.href='detail.php?monid=<?= $result_mon['id_mon'] ?>'">
                            <div class="menu-img img" style="background-image: url(images/food/<?= $result_mon['images'] ?>);"></div>
                            <div class="text d-flex align-items-center">
                                <div>
                                    <div class="d-flex">
                                        <div class="one-half">
                                            <h3><?= $result_mon['name_mon'] ?></h3>
                                        </div>
                                        <div class="one-forth">
                                            <span class="price"><?= $fm->formatMoney($result_mon['gia_mon']) ?></span>
                                        </div>
                                    </div>
                                    <p><?= $result_mon['ghichu_mon'] ?></p>
                                    <p><a href="detail.php?monid=<?= $result_mon['id_mon'] ?>" class="btn btn-primary">Thêm vào giỏ hàng</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p>Không tìm thấy món ăn.</p></div>";
            }
            ?>
        </div>

        <!-- Phân trang -->
        <?php
        if (empty($key)) {
            $total_pages = ceil($totalmon / $limit);
            if ($total_pages > 1) {
                echo '<div class="text-center mt-4"><ul class="pagination justify-content-center">';

                // Previous
                if ($page > 1) {
                    $prev_page = $page - 1;
                    $link = !empty($id_loai) ? "?id_loai=$id_loai&page=$prev_page" : "?page=$prev_page";
                    echo "<li class='page-item'><a class='page-link' href='$link'>&laquo;</a></li>";
                }

                $range = 2;
                $start = max(1, $page - $range);
                $end = min($total_pages, $page + $range);

                if ($start > 1) {
                    $link = !empty($id_loai) ? "?id_loai=$id_loai&page=1" : "?page=1";
                    echo "<li class='page-item'><a class='page-link' href='$link'>1</a></li>";
                    if ($start > 2) echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                }

                for ($i = $start; $i <= $end; $i++) {
                    $link = !empty($id_loai) ? "?id_loai=$id_loai&page=$i" : "?page=$i";
                    $active = $i == $page ? "active" : "";
                    echo "<li class='page-item $active'><a class='page-link' href='$link'>$i</a></li>";
                }

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1) echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                    $link = !empty($id_loai) ? "?id_loai=$id_loai&page=$total_pages" : "?page=$total_pages";
                    echo "<li class='page-item'><a class='page-link' href='$link'>$total_pages</a></li>";
                }

                // Next
                if ($page < $total_pages) {
                    $next_page = $page + 1;
                    $link = !empty($id_loai) ? "?id_loai=$id_loai&page=$next_page" : "?page=$next_page";
                    echo "<li class='page-item'><a class='page-link' href='$link'>&raquo;</a></li>";
                }

                echo '</ul></div>';
            }
        }
        ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
