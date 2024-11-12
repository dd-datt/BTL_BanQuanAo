<?php

    $success = '';
    $error = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
        $product_id = $_POST["product_id"];
        $user_id = $_POST["user_id"];
        $product_name = $_POST["name"];
        $product_price = $_POST["price"];
        $product_quantity = $_POST["product_quantity"];
        $product_image = $_POST["image"];

        if($product_quantity < 1 ) {
            
            echo "<script>alert('Số lượng sản phẩm không được nhỏ hơn 0');</script>";
            echo "<script>window.location.href='index.php?url=chitietsanpham&id_sp=".$product_id."&id_dm=16';</script>";
            exit();
        }

        // Đếm số lượng sản trong giỏ hàng
        $product = $CartModel->select_cart_by_id($product_id, $user_id);
        // Kiểm tra xem có sản phẩm trong giỏ hàng hay không
        if($product && is_array($product)) {
            // Số lượng mới = số lượng hiện tại + số lượng vừa thêm
            $current_quantity = $product['product_quantity'];
            $new_quantity = $current_quantity + $product_quantity;

            // Cập nhật số lượng
            $CartModel->update_cart($new_quantity, $product_id, $user_id);
            $success .= 'Đã cập nhật số lượng cho sản phẩm: '.$product_name;
        }
        else {
            $product_quantity = $product_quantity;
            $CartModel->insert_cart($product_id, $user_id, $product_name, $product_price, $product_quantity, $product_image);
            $success = "Đã thêm sản phẩm vào giỏ hàng";
            
        }

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_cart"] ) && isset($_SESSION['user'])) {
        // header("Location: index.php?url=gio-hang");
        // Lấy thông tin cần thiết từ form
        $user_id = $_SESSION['user']['id'];
        $product_id = $_POST["product_id"];
        $new_quantity = $_POST["quantity"];
        $index = 0; // Đếm số sản phẩm xóa

        for ($i = 0; $i < count($product_id); $i++) {
            $id = $product_id[$i];
            $quantity = $new_quantity[$i];
            
            if ($quantity <= 0) {
                // Nếu số lượng >=0 xóa sản phẩm trong giỏ hàng     
                $CartModel->delete_product_in_cart($id, $user_id);

                $index += 1;
            } elseif($quantity > 0) {
                $CartModel->update_cart($quantity, $id, $user_id);
                
            }
        }
        
        if ($index > 0) {
            $success = 'Đã xóa ' . $index . ' sản phẩm ra khỏi giỏ hàng';
        } else {
            $success = 'Cập nhật thành công';
        }
    }

    if(isset($_GET['xoa'])) {
        $cart_id = $_GET['xoa'];
        $result = $CartModel->delete_cart_by_id($cart_id);

        $success = 'Đã xóa 1 sản phẩm';
    }
?>


<?php 
    if(isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];
        $list_carts = $CartModel->select_all_carts($user_id);
        $count_carts = count($CartModel->count_cart($user_id));
    }
    
?>

