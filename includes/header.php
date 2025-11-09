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
    <div class="top-header">
        <div class="container-limit d-flex justify-content-between align-items-center">
            <div class="logo">Blank<span>Label</span></div>
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

    <div class="main-nav">
        <div class="container-limit">
            <div class="menu-items">
                <a href="index.php">TRANG CHỦ</a>
                <a href="about.php">GIỚI THIỆU</a>

                <?php
                // Kết nối CSDL trước
                // include 'db_connect.php';
                $queryCha = "SELECT * FROM danh_muc WHERE id_cha IS NULL";
                $resultCha = mysqli_query($conn, $queryCha);

                if (mysqli_num_rows($resultCha) > 0) {
                    // tạo trigger với id="megaToggle" để JS dễ lấy
                    echo '<div class="dropdown mega-menu" id="megaMenu">';
                    echo '<a id="megaToggle" class="dropdown-toggle text-white text-decoration-none" href="#">SẢN PHẨM</a>';

                    // container dropdown: phần trái là .mega-dropdown (các cột), phần phải là overlay (che nội dung)
                    echo '<div class="dropdown-menu">';
                    echo '<div class="mega-dropdown">';

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

                    echo '</div>'; // .mega-dropdown
                    echo '<div class="mega-overlay"></div>'; // overlay che phải
                    echo '</div>'; // .dropdown-menu
                    echo '</div>'; // .dropdown .mega-menu
                }
                ?>

                <a href="contact.php">LIÊN HỆ</a>
            </div>
        </div>
    </div>

    <script>
        // filepath: c:\xampp\htdocs\Web_TMDT\includes\header.php (inline script)
        (function(){
            const megaMenu = document.getElementById('megaMenu');
            const toggle = document.getElementById('megaToggle');
            const dropdown = megaMenu ? megaMenu.querySelector('.dropdown-menu') : null;
            let hideTimer = null;

            function showMenu() {
                if (hideTimer) { clearTimeout(hideTimer); hideTimer = null; }
                megaMenu.classList.add('show');
            }
            function hideMenuDelayed() {
                if (hideTimer) clearTimeout(hideTimer);
                hideTimer = setTimeout(()=> {
                    megaMenu.classList.remove('show');
                }, 120); // nhỏ để tránh flicker khi di chuyển giữa trigger và box
            }

            if (toggle && dropdown && megaMenu) {
                // show khi vào trigger
                toggle.addEventListener('mouseenter', showMenu);
                toggle.addEventListener('focus', showMenu);
                toggle.addEventListener('mouseleave', hideMenuDelayed);

                // giữ khi hover dropdown, ẩn khi rời dropdown
                dropdown.addEventListener('mouseenter', showMenu);
                dropdown.addEventListener('mouseleave', hideMenuDelayed);

                // hỗ trợ keyboard: hide on Esc
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') megaMenu.classList.remove('show');
                });
            }
        })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
