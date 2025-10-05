<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Blank Label</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            align-items: stretch; /* để tất cả item bằng nhau */
            height: 50px; /* chiều cao cố định */
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
            height: 100%; /* tất cả item cao 100% */
        }
        /* Khoảng cách icon và text */
        .top-menu i {
            margin-right: 6px;
        }
        /* Vạch ngăn cách full chiều cao */
        .top-menu > *:not(:first-child)::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            border-left: 1px solid #ccc;
        }

        .top-menu form {
            flex: 1; /* form có thể co giãn */
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
        }
        .main-nav nav {
            display: flex;
            align-items: center;
        }
        .main-nav a {
            color: #fff !important;
            padding: 12px 20px;
            font-weight: 600;
            text-decoration: none;
        }
        .main-nav a:hover {
            background: #222;
        }

        /* Căn giữa toàn bộ */
        .container-limit {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body>

<!-- Thanh trên -->
<div class="top-header">
    <div class="container-limit d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <div class="logo py-2">
            Blank<span>Label</span>
        </div>

        <!-- Menu trên có vạch ngăn -->
        <div class="top-menu">
            <div><i class="bi bi-telephone"></i> 1900 6750</div>
            <form class="d-flex">
                <input class="form-control" type="text" placeholder="Tìm kiếm...">
            </form>
            <a href="login.php"><i class="bi bi-person"></i> Đăng nhập</a>
            <a href="register.php"><i class="bi bi-lock"></i> Đăng ký</a>
            <div class="cart-box">
                <i class="bi bi-cart"></i>  Giỏ hàng
            </div>
        </div>
    </div>
</div>

<!-- Menu chính -->
<div class="main-nav">
    <div class="container-limit">
        <nav>
            <a href="index.php">TRANG CHỦ</a>
            <a href="about.php">GIỚI THIỆU</a>
            <div class="dropdown">
                <a class="dropdown-toggle text-white text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                    SẢN PHẨM
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Giày Nam</a></li>
                    <li><a class="dropdown-item" href="#">Giày Nữ</a></li>
                    <li><a class="dropdown-item" href="#">Phụ kiện</a></li>
                </ul>
            </div>
            <a href="contact.php">LIÊN HỆ</a>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
