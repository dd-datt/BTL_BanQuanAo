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
        </div>
    </div>
</section>