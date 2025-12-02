<?php
// BẬT BÁO LỖI ĐỂ DEBUT (Xóa dòng này khi web đã chạy ngon)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/header.php'; 
?>

<?php
// 1. Kiểm tra ID trên URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger m-4'>Lỗi: Không tìm thấy ID sản phẩm trên đường dẫn! <a href='products.php'>Quay lại</a></div>";
    include 'includes/footer.php';
    exit();
}

$id = intval($_GET['id']);

// 2. Lấy thông tin sản phẩm (Sử dụng 'id' hoặc 'id_san_pham' tùy DB của bạn)
// Mặc định code cũ dùng 'id_san_pham', nếu DB bạn là 'id' thì sửa dòng dưới thành 'id'
$col_id = 'id_san_pham'; // <--- SỬA THÀNH 'id' NẾU DB CỦA BẠN DÙNG 'id'

$sql = "SELECT * FROM san_pham WHERE $col_id = $id";
$result = $conn->query($sql);

if (!$result) {
    // Nếu SQL lỗi (sai tên bảng/cột), hiện lỗi ra màn hình
    die("<div class='alert alert-danger m-4'>Lỗi SQL: " . $conn->error . "</div>");
}

$product = $result->fetch_assoc();

if (!$product) {
    echo "<div class='alert alert-warning m-4'>Không tìm thấy sản phẩm có ID = $id</div>";
    include 'includes/footer.php';
    exit();
}

// 3. XỬ LÝ KHI BẤM NÚT CẬP NHẬT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_sp = $_POST['ten_san_pham'];
    $gia = $_POST['gia'];
    $danh_muc = $_POST['id_danh_muc'];
    $mo_ta = $_POST['mo_ta'];
    $img_name = $product['link_anh']; // Giữ ảnh cũ

    // Nếu có chọn ảnh mới
    if (!empty($_FILES["hinh_anh"]["name"])) {
        $target_dir = "../assets/images/";
        $new_img_name = basename($_FILES["hinh_anh"]["name"]);
        $target_file = $target_dir . $new_img_name;
        if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
            $img_name = $new_img_name;
        } else {
            echo "<script>alert('Lỗi: Không thể tải ảnh lên!');</script>";
        }
    }

    // Câu lệnh Update
    $sql_update = "UPDATE san_pham SET
                ten_san_pham = '$ten_sp',
                gia = '$gia',
                id_danh_muc = '$danh_muc',
                mo_ta = '$mo_ta',
                link_anh = '$img_name'
                WHERE $col_id = $id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
                alert('Cập nhật thành công!');
                window.location.href='products.php';
            </script>";
    } else {
        echo "<div class='alert alert-danger'>Lỗi cập nhật: " . $conn->error . "</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 my-4">
            <div class="card-header bg-white">
                <h5 class="m-0 font-weight-bold text-warning">Sửa Sản Phẩm: #<?php echo $id; ?></h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="ten_san_pham" class="form-control" value="<?php echo htmlspecialchars($product['ten_san_pham']); ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá (VNĐ)</label>
                            <input type="number" name="gia" class="form-control" value="<?php echo $product['gia']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Danh mục</label>
                            <select name="id_danh_muc" class="form-select">
                                <?php
                                $cat_res = $conn->query("SELECT * FROM danh_muc");
                                if($cat_res) {
                                    while($c = $cat_res->fetch_assoc()){
                                        // Kiểm tra xem danh mục hiện tại có khớp không
                                        // Lưu ý: DB bạn có thể dùng 'id' hoặc 'id_danh_muc' cho bảng danh mục
                                        $cat_id = isset($c['id']) ? $c['id'] : $c['id_danh_muc']; 
                                        $selected = ($cat_id == $product['id_danh_muc']) ? 'selected' : '';
                                        echo "<option value='".$cat_id."' $selected>".$c['ten_danh_muc']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại</label><br>
                        <?php if(!empty($product['link_anh'])): ?>
                            <img src="../assets/images/<?php echo $product['link_anh']; ?>" width="100" class="rounded border mb-2">
                        <?php else: ?>
                            <p class="text-muted">Chưa có ảnh</p>
                        <?php endif; ?>
                        <input type="file" name="hinh_anh" class="form-control">
                        <small class="text-muted">Bỏ qua nếu không muốn thay đổi ảnh.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="mo_ta" class="form-control" rows="4"><?php echo isset($product['mo_ta']) ? htmlspecialchars($product['mo_ta']) : ''; ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning text-white">Cập nhật ngay</button>
                        <a href="products.php" class="btn btn-light">Hủy bỏ</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>