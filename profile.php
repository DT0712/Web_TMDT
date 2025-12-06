<?php
// Bắt buộc session và config
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php'; // Kết nối DB

// Kiểm tra đăng nhập
if (!isset($_SESSION['khach_hang'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['khach_hang'];
$id_kh = $user['id_khach_hang'];

// Giả định DOB và address (từ DB nếu có, hoặc placeholder)
$dob = '01/01/1990'; // Placeholder, lấy từ DB nếu có
$address = [
    'country' => 'Việt Nam',
    'city' => 'Hà Nội',
    'street' => '123 Đường ABC',
    'postal' => '10000'
]; // Placeholder

// Xử lý update mật khẩu (giữ nguyên)
$password_success = '';
$password_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'change_password') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $password_error = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif ($new_password !== $confirm_password) {
        $password_error = 'Mật khẩu mới và xác nhận không khớp.';
    } elseif (strlen($new_password) < 6) {
        $password_error = 'Mật khẩu mới phải ít nhất 6 ký tự.';
    } else {
        $sql_old = "SELECT mat_khau FROM khach_hang WHERE id_khach_hang = ?";
        $stmt_old = $conn->prepare($sql_old);
        $stmt_old->bind_param("i", $id_kh);
        $stmt_old->execute();
        $old_result = $stmt_old->get_result();
        
        if ($old_row = $old_result->fetch_assoc()) {
            if (password_verify($old_password, $old_row['mat_khau'])) {
                $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update = "UPDATE khach_hang SET mat_khau = ? WHERE id_khach_hang = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $hashed_new, $id_kh);
                
                if ($stmt_update->execute()) {
                    $password_success = 'Cập nhật mật khẩu thành công!';
                } else {
                    $password_error = 'Lỗi cập nhật. Vui lòng thử lại.';
                }
            } else {
                $password_error = 'Mật khẩu cũ không đúng.';
            }
        }
    }
}

// Lấy đơn hàng gần đây (giữ nguyên)
$sql_orders = "SELECT dh.*, SUM(ctdh.so_luong * ctdh.don_gia) as tong_tien 
               FROM don_hang dh 
               JOIN chi_tiet_don_hang ctdh ON dh.id_don_hang = ctdh.id_don_hang 
               WHERE dh.id_khach_hang = ? 
               GROUP BY dh.id_don_hang 
               ORDER BY dh.ngay_dat DESC 
               LIMIT 5";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $id_kh);
$stmt_orders->execute();
$orders = $stmt_orders->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản của tôi - Blank Label</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/Css/style.css">

    <style>
        :root {
            --primary: #00bcd4;
            --secondary: #0097a7;
            --light: #f8f9fa;
            --dark: #495057;
            --border: #dee2e6;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: var(--dark);
        }
        .profile-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 3rem 0;
            position: relative;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid white;
            margin: 0 auto 1rem;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary);
        }
        .user-name {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .user-location {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .section-header {
            background: var(--light);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
        }
        .info-grid {
            padding: 1.5rem;
        }
        .info-row {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 500;
            color: var(--dark);
            min-width: 120px;
            flex: 0 0 120px;
        }
        .info-value {
            flex: 1;
            color: #6c757d;
        }
        .edit-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            transition: background 0.2s ease;
        }
        .edit-btn:hover {
            background: var(--secondary);
        }
        .nav-link {
            color: var(--dark);
            padding: 0.875rem 1rem;
            border-radius: 0;
            transition: background 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: var(--primary);
            color: white;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }
        @media (max-width: 768px) {
            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .info-label {
                min-width: auto;
                margin-bottom: 0.25rem;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container my-3">
    <div class="row">
        <div class="col-md-3">
            <div class="profile-card">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#profile" onclick="switchTab('profile')">
                            <i class="bi bi-person me-2"></i>Tài khoản
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#orders" onclick="switchTab('orders')">
                            <i class="bi bi-bag me-2"></i>Đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#settings" onclick="switchTab('settings')">
                            <i class="bi bi-gear me-2"></i>Cài đặt
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Profile Header -->
            <div class="profile-card mb-4">
                <div class="profile-header text-center p-4">
                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="user-name mb-1"><?= htmlspecialchars($user['ho_ten']) ?></h2>
                    <p class="user-location mb-0">Khách hàng thân thiết</p>
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="profile" class="tab-content active">
                <!-- Personal Information -->
                <div class="profile-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-badge me-2"></i>Thông tin cá nhân</span>
                        <button class="edit-btn" onclick="editPersonal()">Chỉnh sửa</button>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Họ và tên</span>
                            <span class="info-value"><?= htmlspecialchars($user['ho_ten']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value"><?= htmlspecialchars($user['email']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ngày sinh</span>
                            <span class="info-value"><?= $dob ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Số điện thoại</span>
                            <span class="info-value"><?= htmlspecialchars($user['dien_thoai'] ?? 'Chưa cập nhật') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="profile-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</span>
                        <button class="edit-btn" onclick="editAddress()">Chỉnh sửa</button>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Quốc gia</span>
                            <span class="info-value"><?= $address['country'] ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Thành phố</span>
                            <span class="info-value"><?= $address['city'] ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Địa chỉ</span>
                            <span class="info-value"><?= $address['street'] ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mã bưu điện</span>
                            <span class="info-value"><?= $address['postal'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Tab -->
            <div id="orders" class="tab-content">
                <div class="profile-card">
                    <div class="section-header">
                        <i class="bi bi-receipt me-2"></i>Đơn hàng gần đây
                    </div>
                    <div class="info-grid">
                        <?php if (mysqli_num_rows($orders) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($order = $orders->fetch_assoc()): ?>
                                            <tr class="order-item">
                                                <td>#<?= $order['id_don_hang'] ?></td>
                                                <td><?= date('d/m/Y', strtotime($order['ngay_dat'])) ?></td>
                                                <td><?= number_format($order['tong_tien']) ?>₫</td>
                                                <td>
                                                    <span class="badge status-badge 
                                                        <?php echo $order['trang_thai'] == 'hoan_thanh' ? 'bg-success' : 
                                                             ($order['trang_thai'] == 'dang_giao' ? 'bg-warning' : 'bg-secondary'); ?>">
                                                        <?= ucfirst(str_replace('_', ' ', $order['trang_thai'])) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-bag-x"></i>
                                <h6>Chưa có đơn hàng</h6>
                                <a href="index.php" class="btn btn-primary mt-2">Mua sắm ngay</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Settings Tab -->
            <div id="settings" class="tab-content">
                <div class="profile-card">
                    <div class="section-header">
                        <i class="bi bi-shield-lock me-2"></i>Thay đổi mật khẩu
                    </div>
                    <div class="info-grid">
                        <?php if ($password_success): ?>
                            <div class="alert alert-success"><?= $password_success ?></div>
                        <?php endif; ?>
                        <?php if ($password_error): ?>
                            <div class="alert alert-danger"><?= $password_error ?></div>
                        <?php endif; ?>
                        <form method="POST" class="p-3">
                            <input type="hidden" name="action" value="change_password">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <input type="password" name="old_password" class="form-control" placeholder="Mật khẩu cũ" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }

    function editPersonal() {
        alert('Chỉnh sửa thông tin cá nhân');
    }

    function editAddress() {
        alert('Chỉnh sửa địa chỉ');
    }
</script>

</body>
</html>