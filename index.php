<?php include 'config.php'; include 'includes/header.php'; ?>

<div class="container-limit mt-0">  <!-- Đổi thành container-limit để align với logo/header, mt-0 để sát main-nav -->
    <!-- Banner khuyến mãi gốc -->
    <div class="banner mb-4">
        <img src="assets/images/BG.png" class="img-fluid mx-auto d-block w-100">  <!-- Giữ nguyên banner gốc -->
    </div>

    <!-- Phần danh mục sidebar + Sản phẩm mới -->
    <div class="row mb-4">
        <!-- Sidebar danh mục trái (col-3) -->
        <div class="col-md-3">
            <h5 class="mb-3 category-title">DANH MỤC SẢN PHẨM</h5>
            <div class="category-wrapper">
                <ul class="category-list">
                    <?php
                    // Lấy hết tất cả danh mục, không phân biệt cha/con
                    $sql_dm = "SELECT * FROM danh_muc ORDER BY id ASC";  // Sắp xếp theo id để theo thứ tự
                    $result_dm = $conn->query($sql_dm);
                    $first = true; // Để highlight item đầu tiên
                    while ($dm = $result_dm->fetch_assoc()) {
                        $active_class = $first ? ' active' : '';
                        echo '<li class="' . $active_class . '"><a href="danh_muc.php?id=' . $dm['id'] . '">' . $dm['ten_danh_muc'] . '</a></li>';
                        $first = false;
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Sản phẩm mới bên phải (col-9) -->
        <div class="col-md-9">
            <h5 class="mb-3">SẢN PHẨM MỚI</h5>
            <div class="row">
                <?php
                $sql_new = "SELECT * FROM san_pham ORDER BY id_san_pham DESC LIMIT 3";  // Lấy 3 sản phẩm mới nhất
                $result_new = $conn->query($sql_new);
                while ($row = $result_new->fetch_assoc()) {
                    $giam_gia = rand(5, 20); // Giả định % giảm giá ngẫu nhiên
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="assets/images/' . $row['link_anh'] . '" class="card-img-top" alt="' . $row['ten_san_pham'] . '" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">' . $row['ten_san_pham'] . '</h6>
                                <p class="card-text mb-2"><strong>' . number_format($row['gia']) . ' VNĐ</strong></p>
                                <div class="mt-auto">
                                    <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-outline-secondary btn-sm me-2">TÙY CHỌN</a>
                                    <a href="cart.php?action=add&id=' . $row['id_san_pham'] . '" class="btn btn-primary btn-sm">MUA HÀNG</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Banner quảng cáo "Hàng mới về" -->
    <div class="banner mb-4 position-relative">
        <a href="#"><img src="assets/images/hang-moi-ve.jpg" class="img-fluid w-100" alt="Hàng mới về" style="height: 300px; object-fit: cover;"></a>  <!-- Thay bằng hình ảnh thực tế -->
        <div class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 2; color: white;">
            <h3 class="fw-bold">HÀNG MỚI VỀ</h3>
        </div>
    </div>

    <!-- Sản phẩm khuyến mãi -->
    <h5 class="mb-3">SẢN PHẨM KHUYẾN MÃI</h5>
    <div class="row mb-4">
        <?php
        $sql_khuyen_mai = "SELECT * FROM san_pham ORDER BY id_san_pham ASC LIMIT 3";  // Lấy 3 sản phẩm (giả sử khuyến mãi)
        $result_khuyen_mai = $conn->query($sql_khuyen_mai);
        while ($row = $result_khuyen_mai->fetch_assoc()) {
            $giam_gia = rand(10, 40); // Giả định % giảm giá
            $gia_cu = $row['gia'] * (1 + $giam_gia / 100);
            echo '
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm position-relative h-100">
                    <span class="position-absolute top-0 start-0 badge bg-success rounded-0">-' . $giam_gia . '%</span>
                    <img src="assets/images/' . $row['link_anh'] . '" class="card-img-top" alt="' . $row['ten_san_pham'] . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">' . $row['ten_san_pham'] . '</h6>
                        <p class="card-text mb-2"><strong>' . number_format($row['gia']) . ' VNĐ</strong> <del>' . number_format($gia_cu) . ' VNĐ</del></p>
                        <div class="mt-auto">
                            <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-outline-secondary btn-sm">Xem thêm sản phẩm</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Xem thêm sản phẩm -->
    <div class="text-center mb-4">
        <a href="san_pham.php" class="btn btn-primary">Xem thêm sản phẩm</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>