<?php if(isset($_SESSION['user'])) { ?>

<!-- Kiểm tra giỏ hàng có sản phẩm không -->
<?php if(count($list_carts) > 0) { ?>
<!-- Phần hiển thị giỏ hàng -->
<section class="shop-cart spad">
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col-lg-9">
                    <!-- <form action="" method="post"> -->
                    <div class="shop__cart__table">
                        <?=$alert = $BaseModel->alert_error_success($error, $success)?>
                        <table>
                            <thead>
                                <tr>
                                    <th>SẢN PHẨM</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th>TỔNG</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalPayment = 0;
                                    foreach ($list_carts as $value) {
                                        extract($value);
                                        $totalPrice = ($product_price * $product_quantity);
                                        //Tổng thanh toán
                                        $totalPayment += $totalPrice;
                                        // Lấy id danh mục của sản phẩm để hiện thị đường dẫn sang trang ctsp
                                        $product = $ProductModel->select_cate_in_product($product_id);
                
                                    ?>
                                <tr>
                                <td class="cart__product__item">
                                    <a href="chitietsanpham&id_sp=<?=$product_id?>&id_dm=<?=$product['category_id']?>">
                                    <img src="upload/<?=$product_image?>" alt="">
                                     </a>
                                    <div class="cart__product__item__title">
                                    <h6 class="text-truncate-1">
                                    <a href="chitietsanpham&id_sp=<?=$product_id?>&id_dm=<?=$product['category_id']?>" class="text-dark">
                                        <?=$product_name?>
                                    </a>
                                    </h6>
        
                                    <div class="cart__price">
                                        <?=number_format($product_price)?> đ
                                    </div>
                                    <input type="hidden" name="product_id[]" value="<?=$product_id?>">
                                    </div>
                                </td>

                                    <td class="cart__quantity" style="border-radius: 0;">
                                        <div class="input-group float-left" style="border-radius: 0; width: 124px;">
                                            <div class="input-next-cart d-flex" style="border-radius: 0; width: 124px;">
                                                <input type="button" value="-" class="button-minus offset-lg-0" data-field="quantity" style="border-radius: 0;">
                                                <input type="number" readonly step="1" max=""
                                                    value="<?=$product_quantity?>" name="quantity[]"
                                                    class="quantity-field-cart offset-lg-1" style="border-radius: 0;">
                                                <input type="button" value="+" class="button-plus offset-lg-0" data-field="quantity" style="border-radius: 0;">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__total"><?=number_format($totalPrice)?>đ</td>
                                    <td class="cart__close">
                                        <a href="index.php?url=gio-hang&xoa=<?=$cart_id?>">
                                            <span class="icon_close"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                    ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- </form> -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn" style="text-align: left;">
                        <button name="update_cart" type="submit">Cập nhật giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <div class="row">
            <div class="col-lg-2 offset-lg-8" >
                <div class="cart__total__procced" style="margin-top: -360px;">
                    <h6>Tổng tiền</h6>
                    <ul>
                        <li>Số lượng <span><?=$count_carts?> sản phẩm</span></li>
                        <!-- Tổng thanh toán -->
                        <li>Tổng <span><?=number_format($totalPayment)?>đ</span></li>
                    </ul>
                    <a href="index.php?url=thanh-toan" class="primary-btn">THANH TOÁN</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Kết thúc phần hiển thị giỏ hàng -->
<?php }else { ?>
<div class="row" style="margin-bottom: 400px;">
    <div class="col-lg-12 col-md-12">
        <div class="container-fluid mt-5">
            <div class="row rounded justify-content-center mx-0 pt-5">
                <div class="col-md-6 text-center">
                    <h4 class="mb-4">Chưa có sản phẩm nào trong giỏ hàng</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php }else {?>
<div class="row" style="margin-bottom: 400px;">
    <div class="col-lg-12 col-md-12">
        <div class="container-fluid mt-5">
            <div class="row rounded justify-content-center mx-0 pt-5">
                <div class="col-md-6 text-center">
                    <h4 class="mb-4">Vui lòng đăng nhập để có thể mua hàng</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>


<style>
/* Style cho giỏ hàng */
.shop__cart__table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.shop__cart__table table {
    width: 100%;
    border: 1px solid #ddd;
}

.shop__cart__table table th,
.shop__cart__table table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.shop__cart__table table th {
    background-color: #f5f5f5;
    font-weight: bold;
}

.cart__product__item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
}

.cart__product__item__title h6 {
    font-size: 16px;
    margin-bottom: 5px;
}

.cart__product__item__title .cart__price {
    font-size: 14px;
    color: #333;
    margin-top: 5px;
}

.cart__quantity {
    display: flex;
    align-items: center;
    justify-content: center;
}

.cart__quantity .input-group {
    display: flex;
    align-items: center;
}

.cart__quantity input[type="number"] {
    width: 50px;
    padding: 8px;
    text-align: center;
    font-size: 14px;
    border: 1px solid #ddd;
    margin: 0 5px;
}

.cart__quantity .button-minus,
.cart__quantity .button-plus {
    padding: 8px;
    font-size: 16px;
    cursor: pointer;
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    color: #333;
}

.cart__quantity .button-minus:hover,
.cart__quantity .button-plus:hover {
    background-color: #00704A;
    color: white;
    border-color: #00704A;
}

.cart__total {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.cart__close a {
    color: #ff0000;
    font-size: 18px;
    cursor: pointer;
    text-decoration: none;
}

.cart__close a:hover {
    color: #d10000;
}

.shop__cart__table input[type="button"] {
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    padding: 5px 10px;
    font-size: 14px;
    cursor: pointer;
}

.shop__cart__table input[type="button"]:hover {
    background-color: #00704A;
    color: white;
}

.cart__btn button {
    background-color: #00704A;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.cart__btn button:hover {
    background-color: #0a6b38;
}

.cart__total__procced {
    border: 1px solid #ddd;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    margin-top: 20px;
}

.cart__total__procced h6 {
    font-size: 18px;
    font-weight: bold;
}

.cart__total__procced ul {
    list-style: none;
    padding: 0;
}

.cart__total__procced ul li {
    font-size: 16px;
    margin-bottom: 8px;
}

.cart__total__procced a.primary-btn {
    background-color: #00704A;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 4px;
    text-align: center;
    display: block;
    text-decoration: none;
}

.cart__total__procced a.primary-btn:hover {
    background-color: #0a6b38;
}


</style>