<?php
session_start();
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten = trim($_POST['ho_ten']);
    $email = trim($_POST['email']);
    $dien_thoai = trim($_POST['dien_thoai']);
    $mat_khau = $_POST['mat_khau'];
    $nhap_lai = $_POST['nhap_lai'];

    if ($mat_khau !== $nhap_lai) {
        $error = 'Mật khẩu nhập lại không khớp';
    } elseif (strlen($mat_khau) < 6) {
        $error = 'Mật khẩu phải ít nhất 6 ký tự';
    } else {
        // Kiểm tra email đã tồn tại chưa
        $check = $conn->prepare("SELECT id_khach_hang FROM khach_hang WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Email này đã được đăng ký';
        } else {
            $hash = password_hash($mat_khau, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO khach_hang (ho_ten, email, dien_thoai, mat_khau) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $ho_ten, $email, $dien_thoai, $hash);
            if ($stmt->execute()) {
                $success = 'Đăng ký thành công! Đang chuyển đến trang đăng nhập...';
                header("Refresh: 2; url=login.php");
            } else {
                $error = 'Có lỗi xảy ra, vui lòng thử lại';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .register-card { max-width: 480px; margin: 40px auto; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .card-header { background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 25px; text-align: center; }
        .card-body { padding: 40px 35px; background: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="card register-card">
        <div class="card-header">
            <h3>Tạo tài khoản mới</h3>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và tên</label>
                    <input type="text" name="ho_ten" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Số điện thoại</label>
                    <input type="text" name="dien_thoai" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="mat_khau" class="form-control form-control-lg" required minlength="6">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Nhập lại mật khẩu</label>
                    <input type="password" name="nhap_lai" class="form-control form-control-lg" required>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-pill">
                    ĐĂNG KÝ NGAY
                </button>
            </form>

            <div class="text-center mt-4">
                <p>Đã có tài khoản? <a href="login.php" class="text-success fw-bold">Đăng nhập</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>