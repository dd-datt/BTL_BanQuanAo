<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <!-- Thêm các thư viện CSS cần thiết, ví dụ Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .spad {
            padding: 40px 0;
        }

        .site-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .site-btn:hover {
            background-color: #0056b3;
        }

        .contact__address ul {
            list-style: none;
            padding: 0;
        }

        .contact__map iframe {
            width: 100%;
            height: 450px;
            border: 0;
        }
    </style>
</head>

<body>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__content">
                        <div class="contact__address">
                            <h5>THÔNG TIN LIÊN LẠC</h5>
                            <ul>
                                <li>
                                    <h6>Địa chỉ</h6>
                                    <p>41A Đ. Phú Diễn, Phú Diễn, Bắc Từ Liêm, Hà Nội, Việt Nam</p>
                                </li>
                                <li>
                                    <h6>Số điện thoại</h6>
                                    <p><span>0123456789</span></p>
                                </li>
                                <li>
                                    <h6>Hỗ trợ</h6>
                                    <p>hunre@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="contact__form">
                            <h5>GỬI TIN NHẮN</h5>
                            <form action="send_message.php" method="POST">
                                <input type="text" name="name" placeholder="Họ tên" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <textarea name="message" placeholder="Tin nhắn" required></textarea>
                                <button type="submit" class="site-btn">GỬI TIN NHẮN</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.640930538256!2d105.75986217486307!3d21.047048580606894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454c3ce577141%3A0xb1a1ac92701777bc!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBUw6BpIG5ndXnDqm4gdsOgIE3DtGkgdHLGsOG7nW5nIEjDoCBO4buZaQ!5e0!3m2!1svi!2s!4v1731317037889!5m2!1svi!2s"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Thêm các thư viện JS cần thiết, ví dụ jQuery và Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>