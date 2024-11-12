<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $category_id = $_GET['id'];
    $list_products = $ProductModel->select_products_by_cate($category_id);
} else {
    header("Location: index.php");
}

$list_catgories = $CategoryModel->select_all_categories();
?>

<!-- Vị trí của trang web -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="index.php"><i class="fa fa-home"></i> Trang chủ</a>
                    <a href="index.php?url=cua-hang">
                        Sản phẩm
                    </a>
                    <span>
                        <?php foreach ($list_catgories as $value) {
                            if ($value['category_id'] == $category_id) {
                                echo $value['name'];
                            }
                        } ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Vị trí của trang web -->

<!-- Trang cửa hàng theo danh mục -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <div class="sidebar__categories">
                        <div class="section-title">
                            <h4>DANH MỤC</h4>
                        </div>
                        <div class="categories__accordion">
                            <div class="accordion" id="accordionExample">
                                <?php foreach ($list_catgories as $value) {
                                    extract($value);
                                ?>
                                    <div class="card">
                                        <div class="card-heading active">
                                            <a href="index.php?url=danh-muc-san-pham&id=<?= $category_id ?>">
                                                <?= $name ?>
                                            </a>
                                        </div>

                                    </div>
                                <?php
                                }
                                ?>


                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <?php if (count($list_products) > 0) { ?>
                <div class="col-lg-9 col-md-9">
                    <div class="row">

                        <!-- Hiện thị danh sách sản phẩm -->
                        <?php foreach ($list_products as $value) {
                            extract($value);
                            $discount_percentage = $ProductModel->discount_percentage($price, $sale_price);
                        ?>
                            <div class="col-lg-4 col-md-6 col-6-rp-mobile">
                                <div class="product__item sale">
                                    <div class="product__item__pic set-bg" data-setbg="upload/<?= $image ?>">

                                        <!-- Giảm giá -->
                                        <div class="label_right sale">-<?= $discount_percentage ?></div>

                                        <!-- Nút khi di chuyển chuột vào -->
                                        <ul class="product__hover">

                                            <!-- Nút đi đến trang chi tiết sp -->
                                            <li>
                                                <a href="index.php?url=chitietsanpham&id_sp=<?= $product_id ?>&id_dm=<?= $category_id ?>"><span class="icon_search_alt"></span></a>
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
                                                        <input value="<?= $image ?>" type="hidden" name="image">

                                                        <button type="submit" name="add_to_cart" id="toastr-success-top-right">
                                                            <a href="#"><span class="icon_bag_alt"></span></a>
                                                        </button>
                                                    </form>
                                                <?php } else { ?>
                                                    <button type="submit" onclick="alert('Vui lòng dăng nhập để thực hiện chức năng');" name="add_to_cart" id="toastr-success-top-right">
                                                        <a href="dang-nhap"><span class="icon_bag_alt"></span></a>
                                                    </button>
                                                <?php } ?>
                                            </li>

                                        </ul>

                                    </div>
                                    <div class="product__item__text">
                                        <!-- Hiện thị tên sp -->
                                        <h6 class="text-truncate-1"><a href=""><?= $name ?></a></h6>
                                        <!-- Hiện thị giá bán -->
                                        <div class="product__price"><?= number_format($sale_price) . "₫" ?> <span><?= number_format($price) . "đ" ?> </span></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
            <?php } else { ?>
                <div class="col-lg-9 col-md-9">
                    <div class="container-fluid mt-5">
                        <div class="row rounded justify-content-center mx-0 pt-5">
                            <div class="col-md-6 text-center">
                                <h4 class="mb-4">Danh mục chưa có sản phẩm</h4>
                                <a class="btn btn-primary rounded-pill py-3 px-5" href="index.php?url=cua-hang">Trở lại cửa hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- END Trang cửa hàng theo danh mục -->