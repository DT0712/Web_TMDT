<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Blank Label</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/Css/style.css">
    <link rel="stylesheet" href="assets/Css/header.css">
    <link rel="stylesheet" href="assets/Css/pages.css">
</head>
<body>

<!-- Thanh trên -->
<div class="top-header">
    <div class="container-limit d-flex justify-content-between align-items-center">
        <div class="logo py-2">Blank<span>Label</span></div>
        <div class="top-menu">
            <div><i class="bi bi-telephone"></i> 1900 6750</div>
            <form class="d-flex">
                <input class="form-control" type="text" placeholder="Tìm kiếm...">
            </form>
            <a href="login.php"><i class="bi bi-person"></i> Đăng nhập</a>
            <a href="register.php"><i class="bi bi-lock"></i> Đăng ký</a>
            <div class="cart-box"><i class="bi bi-cart"></i> Giỏ hàng</div>
        </div>
    </div>
</div>

<!-- Menu chính -->
<div class="main-nav">
    <div class="container-limit">
        <a href="index.php" class="home-link">TRANG CHỦ</a>
        <div class="menu-items">
            <a href="about.php">GIỚI THIỆU</a>

            <?php
            // Kết nối CSDL trước
            // include 'db_connect.php';
            $queryCha = "SELECT * FROM danh_muc WHERE id_cha IS NULL";
            $resultCha = mysqli_query($conn, $queryCha);

            if (mysqli_num_rows($resultCha) > 0) {
                echo '<div class="dropdown mega-menu" id="megaMenu">';
                echo '<a class="dropdown-toggle text-white text-decoration-none" href="#">SẢN PHẨM</a>';
                echo '<div class="dropdown-menu mega-dropdown">';

                while ($cha = mysqli_fetch_assoc($resultCha)) {
                    echo '<div class="mega-column">';
                    echo '<h6>' . $cha['ten_danh_muc'] . '</h6>';

                    $queryCon = "SELECT * FROM danh_muc WHERE id_cha = " . $cha['id'];
                    $resultCon = mysqli_query($conn, $queryCon);
                    if (mysqli_num_rows($resultCon) > 0) {
                        echo '<ul class="list-unstyled">';
                        while ($con = mysqli_fetch_assoc($resultCon)) {
                            echo '<li><a href="sanpham.php?danhmuc=' . $con['id'] . '">' . $con['ten_danh_muc'] . '</a></li>';
                        }
                        echo '</ul>';
                    }
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            }
            ?>

            <a href="contact.php">LIÊN HỆ</a>
        </div>
    </div>
</div>

<script>
    const megaMenu = document.getElementById('megaMenu');
    if (megaMenu) {
        megaMenu.addEventListener('mouseenter', () => {
            megaMenu.classList.add('show');
        });

        megaMenu.addEventListener('mouseleave', () => {
            megaMenu.classList.remove('show');
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
