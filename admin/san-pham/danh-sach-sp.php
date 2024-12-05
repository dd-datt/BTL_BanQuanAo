<?php
// Kiểm tra nếu nút "search" được nhấn
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword']; // Từ khóa tìm kiếm
    $cate_id = $_POST['search_cate']; // ID danh mục tìm kiếm
} else {
    $keyword = '';
    $cate_id = 0; // Mặc định là 0 (tất cả danh mục)
}

// // Kiểm tra trang hiện tại (nếu không có thì mặc định là trang 1)
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Lấy danh sách danh mục và sản phẩm từ các model
$list_categories = $CategoryModel->select_all_categories(); // Lấy tất cả danh mục
$list_products = $ProductModel->select_list_products($keyword, $cate_id, $page, 10); // Lấy danh sách sản phẩm theo điều kiện tìm kiếm
$count_recycle = $ProductModel->select_recycle_products(); // Lấy số lượng sản phẩm trong thùng rác

// // Phân trang
$all_products = $ProductModel->select_products(); // Lấy tất cả sản phẩm
$totalProducts = count($all_products); // Tổng số sản phẩm
$productsPerPage = 10; // Số sản phẩm mỗi trang

// Tính số trang
$totalProducts = intval($totalProducts); // Chuyển đổi sang kiểu số nguyên
$productsPerPage = intval($productsPerPage);
$numberOfPages = ceil($totalProducts / $productsPerPage); // Số trang cần thiết

$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1; // Trang hiện tại

// Tạo HTML cho phân trang
$html_pagination = '';
$pagination_next = '';
$pagination_prev = '';

for ($i = 1; $i <= $numberOfPages; $i++) {
    // Đánh dấu trang hiện tại
    $active = ($i === $currentPage) ? 'active' : '';

    $html_pagination .= '
        <li class="page-item ' . $active . '">
            <a class="page-link" href="index.php?quanli=danh-sach-san-pham&page=' . $i . '">' . $i . '</a>
        </li>
    ';
}

// Tạo nút "Next" nếu không phải trang cuối
if ($currentPage < $numberOfPages) {
    $pagination_next = '
        <li class="page-item">
            <a class="page-link" href="index.php?quanli=danh-sach-san-pham&page=' . ($currentPage + 1) . '">
                Tiếp <i class="fa fa-angle-right"></i>
            </a>
        </li>
    ';
}

// Tạo nút "Prev" nếu không phải trang đầu
if ($currentPage > 1) {
    $pagination_prev = '
        <li class="page-item">
            <a class="page-link" href="index.php?quanli=danh-sach-san-pham&page=' . ($currentPage - 1) . '">
                <i class="fa fa-angle-left"></i> Trước 
            </a>
        </li>
    ';
}
?>

<!-- GIAO DIỆN DANH SÁCH SẢN PHẨM -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Danh sách sản phẩm</h6>
            <a href="them-san-pham" class="btn btn-custom"><i class="fa fa-plus"></i> Thêm sản phẩm</a>
        </div>

        <!-- Thanh tìm kiếm và lọc -->
        <div class="row align-items-center">
            <div class="col-lg-7 d-flex mb-3">
                <a class="link-hover" href="">Tất cả (<?= $totalProducts ?>)</a>
                <div class="mx-2">|</div>
                <a class="link-not-hover" href="index.php?quanli=thung-rac-san-pham">Thùng rác (<?= count($count_recycle) ?>)</a>
            </div>
            <form action="" method="post" class="col-lg-5 d-flex mb-3 justify-content-end">
                <div class="form-group">
                    <input type="search" name="keyword" class="form-control" placeholder="Tìm sản phẩm">
                </div>
                <div class="form-group mx-2">
                    <select class="form-select" name="search_cate">
                        <option value="">Tất cả</option>
                        <?php foreach ($list_categories as $value) : ?>
                            <option value="<?= $value['category_id'] ?>">
                                <?= $value['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <input type="submit" name="search" class="btn btn-custom" value="Lọc">
            </form>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Giá thường</th>
                        <th scope="col">Giá khuyến mãi</th>
                        <th scope="col">Chỉnh sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    foreach ($list_products as $value) {
                        $index++;
                        $orderNumber = ($currentPage - 1) * $productsPerPage + $index; // Số thứ tự sản phẩm
                    ?>
                        <tr>
                            <td class="text-dark"><?= $orderNumber ?></td>
                            <td class="text-dark" style="min-width: 200px;"><?= $value['name'] ?></td>
                            <td>
                                <img style="max-width: 50px;" src="../upload/<?= $value['image'] ?>" alt="">
                            </td>
                            <td class="text-dark" style="font-weight: 600;">
                                <?= number_format($value['price']) . "₫" ?>
                            </td>
                            <td class="text-danger" style="font-weight: 600;">
                                <?= number_format($value['sale_price']) . "₫" ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="fs-24 text-gray">
                                        <i class="bi bi-three-dots-vertical text-dark"></i>
                                    </a>
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" href="../index.php?url=chitietsanpham&id_sp=<?= $value['product_id'] ?>&id_dm=<?= $value['category_id'] ?>" target="_blank">
                                            Xem
                                        </a>
                                        <a class="dropdown-item" href="index.php?quanli=cap-nhat-san-pham&id=<?= $value['product_id'] ?>">Sửa</a>
                                        <a class="dropdown-item text-danger" onclick="return confirmDeletionTemp();" href="index.php?quanli=thung-rac-san-pham&xoatam=<?= $value['product_id'] ?>">
                                            Xóa
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="col-12 mt-4">
                <nav>
                    <ul class="pagination justify-content-center">
                        <?= $pagination_prev ?>
                        <?= $html_pagination ?>
                        <?= $pagination_next ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- GIAO DIỆN DANH SÁCH SẢN PHẨM KẾT THÚC -->