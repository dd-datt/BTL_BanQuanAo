<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $order_id = $_GET['id'];
} else {
    echo "ID đơn hàng không hợp lệ.";
    exit; // Dừng thực thi nếu ID không hợp lệ
}

$order_details = $OrderModel->getFullOrderInformation($order_id);
if (!$order_details) {
    echo "Không tìm thấy thông tin đơn hàng.";
    exit; // Dừng thực thi nếu không tìm thấy thông tin đơn hàng
}

foreach ($order_details as $value) {
    extract($value);
}

// Định dạng lại thời gian
$date_formated = date('d/m/Y H:i:s', strtotime($order_date)); // Định dạng ngày
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <style>
        /* Toàn bộ trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        /* Khung chứa hóa đơn */
        .invoice-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
        }

        /* Tiêu đề và logo */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.2em;
            font-weight: bold;
        }

        /* Phân cách tiêu đề mỗi mục */
        .section-title {
            font-size: 1.1em;
            font-weight: bold;
            border-bottom: 2px solid #000;
            margin-top: 20px;
            padding-bottom: 5px;
        }

        /* Khu vực thông tin */
        .info-section p {
            margin: 5px 0;
            font-size: 0.95em;
        }

        /* Bảng thông tin sản phẩm */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 0.95em;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        /* Mã QR */
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        /* Tổng tiền */
        .total-section {
            text-align: right;
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 10px;
        }
        
        .print-btn {
            margin: 20px auto;
            display: block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .print-btn:hover {
            background-color: #45a049;
        }
        @media print {
    /* Ẩn tất cả nội dung ngoài khung hóa đơn */
    body * {
        visibility: hidden;
    }

    /* Chỉ hiển thị nội dung bên trong khung hóa đơn */
    .invoice-container, .invoice-container * {
        visibility: visible;
    }

    /* Đảm bảo chỉ in khung hóa đơn */
    .invoice-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
    
    /* Ẩn nút in */
    .print-btn {
        display: none;
    }
}
    </style>
</head>
<body>

    <div class="invoice-container">
        <!-- Thông tin Shopee -->
        <div class="info-section">
            <p><strong>Mã vận đơn:</strong> SPXVN020737518414</p>
            <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($order_id) ?></p>
        </div>

        <!-- Thông tin người gửi (Shopee) -->
        <div class="section-title">Thông Tin Người Gửi</div>
        <div class="info-section">
            <p><strong>Tên:</strong> FASHION STORE</p>
            <p><strong>Địa chỉ:</strong>41A, Đường Phú Diễn , Quận Bắc từ Liêm, Thành phố Hà Nội</p>
            <p><strong>SĐT:</strong> 84982811660</p>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="section-title">Thông Tin Khách Hàng</div>
        <div class="info-section">
            <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($full_name) ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order_phone) ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order_address) ?></p>
            <p><strong>Thời gian:</strong> <?= $date_formated ?></p>
            <p><strong>Tổng tiền hàng:</strong> <?= number_format($total) ?>₫</p>
            <p><strong>Phí vận chuyển:</strong> Miễn phí</p>
            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($note) ?></p>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="section-title">Thông Tin Sản Phẩm</div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Nội dung hàng</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($order_details)) {
                    foreach ($order_details as $item) {
                        echo "
                        <tr>
                            <td>" . htmlspecialchars($item['product_name']) . "</td>
                            <td>" . htmlspecialchars($item['quantity']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Không có sản phẩm</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Mã QR -->
        <div class="qr-code">
            <img src="../upload/qrcode.png" alt="QR Code" width="80">
        </div>

        <!-- Tổng tiền -->
        <div class="total-section">
            <p><strong>Tổng tiền:</strong> <?= number_format($total) ?>₫</p>
        </div>

        <!-- Ghi chú -->
        <div class="note">
            <p>Kiểm tra mã vận đơn và đơn hàng trước khi nhận.</p>
            <p>Tuyển dụng Tài xế/Điều phối kho SPX - Thu nhập 8-20 triệu - Gọi 1900 6885</p>
        </div>

        <!-- Nút in hóa đơn -->
        <button class="print-btn" onclick="window.print()">In hóa đơn</button>
    </div>

</body>
</html>
