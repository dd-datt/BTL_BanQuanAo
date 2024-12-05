<?php
// Lấy danh sách tất cả danh mục sản phẩm
$list_catgories = $CategoryModel->select_all_categories();
?>

<!-- Phần cửa hàng -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- Sidebar bên trái -->
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <!-- Phần danh mục sản phẩm -->
                    <div class="sidebar__categories">
                        <div class="section-title">
                            <h4>DANH MỤC SẢN PHẨM</h4>
                        </div>
                        <div class="categories__accordion">
                            <div class="accordion" id="accordionExample">
                                <!-- Vòng lặp hiển thị danh sách danh mục -->
                                <?php foreach ($list_catgories as $value) {
                                    extract($value);
                                ?>
                                    <div class="card">
                                        <div class="card-heading active">
                                            <a href="index.php?url=danh-muc-san-pham&id=<?= $category_id ?>"><?= $name ?></a>
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


            <!-- Bên phải dùng để tìm kiếm-->
            <div class="col-lg-9 col-md-9">
                <div class="container-fluid mt-5">
                    <div class="row rounded justify-content-center mx-0 pt-5">
                        <div class="col-md-6 text-center">
                            <!-- Form tìm -->
                            <form action="tim-kiem" method="get">
                                <div class="form-outline">
                                    <input type="search" name="query" class="form-control" placeholder="Tìm kiếm" />
                                </div>
                            </form>
                            <!-- Kthuc form -->
                            <a class="btn btn-primary rounded-pill py-3 px-5 mt-5" href="index.php?url=cua-hang">Trở lại cửa hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>