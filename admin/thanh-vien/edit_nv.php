<?php
   require_once "models_admin/CustomerModel.php";

if (isset($_GET['id'])) {
    $username = $_GET['id'];
    $user = $CustomerModel->get_user_admin($username); // Lấy thông tin người dùng
    if (empty($user)) {
        die("Người dùng không tồn tại.");
    }
    $user = $user[0]; // Lấy thông tin người dùng đầu tiên
} else {
    die("ID không hợp lệ.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý cập nhật thông tin
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password']; // Lấy mật khẩu từ form

    // Cập nhật thông tin người dùng
    $CustomerModel->user_update($username, $full_name, $email, $phone, $address, $password);
    
    // Thông báo cập nhật thành công và chuyển hướng
    echo "<script>
            alert('Cập nhật thông tin thành công!');
            window.location.href = 'index.php?quanli=danh-sach-nhan-vien'; // Chuyển hướng về danh sách nhân viên
          </script>";
    exit(); // Dừng thực thi mã PHP
}
?>

<div class="container pt-4">
    <article class="card">
        <header class="card-header text-dark">
            <h6>Thông tin nhân viên</h6>
        </header>
        <div class="card-body mt-2">
            <form method="POST" id="updateForm">
                <div class="mb-3">
                    <label for="full_name">Họ tên</label>
                    <input type="text" name="full_name" value="<?=$user['full_name']?>" required class="form-control" placeholder="Họ tên">
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?=$user['email']?>" required class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" name="phone" value="<?=$user['phone']?>" required class="form-control" placeholder="Số điện thoại">
                </div>
                <div class="mb-3">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" value="<?=$user['address']?>" required class="form-control" placeholder="Địa chỉ">
                </div>
                <div class="mb-3">
                    <label for="password">Mật khẩu</label>
                    <input type="text" name="password" value="<?=$user['password']?>" required class="form-control" placeholder="Mật khẩu">
                    <input type="checkbox" id="showPassword" onclick="togglePassword()"> Hiện mật khẩu
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirmUpdate()">Cập nhật</button>
                <a href="index.php?quanli=danh-sach-nhan-vien" class="btn btn-secondary">Quay lại danh sách</a>
            </form>
        </div>
    </article>
</div>

<script>
function confirmUpdate() {
    // Xác nhận trước khi gửi form
    return confirm("Bạn có chắc chắn muốn cập nhật thông tin không?");
}

function togglePassword() {
    var passwordField = document.querySelector('input[name="password"]');
    if (document.getElementById("showPassword").checked) {
        passwordField.type = "text"; // Hiện mật khẩu
    } else {
        passwordField.type = "password"; // Ẩn mật khẩu
    }
}
</script>
