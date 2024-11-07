-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 06, 2024 lúc 03:48 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `btl_banquanao`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `image`, `status`) VALUES
(2, 'Áo Thun', 'a1.png', 1),
(4, 'Áo Polo', 'b1.png', 1),
(5, 'Áo sơ mi', 'c3.png', 1),
(6, 'Áo khoác', 'e1.png', 1),
(16, 'Hoodie', 'e3.png', 1),
(17, 'Quần', 'f3.png', 1),
(19, 'Quần nữ', 'g1.png', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 ẩn 1 hiện',
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetails_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`orderdetails_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(5, 96, 39, 1, 176800),
(6, 97, 39, 1, 176800),
(7, 98, 39, 1, 176800);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `total` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `note` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `date`, `total`, `address`, `phone`, `note`, `status`) VALUES
(94, 16, '2024-10-29 08:48:36', 295590, '123 Đường Cầu Giấy, Hà Nội', '0912345670', '', 4),
(95, 16, '2024-10-31 09:18:11', 241812, '123 Đường Cầu Giấy, Hà Nội', '0912345670', '', 1),
(96, 16, '2024-11-05 18:37:28', 176800, '123 Đường Cầu Giấy, Hà Nội', '0912345670', 'ship hàng nhanh', 4),
(97, 20, '2024-11-06 20:43:03', 176800, '202 Đường Láng Hạ, Hà Nội', '0912345674', 'ship về nhà Ly', 4),
(98, 20, '2024-11-06 20:48:59', 176800, '202 Đường Láng Hạ, Hà Nội', '0912345674', 'hello', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sell_quantity` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0,
  `details` text NOT NULL,
  `short_description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `image`, `quantity`, `sell_quantity`, `price`, `sale_price`, `create_date`, `views`, `details`, `short_description`, `status`) VALUES
(36, 2, 'Áo Thun Puppy On Animal Planet TS260', 'a1.png', 66, 4, 533196, 295590, '2024-10-27 15:01:48', 2, '<p>Thông tin sản phẩm:<br>- Chất liệu: Cotton<br>- Form: Oversize<br>- Màu sắc: Đen<br>- Thiết kế: In lụa</p>', '<p>Thông tin sản phẩm:<br>- Chất liệu: Cotton<br>- Form: Oversize<br>- Màu sắc: Đen<br>- Thiết kế: In lụa</p>', 1),
(37, 2, 'Áo Thun Struck by Cupid Tshirt TS273', 'a2.png', 98, 1, 886063, 780632, '2024-10-27 15:02:37', 3, '<p>Thông tin sản phẩm:<br>- Chất liệu: Cotton<br>- Form: Oversize<br>- Màu sắc: Wash<br>- Thiết kế: in lụa</p>', '<p>Thông tin sản phẩm:<br>- Chất liệu: Cotton<br>- Form: Oversize<br>- Màu sắc: Wash<br>- Thiết kế: in lụa</p>', 1),
(38, 2, 'Áo Thun No.27 Baseball Jersey Tshirt TS283', 'a3.png', 71, 4, 856198, 80604, '2024-10-27 15:05:19', 2, '<p>Thông tin sản phẩm:<br>- Chất liệu: Vải thể thao<br>- Form: Oversize<br>- Màu sắc: Đen<br>- Thiết kế: In lụa</p>', '<p>Thông tin sản phẩm:<br>- Chất liệu: Vải thể thao<br>- Form: Oversize<br>- Màu sắc: Đen<br>- Thiết kế: In lụa</p>', 1),
(39, 2, 'Áo Thun N0.19 Jersey Soccer Tshirt TS276', 'a4.png', 77, 3, 582067, 176800, '2024-10-27 15:05:50', 8, '<p>Thông tin sản phẩm:<br>- Chất liệu: Vải thể thao<br>- Form: Oversize<br>- Màu sắc: Đen<br>- Thiết kế: In lụa.</p>', '<p>Thông tin sản phẩm:<br>- Chất liệu: Vải thể thao<br>- Form: Oversize<br>- Màu sắc: Đen<br>- Thiết kế: In lụa.</p>', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL COMMENT 'Tên đăng nhập',
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL COMMENT 'Họ tên',
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 là khách hàng 1 là nhân viên',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `image`, `email`, `phone`, `address`, `role`, `active`) VALUES
(16, 'kh1', '123456', 'Nguyen Van A', 'user-default.png', 'customer1@example.com', '0912345670', '123 Đường Cầu Giấy, Hà Nội', 0, 1),
(17, 'kh2', '123456', 'Tran Thi B', 'user-default.png', 'customer2@example.com', '0912345671', '456 Đường Kim Mã, Hà Nội', 0, 1),
(18, 'kh3', '123456', 'Le Van C', 'user-default.png', 'customer3@example.com', '0912345672', '789 Đường Hoàng Hoa Thám, Hà Nội', 0, 1),
(19, 'kh4', '123456', 'Pham Thi D', 'user-default.png', 'customer4@example.com', '0912345673', '101 Đường Nguyễn Trãi, Hà Nội', 0, 1),
(20, 'kh5', '123456', 'Vo Van E', 'user-default.png', 'customer5@example.com', '0912345674', '202 Đường Láng Hạ, Hà Nội', 0, 1),
(21, 'nv1', '123456', 'Nguyen Van F', 'user-default.png', 'employee1@example.com', '0912345675', '303 Đường Trần Duy Hưng, Hà Nội', 1, 1),
(22, 'nv2', '123456', 'Tran Thi G', 'user-default.png', 'employee2@example.com', '0912345676', '404 Đường Hai Bà Trưng, Hà Nội', 1, 1),
(23, 'nv3', '123456', 'Le Van H', 'user-default.png', 'employee3@example.com', '0912345677', '505 Đường Tây Sơn, Hà Nội', 1, 1),
(24, 'nv4', '123456', 'Pham Thi I', 'user-default.png', 'employee4@example.com', '0912345678', '606 Đường Đội Cấn, Hà Nội', 1, 1),
(25, 'nv5', '123456', 'Vo Van J', 'user-default.png', 'employee5@example.com', '0912345679', '707 Đường Phạm Văn Đồng, Hà Nội', 1, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetails_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetails_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
