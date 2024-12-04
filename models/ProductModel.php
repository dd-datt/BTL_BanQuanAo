<?php

/**
 * Class ProductModel - Quản lý các thao tác với bảng products trong database
 */
class ProductModel
{
    /**
     * Lấy danh sách sản phẩm có giới hạn
     * @param int $limit Số lượng sản phẩm muốn lấy
     * @return array Danh sách sản phẩm
     */
    public function select_products_limit($limit)
    {
        $sql = "SELECT * FROM products 
                WHERE status = 1 
                ORDER BY product_id DESC 
                LIMIT $limit";
        return pdo_query($sql);
    }

    /**
     * Lấy thông tin sản phẩm theo ID
     * @param int $id ID của sản phẩm
     * @return array Thông tin sản phẩm
     */
    public function select_products_by_id($id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        return pdo_query_one($sql, $id);
    }

    /**
     * Lấy danh sách sản phẩm có sắp xếp và giới hạn
     * @param int $limit Số lượng sản phẩm muốn lấy
     * @param string $order_by Kiểu sắp xếp (ASC/DESC)
     * @return array Danh sách sản phẩm
     */
    public function select_products_order_by($limit, $order_by)
    {
        $sql = "SELECT * FROM products 
                WHERE status = 1 
                ORDER BY product_id $order_by 
                LIMIT $limit";
        return pdo_query($sql);
    }

    /**
     * Lấy category_id của sản phẩm
     * @param int $product_id ID của sản phẩm
     * @return array Category ID
     */
    public function select_cate_in_product($product_id)
    {
        $sql = "SELECT category_id FROM products WHERE product_id = ?";
        return pdo_query_one($sql, $product_id);
    }

    /**
     * Lấy các sản phẩm tương tự
     * @param int $id Category ID
     * @return array Danh sách sản phẩm tương tự
     */
    public function select_products_similar($id)
    {
        $sql = "SELECT * FROM products 
                WHERE category_id = ? 
                ORDER BY product_id 
                LIMIT 4";
        return pdo_query($sql, $id);
    }

    /**
     * Tìm kiếm sản phẩm theo tên
     * @param string $query Từ khóa tìm kiếm
     * @return array Danh sách sản phẩm
     */
    public function search_products($query)
    {
        $sql = "SELECT * FROM products WHERE name LIKE '%$query%'";
        return pdo_query($sql);
    }

    /**
     * Tìm kiếm sản phẩm theo khoảng giá
     * @param float $from_price Giá từ
     * @param float $to_price Giá đến
     * @return array Danh sách sản phẩm
     */
    public function search_products_by_price($from_price, $to_price)
    {
        $sql = "SELECT * FROM products 
                WHERE sale_price 
                BETWEEN '$from_price' AND '$to_price'";
        return pdo_query($sql);
    }

    /**
     * Lấy giá thấp nhất và cao nhất của sản phẩm
     * @return array Min và max price
     */
    public function get_min_max_prices()
    {
        $sql = "SELECT MIN(sale_price) AS min_price, 
                       MAX(sale_price) AS max_price 
                FROM products 
                WHERE status = 1";
        return pdo_query_one($sql);
    }

    /**
     * Lấy tất cả sản phẩm
     * @return array Danh sách sản phẩm
     */
    public function select_all_products()
    {
        $sql = "SELECT * FROM products 
                WHERE status = 1 
                ORDER BY product_id DESC";
        return pdo_query($sql);
    }

    /**
     * Lấy sản phẩm theo danh mục
     * @param int $category_id ID của danh mục
     * @return array Danh sách sản phẩm
     */
    public function select_products_by_cate($category_id)
    {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        return pdo_query($sql, $category_id);
    }

    /**
     * Lấy danh sách sản phẩm theo trang
     * @param int $page Trang hiện tại
     * @param int $perPage Số sản phẩm trên một trang
     * @return array Danh sách sản phẩm
     */
    public function select_list_products($page, $perPage)
    {
        // Tính vị trí bắt đầu
        $start = ($page - 1) * $perPage;

        $sql = "SELECT * FROM products 
                WHERE status = 1 
                ORDER BY product_id DESC 
                LIMIT $start, $perPage";

        return pdo_query($sql);
    }

    /**
     * Đếm tổng số sản phẩm
     * @return array Số lượng sản phẩm
     */
    public function count_products()
    {
        $sql = "SELECT product_id FROM products";
        return pdo_query($sql);
    }

    /**
     * Tính phần trăm giảm giá
     * @param float $price Giá gốc
     * @param float $sale_price Giá khuyến mãi
     * @return string Phần trăm giảm giá
     */
    public function discount_percentage($price, $sale_price)
    {
        $discount_percentage = ($price - $sale_price) / $price * 100;
        return round($discount_percentage, 0) . "%";
    }

    /**
     * Format giá tiền theo định dạng Việt Nam
     * @param float $price Giá tiền
     * @return string Giá tiền đã format
     */
    public function formatted_price($price)
    {
        return number_format($price, 0, ',', '.') . 'đ';
    }

    /**
     * Cập nhật lượt xem sản phẩm
     * @param int $product_id ID sản phẩm
     */
    public function update_views($product_id)
    {
        $sql = "UPDATE products 
                SET views = views + 1 
                WHERE product_id = ?";
        pdo_execute($sql, $product_id);
    }

    /**
     * Cập nhật số lượng sản phẩm sau khi mua
     * @param int $product_id ID sản phẩm
     * @param int $quantity Số lượng mua
     */
    public function update_quantity_product($product_id, $quantity)
    {
        $sql = "UPDATE products 
                SET quantity = quantity - ? 
                WHERE product_id = ?";
        pdo_execute($sql, $quantity, $product_id);
    }

    /**
     * Cập nhật số lượng đã bán của sản phẩm
     * @param int $product_id ID sản phẩm
     * @param int $quantity Số lượng bán
     */
    public function update_sell_quantity_product($product_id, $quantity)
    {
        $sql = "UPDATE products 
                SET sell_quantity = sell_quantity + ? 
                WHERE product_id = ?";
        pdo_execute($sql, $quantity, $product_id);
    }
}

// Khởi tạo đối tượng ProductModel
$ProductModel = new ProductModel();
