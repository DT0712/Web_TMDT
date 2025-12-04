<?php
session_start();
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $mat_khau = $_POST['mat_khau'];

    if (empty($email) || empty($mat_khau)) {
        $error = 'Vui lòng nhập đầy đủ thông tin';
    } else {
        $sql = "SELECT * FROM khach_hang WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (password_verify($mat_khau, $user['mat_khau'])) {
                $_SESSION['khach_hang'] = [
                    'id_khach_hang' => $user['id_khach_hang'],
                    'ho_ten' => $user['ho_ten'],
                    'email' => $user['email'],
                    'dien_thoai' => $user['dien_thoai']
                ];
                // Quay lại trang trước đó (nếu có)
                $return = $_GET['return'] ?? 'index.php';
                header("Location: $return");
                exit;
            } else {
                $error = 'Mật khẩu không đúng';
            }
        } else {
            $error = 'Email không tồn tại';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .login-card {
            max-width: 420px;
            margin: 50px auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .login-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body { padding: 40px 30px; background: white; }
        .btn-login {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 50px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(40,167,69,0.4); }
    </style>
</head>
<body>
<div class="container">
    <div class="login-card">
        <div class="login-header">
            <h3><i class="fas fa-shopping-bag me-2"></i> SHOP CỦA BẠN</h3>
            <p class="mb-0">Đăng nhập để tiếp tục mua sắm</p>
        </div>

        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" 
                           placeholder="nhập email của bạn" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="mat_khau" class="form-control form-control-lg" 
                           placeholder="nhập mật khẩu" required>
                </div>

                <button type="submit" class="btn btn-success btn-login w-100">
                    ĐĂNG NHẬP
                </button>
            </form>

            <div class="text-center mt-4">
                <p>Chưa có tài khoản? 
                    <a href="register.php" class="text-success fw-bold text-decoration-none">Đăng ký ngay</a>
                </p>
                <a href="forgot.php" class="text-muted small">Quên mật khẩu?</a>
            </div>

            <div class="text-center mt-3">
                <a href="index.php" class="btn btn-outline-secondary btn-sm">
                    ← Quay lại mua sắm
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>