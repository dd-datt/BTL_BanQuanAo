<?php
// Lấy danh sách 12 sản phẩm mới nhất
$listProducts = $ProductModel->select_products_limit(12);

// Lấy danh sách 8 danh mục
$listCategories = $CategoryModel->select_categories_limit(8);

// Lấy 3 sản phẩm cho phần xu hướng
$product_limit_3 = $ProductModel->select_products_limit(3);

// Lấy 3 sản phẩm sắp xếp theo thứ tự tăng dần
$product_order_by = $ProductModel->select_products_order_by(3, 'ASC');
?>

<!-- Phần Banner/Slider -->
<section class="container my-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-sm-12 d-flex justify-content-center">
            <!-- Carousel Banner -->
            <div id="header-carousel" class="carousel slide" data-ride="carousel" style="width: 100%; max-width: 1000px;">
                <div class="carousel-inner" style="border-radius: 10px;">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img class="img-fluid" src="upload/banner_quanao_main4.png" alt="Image">
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <img class="img-fluid" src="upload/banner_quanao_main5.png" alt="Image">
                    </div>
                </div>
                <!-- Nút điều khiển previous -->
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <!-- Nút điều khiển next -->
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Phần Sản phẩm -->
<section class="product spad" style="background-color: #F4F4F9;">
    <!-- Phần Danh mục sản phẩm -->
    <section class="container cate-home" style="background-color: #ffffff; border-radius: 10px;">
        <div class="section-title pt-2" style="margin-bottom: 30px;">
            <h4>Danh mục sản phẩm</h4>
        </div>

        <div class="row g-1 mb-4 mt-2 pb-4">
            <?php foreach ($listCategories as $value) {
                extract($value);
                $link = 'index.php?url=danh-muc-san-pham&id=' . $category_id;
            ?>
                <!-- Hiển thị từng danh mục -->
                <div class="col-lg-2 col-md-3 col-sm-6 text-center p-1 cate-gory">
                    <a href="<?= $link ?>">
                        <img style="width: 50%;" src="upload/<?= $image ?>" alt="">
                    </a>
                    <div class="mt-2">
                        <a class="cate-name text-dark" href="<?= $link ?>"><?= $name ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Phần Danh sách sản phẩm -->
    <div class="container" style="background-color: #ffffff; border-radius: 10px;">
        <div class="row pt-3">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Sản phẩm</h4>
                </div>
            </div>
        </div>

        <!-- Grid sản phẩm -->
        <div class="row property__gallery">
            <?php foreach ($listProducts as $product) {
                extract($product);
                $discount_percentage = $ProductModel->discount_percentage($price, $sale_price);
            ?>
                <!-- Card sản phẩm -->
                <div class="col-lg-3 col-md-4 col-sm-6 mix sach-1">
                    <div class="product__item sale">
                        <!-- Hình ảnh sản phẩm -->
                        <div class="product__item__pic set-bg" data-setbg="upload/<?= $image ?>">
                            <!-- Label giảm giá -->
                            <div class="label_right sale">-<?= $discount_percentage ?></div>

                            <!-- Các nút tương tác -->
                            <ul class="product__hover">
                                <!-- Nút xem chi tiết -->
                                <li>
                                    <a href="index.php?url=chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>">
                                        <span class="icon_search_alt"></span>
                                    </a>
                                </li>

                                <!-- Nút thêm vào giỏ hàng -->
                                <li>
                                    <?php if (isset($_SESSION['user'])) { ?>
                                        <form action="index.php?url=gio-hang" method="post">
                                            <input value="<?= $product_id ?>" type="hidden" name="product_id">
                                            <input value="<?= $_SESSION['user']['id'] ?>" type="hidden" name="user_id">
                                            <input value="<?= $name ?>" type="hidden" name="name">
                                            <input value="<?= $image ?>" type="hidden" name="image">
                                            <input value="<?= $sale_price ?>" type="hidden" name="price">
                                            <input value="1" type="hidden" name="product_quantity">
                                            <button type="submit" name="add_to_cart" id="toastr-success-top-right">
                                                <a href="#"><span class="fas fa-shopping-cart"></span></a>
                                            </button>
                                        </form>
                                    <?php } else { ?>
                                        <button type="submit" onclick="alert('Vui lòng đăng nhập để thực hiện chức năng');" name="add_to_cart" id="toastr-success-top-right">
                                            <a href="dang-nhap"><span class="icon_bag_alt"></span></a>
                                        </button>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="product__item__text">
                            <h6 class="text-truncate-1"><a href=""><?= $name ?></a></h6>
                            <div class="product__price" id="product__price">
                                <?= number_format($sale_price) . "₫" ?>
                                <span><?= number_format($price) . "đ" ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Nút xem tất cả -->
            <div class="col-lg-12 text-center mb-4">
                <a href="index.php?url=cua-hang" class="btn btn-outline-primary">Xem tất cả</a>
            </div>
        </div>
    </div>
</section>

<!-- Phần Xu hướng -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            <!-- Cột Xu hướng -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Xu hướng</h4>
                    </div>
                    <?php foreach ($product_limit_3 as $value) {
                        extract($value);
                    ?>
                        <!-- Item xu hướng -->
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <a href="chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>">
                                    <img src="upload/<?= $image ?>" style="width: 90px;" alt="">
                                </a>
                            </div>
                            <div class="trend__item__text">
                                <h6>
                                    <a href="chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>" class="text-dark"><?= $name ?></a>
                                </h6>
                                <div class="product__price"><?= number_format($sale_price) ?>₫</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Cột Bán chạy -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>BÁN CHẠY</h4>
                    </div>
                    <?php foreach ($product_order_by as $value) {
                        extract($value);
                    ?>
                        <!-- Item bán chạy -->
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <a href="chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>">
                                    <img src="upload/<?= $image ?>" style="width: 90px;" alt="">
                                </a>
                            </div>
                            <div class="trend__item__text">
                                <h6>
                                    <a href="chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>" class="text-dark"><?= $name ?></a>
                                </h6>
                                <div class="product__price"><?= number_format($sale_price) ?>₫</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Cột Hot sale -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Hot sale</h4>
                    </div>
                    <?php foreach ($product_limit_3 as $value) {
                        extract($value);
                    ?>
                        <!-- Item hot sale -->
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <a href="chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>">
                                    <img src="upload/<?= $image ?>" style="width: 90px;" alt="">
                                </a>
                            </div>
                            <div class="trend__item__text">
                                <h6>
                                    <a href="chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>" class="text-dark"><?= $name ?></a>
                                </h6>
                                <div class="product__price"><?= number_format($sale_price) ?>₫</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Phần Dịch vụ -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <!-- Miễn phí vận chuyển -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Miễn phí vận chuyển</h6>
                    <p>Cho tất cả các đơn hàng trên 200.000đ</p>
                </div>
            </div>

            <!-- Đảm bảo hoàn tiền -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Đảm bảo hoàn tiền</h6>
                    <p>Nếu sản phẩm có vấn đề</p>
                </div>
            </div>

            <!-- Hỗ trợ 24/7 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Hỗ trợ trực tuyến 24/7</h6>
                    <p>Hỗ trợ chuyên dụng</p>
                </div>
            </div>

            <!-- Thanh toán an toàn -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Thanh toán an toàn</h6>
                    <p>Thanh toán an toàn 100%</p>
                </div>
            </div>
        </div>
    </div>
</section>