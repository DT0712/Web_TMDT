<?php include 'config.php'; include 'includes/header.php'; ?>

<div class="container mt-4">
    <!-- Banner khuyến mãi -->
    <div class="banner mb-4">
        <img src="assets/images/AN.jpg" class="img-fluid" >    
    </div>

    <!-- Danh mục sản phẩm -->
    <h2>Danh mục sản phẩm</h2>
    <div class="row mb-4">
        <div class="col-3">
            <ul class="list-group">
                <?php
                $sql_dm = "SELECT * FROM danh_muc WHERE id_cha IS NULL";
                $result_dm = $conn->query($sql_dm);
                while ($dm = $result_dm->fetch_assoc()) {
                    echo '<li class="list-group-item"><a href="danh_muc.php?id=' . $dm['id'] . '">' . $dm['ten_danh_muc'] . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Sản phẩm mới -->
    <h2>Sản phẩm mới</h2>
    <div class="row mb-4">
        <?php
        $sql_new = "SELECT * FROM san_pham ORDER BY id_san_pham DESC LIMIT 3";  // Lấy 3 sản phẩm mới nhất
        $result_new = $conn->query($sql_new);
        while ($row = $result_new->fetch_assoc()) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/images/' . $row['link_anh'] . '" class="card-img-top" alt="' . $row['ten_san_pham'] . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">' . $row['ten_san_pham'] . '</h5>
                        <p class="card-text"><span class="badge bg-success">-10%</span></p> <!-- Giả định giảm giá -->
                        <p class="card-text"><strong>' . number_format($row['gia']) . ' VNĐ</strong></p>
                        <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Sản phẩm bán chạy -->
    <h2>Sản phẩm bán chạy</h2>
    <div class="row">
        <?php
        $sql_hot = "SELECT * FROM san_pham ORDER BY id_san_pham ASC LIMIT 3";  // Lấy 3 sản phẩm đầu (giả sử bán chạy)
        $result_hot = $conn->query($sql_hot);
        while ($row = $result_hot->fetch_assoc()) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/images/' . $row['link_anh'] . '" class="card-img-top" alt="' . $row['ten_san_pham'] . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">' . $row['ten_san_pham'] . '</h5>
                        <p class="card-text"><span class="badge bg-success">-15%</span></p> <!-- Giả định giảm giá -->
                        <p class="card-text"><strong>' . number_format($row['gia']) . ' VNĐ</strong></p>
                        <a href="san_pham.php?id=' . $row['id_san_pham'] . '" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>