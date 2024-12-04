<?php
// Bắt đầu output buffering và session
ob_start();
session_start();

// Kiểm tra xem admin đã đăng nhập chưa, nếu chưa thì chuyển hướng tới trang đăng nhập
if (!isset($_SESSION['user_admin'])) {
    header("Location: login.php");
    exit();
}

// Nạp các file model cần thiết
require_once "models_admin/pdo_library.php";
require_once "models_admin/BaseModel.php";
require_once "models_admin/CategoryModel.php";
require_once "models_admin/ProductModel.php";
require_once "models_admin/CustomerModel.php";
require_once "models_admin/OrderModel.php";
require_once "models_admin/PostModel.php";
require_once "models_admin/CommentModel.php";
require_once "models_admin/WarehousemModel.php";

// Nạp các thành phần giao diện
require_once "components/head.php";
require_once "components/header.php";

// Xử lý điều hướng (route)
if (!isset($_GET['quanli'])) {
    // Mặc định hiển thị trang chủ
    require_once "home.php";
} else {
    switch ($_GET['quanli']) {
            // **Quản lý sản phẩm**
        case 'danh-sach-san-pham':
            require_once "san-pham/list.php"; // Hiển thị danh sách sản phẩm
            break;
        case 'them-san-pham':
            require_once "san-pham/add.php"; // Thêm sản phẩm mới
            break;
        case 'cap-nhat-san-pham':
            require_once "san-pham/edit.php"; // Cập nhật thông tin sản phẩm
            break;
        case 'thung-rac-san-pham':
            require_once "san-pham/thung-rac.php"; // Quản lý sản phẩm trong thùng rác
            break;

            // **Quản lý danh mục**
        case 'danh-sach-danh-muc':
            require_once "danh-muc/list.php"; // Hiển thị danh sách danh mục
            break;
        case 'them-danh-muc':
            require_once "danh-muc/add.php"; // Thêm danh mục mới
            break;
        case 'cap-nhat-danh-muc':
            require_once "danh-muc/edit.php"; // Cập nhật thông tin danh mục
            break;

            // **Quản lý đơn hàng**
        case 'danh-sach-don-hang':
            require_once "don-hang/list.php"; // Hiển thị danh sách đơn hàng
            break;
        case 'danh-sach-don-cho':
            require_once "don-hang/unconfirmed.php"; // Hiển thị danh sách đơn chờ xác nhận
            break;
        case 'cap-nhat-don-hang':
            require_once "don-hang/edit.php"; // Cập nhật thông tin đơn hàng
            break;
        case 'in-hoa-don':
            require_once "don-hang/hoadon.php"; // In hóa đơn
            break;

            // **Quản lý bài viết**
        case 'danh-sach-bai-viet':
            require_once "bai-viet/list.php"; // Hiển thị danh sách bài viết
            break;
        case 'them-bai-viet':
            require_once "bai-viet/add.php"; // Thêm bài viết mới
            break;
        case 'cap-nhat-bai-viet':
            require_once "bai-viet/edit.php"; // Cập nhật bài viết
            break;
        case 'danh-muc-bai-viet':
            require_once "bai-viet/category.php"; // Quản lý danh mục bài viết
            break;
        case 'cap-nhat-danh-muc-bai-viet':
            require_once "bai-viet/edit_catgory.php"; // Cập nhật danh mục bài viết
            break;

            // **Tài khoản**
        case 'dang-xuat':
            unset($_SESSION['user_admin']); // Đăng xuất tài khoản admin
            header("Location: login.php");
            break;

            // **Quản lý nhân viên và khách hàng**
            // Nhân viên
        case 'danh-sach-nhan-vien':
            require_once "thanh-vien/list_nv.php"; // Danh sách nhân viên
            break;
        case 'them-tai-khoan-nv':
            require_once "thanh-vien/add_nv.php"; // Thêm tài khoản nhân viên
            break;
        case 'sua-tai-khoan-nv':
            require_once "thanh-vien/edit_nv.php"; // Sửa tài khoản nhân viên
            break;

            // Khách hàng
        case 'danh-sach-khach-hang':
            require_once "thanh-vien/list_kh.php"; // Danh sách khách hàng
            break;
        case 'them-tai-khoan-kh':
            require_once "thanh-vien/add_kh.php"; // Thêm tài khoản khách hàng
            break;
        case 'sua-tai-khoan-kh':
            require_once "thanh-vien/edit_kh.php"; // Sửa tài khoản khách hàng
            break;

            // **Quản lý bình luận**
        case 'binh-luan':
            require_once "binh-luan/list.php"; // Danh sách bình luận
            break;
        case 'chi-tiet-binh-luan':
            require_once "binh-luan/edit.php"; // Chi tiết bình luận
            break;

            // **Thống kê**
        case 'thong-ke-san-pham':
            require_once "thong-ke/products.php"; // Thống kê sản phẩm
            break;
        case 'thong-ke-don-hang':
            require_once "thong-ke/orders.php"; // Thống kê đơn hàng
            break;
        case 'bieu-do-luot-ban':
            require_once "thong-ke/chart-order.php"; // Biểu đồ lượt bán
            break;
        case 'top-luot-ban':
            require_once "thong-ke/top-orders.php"; // Top lượt bán
            break;
        case 'luot-ban-theo-ngay':
            require_once "thong-ke/chart-order-date.php"; // Biểu đồ lượt bán theo ngày
            break;
        case 'xuat-exel':
            require_once "export_exel/export_orders.php"; // Xuất file Excel
            break;

            // **Quản lý kho hàng**
        case 'kho-hang2':
            require_once "kho-hang/list.php"; // Danh sách kho hàng (phương án 2)
            break;
        case 'kho-hang':
            require_once "kho-hang/danhsach.php"; // Danh sách kho hàng
            break;
        case 'them-hoa-don':
            require_once "kho-hang/add.php"; // Thêm hóa đơn mới
            break;

            // **Xử lý mặc định**
        default:
            require_once "components/404.php"; // Hiển thị trang lỗi 404
            break;
    }
}

// Nạp footer
require_once "components/footer.php";

// Kết thúc output buffering
ob_end_flush();
