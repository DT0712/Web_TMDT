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

        .top-menu i { margin-right: 6px; }

        .top-menu > *:not(:first-child)::before {
            content: "";
            position: absolute;
            left: 0; top: 0;
            height: 100%;
            border-left: 1px solid #ccc;
        }

        .top-menu form { flex: 1; }
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
            position: relative;
            transition: all 0.3s ease;
        }

        .cart-box:hover {
            background: #0097a7;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            font-size: 11px;
            font-weight: bold;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        /* Dropdown user khi đã login */
        .user-dropdown .dropdown-toggle {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }
        .user-dropdown .dropdown-toggle::after {
            margin-left: 8px;
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
        }
        .home-link {
            color: #fff !important;
            padding: 12px 20px 12px 0 !important;
            font-weight: 600;
            text-decoration: none;
        }
        .home-link:hover { background: #222; }

        .menu-items {
            display: flex;
            align-items: center;
            margin-left: 50px;
            gap: 40px;
        }

        .menu-items a {
            color: #fff !important;
            padding: 12px 20px;
            font-weight: 600;
            text-decoration: none;
        }

        .menu-items a:hover {
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
            min-width: 500px;
            background: #111;
            border: none;
            display: none;
            opacity: 0;
            padding: 20px;
            z-index: 9999;
            box-sizing: border-box;
            transition: opacity 0.3s ease;
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

        .mega-dropdown h6 {
            color: #00bcd4;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .mega-dropdown ul li a {
            color: #fff !important;
            padding: 4px 0;
            display: block;
        }

        .mega-dropdown ul li a:hover {
            color: #00bcd4 !important;
        }

        .container-limit {
            max-width: 1200px;
            margin: auto;
            padding: 0;
        }
    </style>
</head>

<body>

<!-- TOP HEADER -->
<div class="top-header">
    <div class="container-limit d-flex justify-content-between align-items-center">
        <div class="logo py-2">Blank<span>Label</span></div>

        <div class="top-menu">
            <div><i class="bi bi-telephone"></i> 1900 6750</div>

            <form class="d-flex">
                <input class="form-control" type="text" placeholder="Tìm kiếm...">
            </form>

            <!-- PHẦN ĐĂNG NHẬP / TÊN NGƯỜI DÙNG -->
            <?php
            $cart_count = 0;
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $cart_count += $item['quantity'] ?? 0;
                }
            }

            if (isset($_SESSION['khach_hang'])): 
                $ten_kh = $_SESSION['khach_hang']['ho_ten'] ?? 'Khách hàng';
            ?>
                <div class="user-dropdown dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?= htmlspecialchars($ten_kh) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="orders.php"><i class="bi bi-bag-check me-2"></i>Đơn hàng của tôi</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="login.php"><i class="bi bi-person"></i> Đăng nhập</a>
                <a href="register.php"><i class="bi bi-lock"></i> Đăng ký</a>
            <?php endif; ?>

            <!-- GIỎ HÀNG -->
            <a href="cart.php" class="cart-box">
                <i class="bi bi-cart"></i> Giỏ hàng
                <?php if ($cart_count > 0): ?>
                    <span class="cart-badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</div>

<!-- MAIN MENU -->
<div class="main-nav">
    <div class="container-limit">
        <a href="index.php" class="home-link">TRANG CHỦ</a>

        <div class="menu-items">
            <a href="about.php">GIỚI THIỆU</a>

            <?php
            // Lấy danh mục cha
            $queryCha = "SELECT * FROM danh_muc WHERE id_cha IS NULL ORDER BY ten_danh_muc";
            $resultCha = mysqli_query($conn, $queryCha);

            if (mysqli_num_rows($resultCha) > 0):
            ?>
            <div class="dropdown mega-menu" id="megaMenu">
                <a href="#" class="dropdown-toggle text-white">SẢN PHẨM</a>

                <div class="dropdown-menu mega-dropdown">
                    <?php while ($cha = mysqli_fetch_assoc($resultCha)) : ?>
                        <div class="mega-column">
                            <h6><?= htmlspecialchars($cha['ten_danh_muc']) ?></h6>
                            <?php
                            $queryCon = "SELECT * FROM danh_muc WHERE id_cha = " . intval($cha['id']);
                            $resultCon = mysqli_query($conn, $queryCon);
                            ?>
                            <ul class="list-unstyled">
                                <?php while ($con = mysqli_fetch_assoc($resultCon)) : ?>
                                    <li>
                                        <a href="sanpham.php?danhmuc=<?= $con['id'] ?>">
                                            <?= htmlspecialchars($con['ten_danh_muc']) ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>

            <a href="contact.php">LIÊN HỆ</a>
            <?php if (isset($_SESSION['khach_hang'])): ?>
                <a href="thongke.php" class="text-white fw-bold">
                   <i class="bi bi-graph-up me-2"></i>BẢNG THỐNG KÊ
                </a>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<script>
    const megaMenu = document.getElementById('megaMenu');
    if (megaMenu) {
        megaMenu.addEventListener('mouseenter', () => megaMenu.classList.add('show'));
        megaMenu.addEventListener('mouseleave', () => megaMenu.classList.remove('show'));
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>