<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shop Shoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Thanh trên cùng -->
    <div class="bg-white border-bottom py-2">
        <div class="container d-flex justify-content-end align-items-center">
            <!-- Số điện thoại -->
            <a href="tel:19006750" class="text-dark me-4">
                <i class="bi bi-telephone"></i> 1900 6750
            </a>

            <!-- Tìm kiếm -->
            <form class="d-flex me-4" role="search">
                <input class="form-control form-control-sm" type="search" placeholder="Tìm kiếm..." aria-label="Search">
            </form>

            <!-- Tài khoản -->
            <a href="dang_nhap.php" class="text-dark me-3"><i class="bi bi-person"></i> Đăng nhập</a>
            <a href="dang_ky.php" class="text-dark me-3"><i class="bi bi-person-plus"></i> Đăng ký</a>

            <!-- Giỏ hàng -->
            <a href="gio_hang.php" class="text-dark position-relative">
                <i class="bi bi-cart"></i> Giỏ hàng
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark">
                    0
                </span>
            </a>
        </div>
    </div>

    <!-- Menu chính -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="index.php">TRANG CHỦ</a></li>
                <li class="nav-item"><a class="nav-link" href="gioi_thieu.php">GIỚI THIỆU</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">SẢN PHẨM</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Giày Nam</a></li>
                        <li><a class="dropdown-item" href="#">Giày Nữ</a></li>
                        <li><a class="dropdown-item" href="#">Phụ kiện</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="lien_he.php">LIÊN HỆ</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
