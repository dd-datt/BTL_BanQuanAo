<?php
ob_start();
session_start();


require_once "models/pdo_library.php";
require_once "models/BaseModel.php";
require_once "models/ProductModel.php";
require_once "models/CategoryModel.php";
require_once "models/CustomerModel.php";
require_once "models/CommentModel.php";
require_once "models/CartModel.php";
require_once "models/OrderModel.php";
require_once "models/PostModel.php";
require_once "models/AddressModel.php";
define('BASE_URL', 'index.php?url=');
define('URL_ORDER', 'http://localhost/BTL_BanQuanAo/don-hang');

// Các thành phần có thể sử dụng lại
require_once "components/head.php";
require_once "components/header.php";


if (!isset($_GET['url'])) {
    require_once "views/home.php";
} else {
    switch ($_GET['url']) {
            // Trang chủ
        case 'trang-chu':
            require_once "views/home.php";
            break;
        case 'cua-hang':
            require_once "views/shop.php";
            break;
            // Chi tiết sản phẩm
        case 'chitietsanpham':
            require_once "views/productdetail.php";
            break;
            // Danh mục sản phẩm
        case 'danh-muc-san-pham':
            require_once "views/shop-by-category.php";
            break;
            // Liên hệ
        case 'lien-he':
            require_once "views/contact.php";
            break;
            // Giỏ hàng
        case 'gio-hang':
            require_once "views/giohang.php";
            break;
            // Thanh toán
        case 'thanh-toan':
            require_once "views/thanhtoan1.php";
            break;
            // Nếu ấn vào "Sửa" thì sang trag này, cho phép sửa thông tin đặt hàng
        case 'thanh-toan-2':
            require_once "views/thanhtoan2.php";
            break;
        case 'cam-on':
            require_once "views/thanks.php";
            break;
        
            // User
        case 'dang-nhap':
            require_once "views/user/login.php";
            break;
        case 'dang-ky':
            require_once "views/user/register.php";
            break;
        case 'dang-xuat':
            unset($_SESSION['user']);
            header("Location: index.php");
            break;
        case 'thong-tin-tai-khoan':
            require_once "views/user/user-infor.php";
            break;
        case 'ho-so':
            require_once "views/user/edit-profile.php";
            break;
        case 'them-dia-chi':
            require_once "views/user/add-address.php";
            break;
        case 'doi-mat-khau':
            require_once "views/user/change-password.php";
            break;
        case 'quen-mat-khau':
            require_once "views/user/forgot-password.php";
            break;
        case 'khoi-phuc-mat-khau':
            require_once "views/user/password-recovery.php";
            break;
            // Đổi trả
        case 'doi-tra':
            require_once "view/doi-tra.php";
            break;


            //Tìm kiếm
        case 'tim-kiem':
            require_once "views/search.php";
            break;
            // Không tìm thấy/Chưa tạo trang đó
        default:
            require_once "views/not-page.php";
            break;
    }
}
require_once "components/footer.php";



ob_end_flush();
?>
<br>