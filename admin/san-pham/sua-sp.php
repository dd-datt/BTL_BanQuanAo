<?php
// Khởi tạo mảng lỗi để lưu thông báo lỗi của từng trường
$error = array(
    'name' => '',
    'image' => '',
    'quantity' => '',
    'price' => '',
    'sale_price' => '',
);

// Lấy danh sách danh mục và sản phẩm từ Model
$list_categories = $CategoryModel->select_all_categories();
$list_products = $ProductModel->select_products();

// Kiểm tra xem có nhận được id sản phẩm từ query string hay không
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Lấy thông tin sản phẩm dựa theo id
    $product = $ProductModel->select_product_by_id($product_id);
    extract($product);
} else {
    // Nếu không có id, chuyển hướng về danh sách sản phẩm
    header("Location: index.php?quanli=danh-sach-san-pham");
}

// Xử lý khi gửi biểu mẫu cập nhật sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_product"])) {
    $name = trim($_POST["name"]); // Lấy và làm sạch tên sản phẩm
    $category_id = $_POST["category_id"];
    $image = $_FILES["image"]['name'];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $sale_price = $_POST["sale_price"];
    $details = isset($_POST["details"]) ? $_POST["details"] : '';
    $short_description = isset($_POST["short_description"]) ? $_POST["short_description"] : '';

    // Kiểm tra tính hợp lệ của các trường
    if (strlen($name) > 255) {
        $error['name'] = 'Tên sản phẩm tối đa 255 ký tự';
    }

    if ($price < 0) {
        $error['price'] = 'Giá bán thường phải lớn hơn 0';
    }
    if ($quantity < 0) {
        $error['quantity'] = 'Số lượng phải lớn hơn 0';
    }
    if ($sale_price < 0) {
        $error['sale_price'] = 'Giá tiền khuyến mãi phải lớn hơn 0';
    }
    if ($sale_price > $price) {
        $error['sale_price'] = 'Giá khuyến mãi không được lớn hơn giá bán thường';
    }

    // Nếu không có lỗi, tiến hành cập nhật
    if (empty(array_filter($error))) {
        $hinh_anh = "../upload/"; // Đường dẫn lưu hình ảnh
        $target_file = $hinh_anh . basename($_FILES["image"]["name"]);

        // Upload hình ảnh
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Ảnh được upload thành công
        }

        try {
            // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
            $result = $ProductModel->update_product($category_id, $name, $image, $quantity, $price, $sale_price, $details, $short_description, $product_id);

            // Đặt cookie thông báo thành công và chuyển hướng
            setcookie('success_update', 'Cập nhật sản phẩm thành công', time() + 5, '/');
            header("Location: index.php?quanli=cap-nhat-san-pham&id=" . $product_id);
        } catch (Exception $e) {
            // Thông báo lỗi nếu xảy ra ngoại lệ
            $error_message = $e->getMessage();
            echo 'Thêm sản phẩm thất bại: ' . $error_message;
        }
    }
}

// Lấy thông báo thành công từ cookie
$success = '';
if (isset($_COOKIE['success_update']) && !empty($_COOKIE['success_update'])) {
    $success = $_COOKIE['success_update'];
}

// Hiển thị thông báo lỗi hoặc thành công
$html_alert = $BaseModel->alert_error_success('', $success);

?>
<!-- Bắt đầu Form -->
<div class="container-fluid pt-4">
    <form class="row g-4" action="" method="post" enctype="multipart/form-data">

        <!-- Phần thông tin chính -->
        <div class="col-sm-12 col-xl-9">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">
                    <a href="index.php?quanli=danh-sach-san-pham" class="link-not-hover">Sản phẩm</a>
                    / Cập nhật sản phẩm
                </h6>
                <?= $html_alert ?>

                <!-- Tên sản phẩm -->
                <label for="floatingInput">Tên sản phẩm</label>
                <div class="form-floating mb-3">
                    <input type="text" name="name" value="<?= $name ?>" class="form-control" id="floatingInput" placeholder="Tên sản phẩm">
                    <span class="text-danger"><?= $error['name'] ?></span>
                </div>

                <!-- Giá bán thường -->
                <label for="floatingInput">Giá bán thường (đ)</label>
                <div class="form-floating mb-3">
                    <input type="number" name="price" value="<?= $price ?>" class="form-control" id="floatingInput" placeholder="Giá bán thường (đ)">
                    <span class="text-danger"><?= $error['price'] ?></span>
                </div>

                <!-- Giá khuyến mãi -->
                <label for="floatingInput">Giá khuyến mãi (đ)</label>
                <div class="form-floating mb-3">
                    <input type="number" name="sale_price" value="<?= $sale_price ?>" class="form-control" id="floatingInput" placeholder="Giá khuyến mãi (đ)">
                    <span class="text-danger"><?= $error['sale_price'] ?></span>
                </div>

                <!-- Số lượng -->
                <label for="floatingInput">Số lượng (nhập số)</label>
                <div class="form-floating mb-3">
                    <input type="number" value="<?= $quantity ?>" name="quantity" class="form-control" id="floatingInput" placeholder="Số lượng">
                    <span class="text-danger"><?= $error['quantity'] ?></span>
                </div>

                <!-- Mô tả ngắn -->
                <label for="text-dark">Mô tả ngắn</label>
                <div class="form-floating mb-3">
                    <textarea name="short_description" class="form-control" placeholder="Mô tả ngắn" id="short_description"><?= $short_description ?></textarea>
                </div>

                <!-- Chi tiết sản phẩm -->
                <label for="floatingTextarea">Chi tiết sản phẩm</label>
                <div class="form-floating">
                    <textarea name="details" class="form-control" placeholder="Mô tả" id="product_details" style="height: 300px;"><?= $details ?></textarea>
                </div>
            </div>
        </div>

        <!-- Phần danh mục và hình ảnh -->
        <div class="col-sm-12 col-xl-3">
            <div class="bg-light rounded h-100 p-4">

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Hình ảnh (JPG, PNG)</label>
                    <input style="background-color: #fff" class="form-control form-control-sm" name="image" id="formFileSm" type="file">
                    <div class="my-2">
                        <img src="../upload/<?= $image ?>" style="width: 100%;" class="img-fluid" alt="">
                    </div>
                </div>

                <!-- Danh mục -->
                <div class="form-floating mb-3">
                    <select name="category_id" class="form-select" id="floatingSelect" required>
                        <?php
                        foreach ($list_categories as $cate) {
                            extract($cate);
                            $selected = ($cate['category_id'] == $product['category_id']) ? 'selected' : '';
                            echo '<option value="' . $category_id . '" ' . $selected . '>' . $name . '</option>';
                        }
                        ?>
                    </select>
                    <label for="floatingSelect">Chọn danh mục</label>
                </div>

                <!-- Nút hành động -->
                <h6 class="mb-4">
                    <input name="update_product" type="submit" value="Cập nhật" class="btn btn-custom">
                    <!-- <a href="index.php?quanli=thung-rac-san-pham&xoatam=<?= $product_id ?>" onclick="return confirmDeletionTemp();" class="btn btn-custom">Xóa tạm</a> -->
                </h6>
            </div>
        </div>
    </form>
</div>
<!-- Kết thúc Form -->