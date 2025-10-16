<?php
include 'config.php';
include 'includes/header.php';
?>

<div class="container-limit mt-0">
    <!-- Banner -->
    <div class="banner mb-4">
        <img src="assets/images/BG.png" class="img-fluid mx-auto d-block w-100" alt="Banner">
    </div>

    <!-- DANH MỤC SẢN PHẨM & SẢN PHẨM MỚI -->
    <div class="row align-items-start category-product-section mb-4">
        <!-- Cột DANH MỤC -->
        <div class="col-md-3 category-column">
            <h5 class="category-title">DANH MỤC SẢN PHẨM</h5>
            <div class="category-wrapper">
                <ul class="category-list">
                    <?php
                    // Lấy danh mục cha
                    $sql_parent = "SELECT * FROM danh_muc WHERE id_cha IS NULL ORDER BY id ASC";
                    $result_parent = $conn->query($sql_parent);

                    if ($result_parent->num_rows > 0) {
                        while ($parent = $result_parent->fetch_assoc()) {
                            echo '<li class="parent-item">';
                            echo '<a href="danh_muc.php?id=' . $parent['id'] . '">' . htmlspecialchars($parent['ten_danh_muc']) . '</a>';

                            // Lấy danh mục con
                            $sql_child = "SELECT * FROM danh_muc WHERE id_cha = " . intval($parent['id']) . " ORDER BY id ASC";
                            $result_child = $conn->query($sql_child);

                            if ($result_child->num_rows > 0) {
                                echo '<ul class="subcategory-list">';
                                while ($child = $result_child->fetch_assoc()) {
                                    echo '<li><a href="danh_muc.php?id=' . $child['id'] . '">' . htmlspecialchars($child['ten_danh_muc']) . '</a></li>';
                                }
                                echo '</ul>';
                            }

                            echo '</li>';
                        }
                    } else {
                        echo '<li>Không có danh mục nào.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Cột SẢN PHẨM MỚI -->
        <div class="col-md-9 product-column">
            <h5 class="section-title">SẢN PHẨM MỚI</h5>
            <div class="row product-grid">
                <?php
                $sql_new = "SELECT * FROM san_pham ORDER BY id_san_pham DESC LIMIT 3";
                $result_new = $conn->query($sql_new);
                if ($result_new->num_rows > 0) {
                    while ($row = $result_new->fetch_assoc()) {
                        echo '
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <img src="assets/images/' . htmlspecialchars($row['link_anh']) . '" 
                                     class="card-img-top" 
                                     alt="' . htmlspecialchars($row['ten_san_pham']) . '" 
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">' . htmlspecialchars($row['ten_san_pham']) . '</h6>
                                    <p class="card-text mb-2"><strong>' . number_format($row['gia']) . ' VNĐ</strong></p>
                                    <div class="mt-auto">
                                        <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-outline-secondary btn-sm me-2">TÙY CHỌN</a>
                                        <a href="cart.php?action=add&id=' . $row['id_san_pham'] . '" class="btn btn-primary btn-sm">MUA HÀNG</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "<p>Chưa có sản phẩm mới.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Banner "Hàng mới về" -->
    <div class="banner mb-4 position-relative">
        <a href="#"><img src="assets/images/hmv.png" class="img-fluid w-100" alt="Hàng mới về" style="height: 300px; object-fit: cover;"></a>
        <div class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 2; color: white;">
         
        </div>
    </div>

    <!-- SẢN PHẨM KHUYẾN MÃI -->
    <h5 class="section-title">SẢN PHẨM KHUYẾN MÃI</h5>
    <div class="row mb-4">
        <?php
        $sql_km = "SELECT * FROM san_pham ORDER BY id_san_pham ASC LIMIT 3";
        $result_km = $conn->query($sql_km);
        if ($result_km->num_rows > 0) {
            while ($row = $result_km->fetch_assoc()) {
                $giam_gia = rand(10, 40);
                $gia_cu = $row['gia'] * (1 + $giam_gia / 100);
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm position-relative h-100">
                        <span class="position-absolute top-0 start-0 badge bg-success rounded-0">-' . $giam_gia . '%</span>
                        <img src="assets/images/' . htmlspecialchars($row['link_anh']) . '" 
                             class="card-img-top" 
                             alt="' . htmlspecialchars($row['ten_san_pham']) . '" 
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">' . htmlspecialchars($row['ten_san_pham']) . '</h6>
                            <p class="card-text mb-2">
                                <strong>' . number_format($row['gia']) . ' VNĐ</strong>
                                <del>' . number_format($gia_cu) . ' VNĐ</del>
                            </p>
                            <div class="mt-auto">
                                <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-outline-secondary btn-sm">Xem thêm sản phẩm</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo "<p>Chưa có sản phẩm khuyến mãi.</p>";
        }
        ?>
    </div>

    <div class="text-center mb-4">
        <a href="san_pham.php" class="btn btn-primary">Xem thêm sản phẩm</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
