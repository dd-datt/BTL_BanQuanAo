<?php
// Kiểm tra và lấy thông tin sản phẩm từ URL
if (isset($_GET['id_sp'])) {
    $id_sp = $_GET['id_sp']; // ID sản phẩm
    $id_danhmuc = $_GET['id_dm']; // ID danh mục

    // Cập nhật lượt xem sản phẩm
    $product_details = $ProductModel->update_views($id_sp);

    // Lấy thông tin chi tiết sản phẩm
    $product_details = $ProductModel->select_products_by_id($id_sp);

    // Lấy các sản phẩm tương tự trong cùng danh mục
    $similar_product = $ProductModel->select_products_similar($id_danhmuc);

    // Lấy tên danh mục
    $name_catgoty = $CategoryModel->select_name_categories();
}
?>

<?php
// Trích xuất thông tin sản phẩm
extract($product_details);

// Tính phần trăm giảm giá
$discount_percentage = $ProductModel->discount_percentage($price, $sale_price);

?>

<!-- Phần hiển thị breadcrumb -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="index.php"><i class="fa fa-home"></i> Trang chủ</a>
                    <a href="index.php?url=cua-hang">Sản phẩm </a>
                    <a href="index.php?url=danh-muc-san-pham&id=<?= $id_danhmuc ?>">
                        <?php
                        // Hiển thị tên danh mục
                        foreach ($name_catgoty as $value) {
                            if ($value['category_id'] == $id_danhmuc) {
                                echo $value['name'];
                            }
                        }
                        ?>
                    </a>
                    <span><?= $name ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Phần chi tiết sản phẩm -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <!-- Phần hình ảnh sản phẩm -->
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <div class="product__details__slider__content">
                        <div class="product__details__pic__slider owl-carousel">
                            <img data-hash="product-1" class="product__big__img" src="upload/<?= $image ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần thông tin sản phẩm -->
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3><?= $name ?>
                        <span>
                            Danh mục:
                            <?php
                            foreach ($name_catgoty as $value) {
                                if ($value['category_id'] == $id_danhmuc) {
                                    echo $value['name'];
                                }
                            }
                            ?>
                        </span>
                    </h3>

                    <!-- Hiển thị giá và % giảm giá -->
                    <div class="product__details__price">
                        <?= $ProductModel->formatted_price($sale_price); ?>
                        <span class="ml-2">
                            <?= $ProductModel->formatted_price($price); ?>
                        </span>
                        <div class="label_right ml-2"><?= $discount_percentage ?></div>
                    </div>

                    <div class="short__description">
                        <?= $short_description ?>
                    </div>

                    <?php if ($quantity == 0) { ?>
                        <!-- Hiển thị nút hết hàng -->
                        <div class="quantity">
                            <button style="border: none;" type="submit" class="btn btn-warning">
                                Hết hàng
                            </button>
                        </div>
                    <?php } else { ?>
                        <!-- Form thêm vào giỏ hàng -->
                        <div class="product__details__button">
                            <?php if (isset($_SESSION['user'])) { ?>
                                <!-- Form cho user đã đăng nhập -->
                                <form action="index.php?url=gio-hang" method="post">
                                    <div class="input-group d-flex align-items-center">
                                        <span class="text-dark">Số lượng</span>
                                        <div class="input-next-cart d-flex mx-4">
                                            <input type="button" value="-" class="button-minus" data-field="quantity">
                                            <input type="number" step="1" max="50" value="1" name="product_quantity" class="quantity-field-cart">
                                            <input type="button" value="+" class="button-plus" data-field="quantity">
                                        </div>
                                        <span class="text-dark"><?= $quantity ?> sản phẩm có sẵn</span>
                                    </div>

                                    <!-- Input ẩn chứa thông tin sản phẩm -->
                                    <input value="<?= $product_id ?>" type="hidden" name="product_id">
                                    <input value="<?= $_SESSION['user']['id'] ?>" type="hidden" name="user_id">
                                    <input value="<?= $name ?>" type="hidden" name="name">
                                    <input value="<?= $image ?>" type="hidden" name="image">
                                    <input value="<?= $sale_price ?>" type="hidden" name="price">
                                    <input value="<?= $image ?>" type="hidden" name="image">

                                    <div class="quantity">
                                        <button name="add_to_cart" style="border: none;" type="submit" class="cart-btn btn-primary">
                                            <span class="icon_bag_alt"></span> Thêm vào giỏ
                                        </button>
                                        <button name="add_to_cart" type="submit" style="background-color: #ca1515; border: none;" class="cart-btn">
                                            <span class="icon_bag_alt"></span>Mua ngay
                                        </button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <!-- Hiển thị cho user chưa đăng nhập -->
                                <div class="input-group d-flex align-items-center">
                                    <span class="text-dark">Số lượng</span>
                                    <div class="input-next-cart d-flex mx-4">
                                        <input type="button" value="-" class="button-minus" data-field="quantity">
                                        <input type="number" readonly step="1" max="50" value="1" name="product_quantity" class="quantity-field-cart">
                                        <input type="button" value="+" class="button-plus" data-field="quantity">
                                    </div>
                                    <span class="text-dark"><?= $quantity ?> sản phẩm có sẵn</span>
                                </div>
                                <div class="quantity">
                                    <button name="add_to_cart" onclick="alert('Vui lòng dăng nhập để thực hiện chức năng');" style="border: none;" type="submit" class="cart-btn btn-primary">
                                        <span class="icon_bag_alt"></span>
                                        <a href="dang-nhap" style="color: #ffffff;">Thêm vào giỏ</a>
                                    </button>
                                    <button name="add_to_cart" onclick="alert('Vui lòng dăng nhập để thực hiện chức năng');" type="submit" style="background-color: #ca1515; border: none;" class="cart-btn">
                                        <span class="icon_bag_alt"></span>
                                        <a href="dang-nhap" style="color: #ffffff;">Mua ngay</a>
                                    </button>
                                </div>
                            <?php } ?>

                            
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Phần mô tả chi tiết -->
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Mô tả</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <h6>Mô tả</h6>
                            <p><?= $details ?></p>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần sản phẩm tương tự -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>SẢM PHẨM TƯƠNG TỰ</h5>
                </div>
            </div>

            <?php
            foreach ($similar_product as $value) {
                if (is_array($value)) {
                    extract($value);
                    $discount_percentage = $ProductModel->discount_percentage($price, $sale_price);
                }
            ?>
                <!-- Hiển thị từng sản phẩm tương tự -->
                <div class="col-lg-3 col-md-4 col-sm-6 mix">
                    <div class="product__item sale">
                        <div class="product__item__pic set-bg" data-setbg="upload/<?= $image ?>">
                            <div class="label_right sale">-<?= $discount_percentage ?></div>
                            <ul class="product__hover">
                                <li>
                                    <a href="index.php?url=chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>">
                                        <span class="icon_search_alt"></span>
                                    </a>
                                </li>
                                <li>
                                    <form action="blog.html" method="post">
                                        <input type="hidden" name="product_id">
                                        <input type="hidden" name="user_id">
                                        <input type="hidden" name="name">
                                        <input type="hidden" name="price">
                                        <input type="hidden" name="quantity">
                                        <input type="hidden" name="image">
                                        <button type="submit" name="add_to_cart">
                                            <a href="#"><span class="icon_bag_alt"></span></a>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <div class="product__item__text">
                            <h6 class="text-truncate-1">
                                <a href="index.php?url=chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>">
                                    <?= $name ?>
                                </a>
                            </h6>
                            <div class="product__price">
                                <?= $ProductModel->formatted_price($sale_price); ?>
                                <span><?= $ProductModel->formatted_price($price); ?> </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- CSS cho label giảm giá -->
<style>
    .label_right {
        font-size: 14px;
        color: #ffffff;
        font-weight: 700;
        display: inline-block;
        padding: 2px 8px;
        text-transform: uppercase;
        background: #ca1515;
        border-radius: 5px;
    }
</style>