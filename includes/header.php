<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blank Label</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/Css/style.css">
    <link rel="stylesheet" href="assets/Css/header.css">
    <link rel="stylesheet" href="assets/Css/pages.css">
    <link rel="stylesheet" href="assets/Css/footer.css">

    <style>
        /* 1. Cố định thanh trắng trên cùng */
        .top-header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 50px !important;
            z-index: 9999 !important;
            background: #fff !important;
            border-bottom: 1px solid #eee !important;
        }

        /* 2. Cố định thanh menu đen ngay bên dưới */
        .main-nav {
            position: fixed !important;
            top: 50px !important; /* Nằm ngay dưới thanh trắng */
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 48px !important;
            z-index: 9998 !important;
            background: #222 !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
        }

        /* 3. Cố định Mega Menu khi xổ xuống */
        .mega-menu-container {
            position: fixed !important;
            top: 98px !important; /* 50px + 48px */
            left: 0 !important;
            width: 100% !important;
            z-index: 9997 !important;
        }

        /* 4. Đẩy nội dung web xuống để không bị Header che khuất */
        body {
            padding-top: 100px !important; /* Khoảng trống dành cho Header */
        }
    </style>
</head>
<body>
    <div class="top-header">
        <div class="container-limit d-flex justify-content-between align-items-center h-100">
            <div class="logo">Blank<span>Label</span></div>
            <div class="top-menu">
                <div><i class="bi bi-telephone"></i> 1900 6750</div>
                <form class="d-flex" action="tim_kiem.php" method="GET">
                    <input class="form-control" type="text" name="q" placeholder="Tìm kiếm...">
                </form>
                
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="profile.php"><i class="bi bi-person-check"></i> <?php echo $_SESSION['user']; ?></a>
                    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Thoát</a>
                <?php else: ?>
                    <a href="login.php"><i class="bi bi-person"></i> Đăng nhập</a>
                    <a href="register.php"><i class="bi bi-lock"></i> Đăng ký</a>
                <?php endif; ?>

                <a href="cart.php" class="text-decoration-none">
                    <div class="cart-box"><i class="bi bi-cart"></i> Giỏ hàng</div>
                </a>
            </div>
        </div>
    </div>

    <div class="main-nav">
        <div class="container-limit h-100">
            <div class="menu-items">
                <a href="index.php">TRANG CHỦ</a>
                <a href="about.php">GIỚI THIỆU</a>

                <div class="nav-item-has-child">
                    <a href="san_pham.php">SẢN PHẨM <i class="bi bi-caret-down-fill" style="font-size: 10px;"></i></a>
                    
                    <div class="mega-menu-container">
                        <div class="mega-inner">
                            <?php
                            // Kiểm tra biến kết nối $conn
                            if(isset($conn)) {
                                // 1. Lấy danh mục cha (Cấp 1)
                                $sql_parent = "SELECT * FROM danh_muc WHERE id_cha IS NULL ORDER BY id ASC";
                                $result_parent = $conn->query($sql_parent);

                                if ($result_parent && $result_parent->num_rows > 0) {
                                    while ($parent = $result_parent->fetch_assoc()) {
                                        echo '<div class="mega-column">';
                                        
                                        // Tiêu đề cột
                                        echo '<h4><a href="danh_muc.php?id=' . $parent['id'] . '">' . htmlspecialchars($parent['ten_danh_muc']) . '</a></h4>';

                                        // 2. Lấy danh mục con
                                        $sql_child = "SELECT * FROM danh_muc WHERE id_cha = " . intval($parent['id']) . " ORDER BY id ASC";
                                        $result_child = $conn->query($sql_child);

                                        if ($result_child && $result_child->num_rows > 0) {
                                            echo '<ul>';
                                            while ($child = $result_child->fetch_assoc()) {
                                                echo '<li><a href="danh_muc.php?id=' . $child['id'] . '">' . htmlspecialchars($child['ten_danh_muc']) . '</a></li>';
                                            }
                                            echo '</ul>';
                                        }
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <a href="news.php">TIN TỨC</a>
                <a href="contact.php">LIÊN HỆ</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>