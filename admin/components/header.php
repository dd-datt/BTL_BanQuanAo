<body>


    <div class="container-xxl position-relative bg-white d-flex p-0">



        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i></i>FASHION STORE</h3>
                </a>

                <div class="navbar-nav w-100">
                    <!-- <a href="index.php" class="nav-item nav-link active"><i
                            class="fa fa-tachometer-alt me-2"></i>Dashboard</a> -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-shopping-basket me-2"></i>Đơn hàng</a>
                        <div class="dropdown-menu bg-transparent border-0">

                            <a href="index.php?quanli=danh-sach-don-hang" class="dropdown-item">Tất cả đơn hàng</a>
                            <a href="danh-sach-don-cho" class="dropdown-item">Đơn chờ xác nhận</a>

                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown"><i
                                class="fa fa-th me-2"></i>Danh mục</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="index.php?quanli=them-danh-muc" class="dropdown-item">Thêm mới</a>
                            <a href="index.php?quanli=danh-sach-danh-muc" class="dropdown-item">Tất cả</a>

                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fas fa-box me-2"></i>Sản phẩm</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="index.php?quanli=them-san-pham" class="dropdown-item">Thêm mới</a>
                            <a href="index.php?quanli=danh-sach-san-pham" class="dropdown-item">Tất cả</a>

                        </div>
                    </div>


                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fas fa-chart-bar me-2"></i> Thống kê</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="thong-ke-san-pham" class="dropdown-item">Sản phẩm - danh mục</a>
                            <a href="thong-ke-don-hang" class="dropdown-item">Đơn hàng</a>
                        </div>
                    </div>



                    <a href="index.php?quanli=danh-sach-khach-hang" class="nav-item nav-link"><i
                            class="fas fa-users me-2"></i>Khách hàng</a>

                    <a href="index.php?quanli=danh-sach-khach-hang" class="nav-item nav-link"><i
                            class="fas fa-users me-2"></i>Nhân viên</a>


                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">


                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle me-lg-2"
                                src="<?= isset($_SESSION['user']['image']) && !empty($_SESSION['user']['image']) ? '../upload/' . $_SESSION['user']['image'] : 'public_admin/img/user-default.png' ?>"
                                alt="User Image"
                                style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?= isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : 'ADMIN' ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-white border-1 rounded-0 rounded-bottom m-0">
                            <a href="../index.php" class="dropdown-item">Trang khách hàng</a>
                            <a href="index.php?quanli=dang-xuat" class="dropdown-item">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Content start -->