<?php
include 'config.php';
include 'includes/header.php';
?>

<main class="main-page-content">

<div class="container-limit">
    
    <div class="banner mb-4">
        <img src="assets/images/BG.png" class="img-fluid d-block w-100" alt="Banner">
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="category-wrapper">
                <h5 class="category-title">DANH MỤC</h5>
                <ul class="category-list">
                    <?php
                    $sql_parent = "SELECT * FROM danh_muc WHERE id_cha IS NULL ORDER BY id ASC";
                    $result_parent = $conn->query($sql_parent);

                    if ($result_parent->num_rows > 0) {
                        while ($parent = $result_parent->fetch_assoc()) {
                            echo '<li>';
                            echo '<a href="danh_muc.php?id=' . $parent['id'] . '">' . htmlspecialchars($parent['ten_danh_muc']) . '</a>';
                            
                            // Danh mục con (nếu có)
                            $sql_child = "SELECT * FROM danh_muc WHERE id_cha = " . intval($parent['id']) . " ORDER BY id ASC";
                            $result_child = $conn->query($sql_child);
                            if ($result_child->num_rows > 0) {
                                echo '<ul class="subcategory-list">';
                                while ($child = $result_child->fetch_assoc()) {
                                    echo '<li><a href="danh_muc.php?id=' . $child['id'] . '">- ' . htmlspecialchars($child['ten_danh_muc']) . '</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                    } else {
                        echo '<li><a href="#">Chưa có danh mục</a></li>';
                    }
                    ?>
                </ul>
            </div>
            
            </div>

        <div class="col-md-9">
            <h5 class="section-title text-start" style="border-bottom: 2px solid #eee; padding-bottom:10px; margin-top:0;">SẢN PHẨM MỚI</h5>
            
            <div class="row product-grid">
                <?php
                $sql_new = "SELECT * FROM san_pham ORDER BY id_san_pham DESC LIMIT 6"; // Tăng lên 6 sp cho đẹp lưới
                $result_new = $conn->query($sql_new);
                if ($result_new->num_rows > 0) {
                    while ($row = $result_new->fetch_assoc()) {
                        echo '
                        <div class="col-md-4 col-sm-6">
                            <div class="card">
                                <a href="san_pham.php?id=' . $row['id_san_pham'] . '">
                                    <img src="assets/images/' . htmlspecialchars($row['link_anh']) . '" class="card-img-top" alt="' . htmlspecialchars($row['ten_san_pham']) . '">
                                </a>
                                <div class="card-body">
                                    <h6 class="card-title">' . htmlspecialchars($row['ten_san_pham']) . '</h6>
                                    <p class="card-text">
                                        <strong>' . number_format($row['gia']) . '₫</strong>
                                    </p>
                                </div>
                                <div class="mt-auto">
                                    <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-outline-secondary" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
                                    <a href="cart.php?action=add&id=' . $row['id_san_pham'] . '" class="btn btn-primary" title="Thêm vào giỏ"><i class="bi bi-cart-plus"></i> Mua</a>
                                </div>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="banner mb-5 mt-4">
        <a href="#"><img src="assets/images/hmv.png" class="img-fluid w-100 banner-hmv" alt="Hàng mới về"></a>
    </div>

    <h5 class="section-title">SẢN PHẨM KHUYẾN MÃI</h5>
    <div class="row product-grid mb-5">
        <?php
        $sql_km = "SELECT * FROM san_pham ORDER BY RAND() LIMIT 4"; // Hiển thị 4 sản phẩm ngẫu nhiên
        $result_km = $conn->query($sql_km);
        if ($result_km->num_rows > 0) {
            while ($row = $result_km->fetch_assoc()) {
                $giam_gia = rand(10, 30);
                $gia_cu = $row['gia'] * (1 + $giam_gia / 100);
                echo '
                <div class="col-md-3 col-sm-6"> <div class="card">
                        <span class="position-absolute badge bg-success">-' . $giam_gia . '%</span>
                        <a href="san_pham.php?id=' . $row['id_san_pham'] . '">
                            <img src="assets/images/' . htmlspecialchars($row['link_anh']) . '" class="card-img-top" alt="Product">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">' . htmlspecialchars($row['ten_san_pham']) . '</h6>
                            <p class="card-text">
                                <strong>' . number_format($row['gia']) . '₫</strong>
                                <del>' . number_format($gia_cu) . '₫</del>
                            </p>
                        </div>
                        <div class="mt-auto">
                            <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-primary">XEM NGAY</a>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
    </div>

</div>
</main>

<?php include 'includes/footer.php'; ?>