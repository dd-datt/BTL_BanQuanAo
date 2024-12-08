<?php
class ProductModel
{
    // Thêm sản phẩm mới vào cơ sở dữ liệu
    public function insert_product($category_id, $name, $image, $quantity, $price, $sale_price, $details, $short_description)
    {
        // Câu lệnh SQL để chèn sản phẩm mới
        $sql = "INSERT INTO products 
            (category_id, name, image, quantity, price, sale_price, details, short_description)
            VALUES (?,?,?,?,?,?,?,?)";

        // Thực thi câu lệnh SQL với các tham số
        pdo_execute($sql, $category_id, $name, $image, $quantity, $price, $sale_price, $details, $short_description);
    }

    // Lấy danh sách sản phẩm đang hoạt động
    public function select_products()
    {
        $sql = "SELECT name FROM products WHERE status = 1";

        // Trả về danh sách tên sản phẩm
        return pdo_query($sql);
    }

    // Cập nhật trạng thái sản phẩm thành không hoạt động (inactive)
    public function update_product_not_active($product_id)
    {
        $sql = "UPDATE products SET status = 0 WHERE product_id = ?";

        // Thực thi câu lệnh SQL
        pdo_execute($sql, $product_id);
    }

    // Cập nhật trạng thái sản phẩm thành hoạt động (active)
    public function update_product_active($product_id)
    {
        $sql = "UPDATE products SET status = 1 WHERE product_id = ?";

        // Thực thi câu lệnh SQL
        pdo_execute($sql, $product_id);
    }

    // Lấy danh sách sản phẩm theo từ khóa, danh mục, và phân trang
    function select_list_products($keyword, $id_danhmuc, $page, $perPage)
    {
        // Tính toán vị trí bắt đầu của kết quả trên trang hiện tại
        $start = ($page - 1) * $perPage;

        // Khởi tạo câu truy vấn SQL
        $sql = "SELECT * FROM products WHERE 1";

        // Thêm điều kiện tìm kiếm theo từ khóa
        if ($keyword != '') {
            $sql .= " AND name LIKE '%" . $keyword . "%'";
        }

        // Thêm điều kiện tìm kiếm theo danh mục
        if ($id_danhmuc > 0) {
            $sql .= " AND category_id ='" . $id_danhmuc . "'";
        }

        // Chỉ lấy sản phẩm đang hoạt động và sắp xếp theo ID giảm dần
        $sql .= " AND status = 1 ORDER BY product_id DESC";

        // Thêm điều kiện phân trang
        $sql .= " LIMIT " . $start . ", " . $perPage;

        // Trả về danh sách sản phẩm
        return pdo_query($sql);
    }

    // Lấy danh sách sản phẩm đã bị xóa (trạng thái = 0)
    public function select_recycle_products()
    {
        $sql = "SELECT * FROM products WHERE status = 0 ORDER BY product_id DESC";

        // Trả về danh sách sản phẩm
        return pdo_query($sql);
    }

    // Lấy chi tiết sản phẩm theo ID
    public function select_product_by_id($product_id)
    {
        $sql = "SELECT * FROM products WHERE product_id =?";

        // Trả về chi tiết sản phẩm
        return pdo_query_one($sql, $product_id);
    }

    // Tính phần trăm giảm giá giữa giá gốc và giá khuyến mãi
    public function discount_percentage($price, $sale_price)
    {
        $discount_percentage = ($price - $sale_price) / $price * 100;

        // Làm tròn phần trăm giảm giá và thêm ký hiệu %
        $round__percentage = round($discount_percentage, 0) . "%";
        return $round__percentage;
    }

    // Định dạng giá tiền thành chuỗi có dấu phân cách và đơn vị tiền tệ
    public function formatted_price($price)
    {
        $format = number_format($price, 0, ',', '.') . 'đ';
        return $format;
    }

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    public function delete_product($product_id)
    {
        $sql = "DELETE FROM products WHERE product_id = ?";
        pdo_execute($sql, $product_id);
    }

    // Cập nhật thông tin sản phẩm
    public function update_product($category_id, $name, $image, $quantity, $price, $sale_price, $details, $short_description, $product_id)
    {
        // Khởi tạo câu lệnh SQL cập nhật
        $sql = "UPDATE products SET 
            category_id = '" . $category_id . "', 
            name = '" . $name . "',";

        // Nếu có hình ảnh mới, cập nhật hình ảnh
        if ($image != '') {
            $sql .= " image = '" . $image . "',";
        }

        // Cập nhật các thông tin khác của sản phẩm
        $sql .= " quantity = '" . $quantity . "', 
                    price = '" . $price . "', 
                    sale_price = '" . $sale_price . "', 
                    details = '" . $details . "', 
                    short_description = '" . $short_description . "' 
                    WHERE product_id = " . $product_id;

        // Thực thi câu lệnh SQL
        pdo_execute($sql);
    }
}

// Tạo một đối tượng ProductModel
$ProductModel = new ProductModel();
