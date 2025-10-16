<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Blank Label</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/Css/style.css">
    <style>
        .top-header {
            background: #fff;
            border-bottom: 1px solid #eee;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #000;
        }
        .logo span {
            color: #00bcd4;
            font-family: cursive;
        }

        /* Menu trên */
        .top-menu {
            display: flex;
            align-items: stretch;
            height: 50px;
        }
        .top-menu > * {
            padding: 0 15px;
            position: relative;
            display: flex;
            align-items: center;
            color: #333;
            font-size: 14px;
            text-decoration: none;
            background: none;
            border: none;
            height: 100%;
        }

        .top-menu i {
            margin-right: 6px;
        }

        .top-menu > *:not(:first-child)::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            border-left: 1px solid #ccc;
        }

        .top-menu form {
            flex: 1;
        }
        .top-menu input {
            border: none;
            outline: none;
            box-shadow: none;
            height: 100%;
        }

        .cart-box {
            background: #00bcd4;
            color: #fff !important;
            font-weight: 600;
            padding: 0 18px;
        }

        /* Menu chính */
        .main-nav {
            background: #111;
            position: relative;
            z-index: 1000;
        }
        .main-nav .container-limit {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        .main-nav .home-link {
            color: #fff !important;
            padding: 12px 20px 12px 0 !important;
            font-weight: 600;
            text-decoration: none;
        }
        .main-nav .home-link:hover {
            background: #222;
        }
        .main-nav .menu-items {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-left: 50px;
            gap: 40px;
        }
        .main-nav .menu-items a,
        .main-nav .menu-items .dropdown {
            color: #fff !important;
            padding: 12px 20px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
        }
        .main-nav .menu-items a:hover,
        .main-nav .menu-items .dropdown:hover {
            background: #222;
        }

        /* Mega menu */
        .mega-menu {
            position: relative;
        }
        .mega-menu .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: max-content; /* phủ thanh ngang */
            background: #111;
            border: none;
            display: none;
            opacity: 0;
            padding: 20px;
            z-index: 9999;
            box-sizing: border-box;
            transition: opacity 0.5s ease;
            justify-content: flex-start;
        }
        .mega-menu.show .dropdown-menu {
            display: flex;
            opacity: 1;
        }
        .mega-dropdown .mega-column {
            min-width: 180px;
            margin-right: 40px;
        }
        .mega-dropdown .mega-column h6 {
            color: #00bcd4;
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .mega-dropdown .mega-column ul li a {
            color: #fff !important;
            text-decoration: none;
            font-size: 14px;
            display: block;
            padding: 4px 0;
        }
        .mega-dropdown .mega-column ul li a:hover {
            color: #00bcd4 !important;
            background: none;
        }


        .container-limit {
            max-width: 1200px;
            margin: auto;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>
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

    megaMenu.addEventListener('mouseenter', () => {
        megaMenu.classList.add('show');
    });

    megaMenu.addEventListener('mouseleave', () => {
        megaMenu.classList.remove('show');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
