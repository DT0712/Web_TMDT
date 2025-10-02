<?php
// Bắt đầu session nếu chưa (cho giỏ hàng động)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breshka Shoes</title>
    <link rel="stylesheet" href="assets/css/header.css"> <!-- Link CSS riêng -->
</head>
<body>

<header class="site-header">
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo.png    " alt="Breshka Shoes" width="150">
            </a>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="main-nav">
            <ul class="nav-menu">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="products.php">Sản phẩm</a></li>
                <li class="dropdown">
                    <a href="category.php">Danh mục</a>
                    <ul class="dropdown-menu">
                        <li><a href="category.php?cat=nam">Giày nam</a></li>
                        <li><a href="category.php?cat=nu">Giày nữ</a></li>
                        <li><a href="category.php?cat=sale">Sale</a></li>
                    </ul>
                </li>
                <li><a href="about.php">Giới thiệu</a></li>
            </ul>
        </nav>
        
        <!-- Search Bar -->
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="search" name="q" placeholder="Tìm kiếm sản phẩm..." required>
                <button type="submit">Tìm</button>
            </form>
        </div>
        
        <!-- Cart & User -->
        <div class="user-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php">Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <a href="logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Đăng ký</a>
            <?php endif; ?>
            
            <a href="cart.php" class="cart-icon">
                <img src="assets/images/cart.png" alt="Giỏ hàng" width="20">
                Giỏ hàng (<?php echo $_SESSION['cart_count'] ?? 0; ?>)
            </a>
        </div>
    </div>
</header>