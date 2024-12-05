<?php
// Lấy danh sách danh mục sản phẩm và sản phẩm từ các model
$list_categories = $CategoryModel->select_all_categories();
$list_products = $ProductModel->select_products();

// Khởi tạo mảng chứa lỗi và giá trị tạm thời để lưu thông tin form
$error = array(
    'name' => '',
    'image' => '',
    'quantity' => '',
    'price' => '',
    'sale_price' => '',
);

$temp = array(
    'name' => '',
    'image' => '',
    'quantity' => '',
    'price' => '',
    'sale_price' => '',
    'details' => '',
    'short_description' => '',
);

$success = ''; // Thông báo thành công

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["themsanpham"])) {
    $name = trim($_POST["name"]); // Lấy và loại bỏ khoảng trắng thừa ở tên sản phẩm
    $category_id = $_POST["category_id"];
    $image = $_FILES["image"]['name'];

    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $sale_price = $_POST["sale_price"];
    $details = isset($_POST["details"]) ? $_POST["details"] : '';
    $short_description = isset($_POST["short_description"]) ? $_POST["short_description"] : '';

    // Kiểm tra tên sản phẩm đã tồn tại
    foreach ($list_products as $value) {
        if ($value['name'] == $name) {
            $error['name'] = 'Tên sản phẩm đã tồn tại.<br>';
            break;
        }
    }

    // Kiểm tra các trường thông tin
    if (empty($name)) {
        $error['name'] = 'Tên sản phẩm không được để trống';
    }

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

    if (empty($image)) {
        $image = "default-product.jpg"; // Đặt hình mặc định nếu không có hình được tải lên
    }

    // Nếu không có lỗi, thực hiện thêm sản phẩm
    if (empty(array_filter($error))) {
        $hinh_anh = "../upload/";
        $target_file = $hinh_anh . basename($_FILES["image"]["name"]);

        // Upload file ảnh
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        }

        try {
            // Chèn sản phẩm mới vào cơ sở dữ liệu
            $result = $ProductModel->insert_product($category_id, $name, $image, $quantity, $price, $sale_price, $details, $short_description);
            $success = 'Thêm sản phẩm thành công';
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            echo 'Thêm sản phẩm thất bại: ' . $error_message;
            $success = 'Thêm sản phẩm thất bại';
        }
    } else {
        // Nếu có lỗi, lưu giá trị tạm thời để hiển thị lại trong form
        $temp['name'] = $name;
        $temp['price'] = $price;
        $temp['sale_price'] = $sale_price;
        $temp['quantity'] = $quantity;
        $temp['short_description'] = $short_description;
        $temp['details'] = $details;
    }
}

// Tạo thông báo hiển thị
$html_alert = $BaseModel->alert_error_success('', $success);
?>

<!-- Form Thêm Sản Phẩm -->
<div class="container-fluid pt-4">
    <form class="row g-4" action="" method="post" enctype="multipart/form-data">
        <!-- Form bên trái: thông tin sản phẩm -->
        <div class="col-sm-12 col-xl-9">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">
                    <a href="index.php?quanli=danh-sach-san-pham" class="link-not-hover">Sản phẩm</a> / Thêm sản phẩm
                </h6>
                <?= $html_alert ?>
                <!-- Tên sản phẩm -->
                <label for="floatingInput">Tên sản phẩm</label>
                <div class="form-floating mb-3">
                    <input type="text" name="name" value="<?= $temp['name'] ?>" class="form-control" id="floatingInput" placeholder="Tên sản phẩm">
                    <span class="text-danger"><?= $error['name'] ?></span>
                </div>

                <!-- Giá bán thường -->
                <label for="floatingInput">Giá bán thường (đ)</label>
                <div class="form-floating mb-3">
                    <input type="number" name="price" value="<?= $temp['price'] ?>" class="form-control" id="floatingInput" placeholder="Giá bán thường (đ)">
                    <span class="text-danger"><?= $error['price'] ?></span>
                </div>

                <!-- Giá khuyến mãi -->
                <label for="floatingInput">Giá khuyến mãi (đ)</label>
                <div class="form-floating mb-3">
                    <input type="number" name="sale_price" value="<?= $temp['sale_price'] ?>" class="form-control" id="floatingInput" placeholder="Giá khuyến mãi (đ)">
                    <span class="text-danger"><?= $error['sale_price'] ?></span>
                </div>

                <!-- Số lượng -->
                <label for="floatingInput">Số lượng (nhập số)</label>
                <div class="form-floating mb-3">
                    <input type="number" value="<?= $temp['quantity'] ?>" name="quantity" class="form-control" id="floatingInput" placeholder="Số lượng">
                    <span class="text-danger"><?= $error['quantity'] ?></span>
                </div>

                <!-- Mô tả ngắn -->
                <label for="text-dark">Mô tả ngắn</label>
                <div class="form-floating mb-3">
                    <textarea name="short_description" class="form-control" placeholder="Mô tả ngắn" id="short_description" style="height: 300px;">
                        <?= $temp['short_description'] ?>
                    </textarea>
                </div>

                <!-- Chi tiết sản phẩm -->
                <label for="floatingTextarea">Chi tiết sản phẩm</label>
                <div class="form-floating">
                    <textarea name="details" class="form-control" placeholder="Mô tả" id="product_details" style="height: 300px;">
                        <?= $temp['details'] ?>
                    </textarea>
                </div>
            </div>
        </div>

        <!-- Form bên phải: hình ảnh và danh mục -->
        <div class="col-sm-12 col-xl-3">
            <div class="bg-light rounded h-100 p-4">
                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Hình ảnh (JPG, PNG)</label>
                    <input style="background-color: #fff" class="form-control form-control-sm" name="image" id="formFileSm" type="file">
                    <div class="my-2">
                        <img src="./img/testimonial-1.jpg" style="width: 100%;" class="img-fluid" alt="">
                    </div>
                </div>

                <!-- Danh mục -->
                <div class="form-floating mb-3">
                    <select name="category_id" class="form-select" id="floatingSelect" required>
                        <?php foreach ($list_categories as $value) : ?>
                            <option value="<?= $value['category_id'] ?>"><?= $value['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <label for="floatingSelect">Chọn danh mục</label>
                </div>

                <!-- Nút đăng -->
                <h6 class="mb-4">
                    <input name="themsanpham" type="submit" value="Đăng" class="btn btn-custom">
                </h6>
            </div>
        </div>
    </form>
</div>
<!-- Kết thúc Form Thêm Sản Phẩm -->