<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">`

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="public_admin/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="public_admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="public_admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="public_admin/css/style.css" rel="stylesheet">
</head>

<?php
ob_start();
session_start();
require_once "models_admin/pdo_library.php";
require_once "models_admin/BaseModel.php";
require_once "models_admin/CustomerModel.php";

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $user = $CustomerModel->get_user_admin($username);

        if ($user && isset($user[0]['password'])) {
            if ($user[0]['active'] != 1) {
                $error = 'Tài khoản đã bị khóa';
            } else {
                // Kiểm tra mật khẩu trực tiếp
                if ($password == $user[0]['password']) {
                    // Lưu thông tin đăng nhập vào Session
                    $_SESSION['user_admin']['id'] = $user[0]['user_id'];
                    $_SESSION['user_admin']['username'] = $user[0]['username'];
                    $_SESSION['user_admin']['full_name'] = $user[0]['full_name'];
                    $_SESSION['user_admin']['image'] = $user[0]['image'];
                    $_SESSION['user_admin']['email'] = $user[0]['email'];
                    $_SESSION['user_admin']['phone'] = $user[0]['phone'];
                    $_SESSION['user_admin']['address'] = $user[0]['address'];

                    header("Location: index.php");
                    exit();
                } else {
                    $error = 'Sai tên tài khoản hoặc mật khẩu';
                }
            }
        }
    }
}

$html_alert = $BaseModel->alert_error_success($error, '');
?>


    /* Css của admin */
    <!-- Your custom CSS -->
    <style>
        /* http://meyerweb.com/eric/tools/css/reset/ 
           v2.0 | 20110126
           License: none (public domain)
        */

        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed, 
        figure, figcaption, footer, header, hgroup, 
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure, 
        footer, header, hgroup, menu, nav, section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol, ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        h3{
            color:white;
            font-size: 40px;
           

        }

        *{
           box-sizing: border-box;
        }

        html{
           width: 100%;
           height: 100%;
           font-family: 'Font Awesome 5 Freef';
        }

        body{
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .overlay{
            width: 170%;
            height: 170%;
            position: absolute;
            background-image: url('anh1.jpg');
            filter: blur(13px);
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 2;
        }

        .login-container{
            position: relative;
            width: 1090px;
            z-index: 3;
            height: 580px;
            background-image: url('anh1.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: space-between;
            padding-left: 100px;
            color: white;
            font-weight: 300;
        }

        .login-container>div:first-child{
            max-width: 400px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 100px 0;
            padding-bottom: 70px;
        }

        .logo span{
            font-family: 'Font Awesome 5 Freef';
            font-size: 50px;
        }

        .logo i{
            color:rgb(255, 255, 255);
            font-size: 40px;
        }

       /* viền khung mở chỗ nhập */

        .form-login{
            width: 45%;
            max-width: 48%;
            height: 100%;
            backdrop-filter: blur(8px);
            background-color: rgba(54, 52, 52, 0.2);
            padding: 100px 40px;
            
        }

        .form-login .form-group{
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-top: 40px;
        }

        .form-login .form-group input{
            background-color: transparent;
            outline: none;
            border: none;
            border-bottom: 1px solid rgba(159, 171, 175, 0.534);
            margin-top: 10px;
            color: white;
            font-size: 17px;
        }

        .form-login .form .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.658);
            opacity: 1;
        }

        .form-login .form .heading{
            font-size: 30px;
            margin-top: 7px;

           
        }

        .form-login .form .sign-up{
            margin-top: 50px;
            display: flex;
            align-items: center;
        }

        .form-login .form .sign-up button{
            background-color: rgb(211, 37, 37);
            color: rgb(238, 227, 227);
            width: 160px;
            height: 35px;
            border: none;
            outline: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            padding-left: 25px;
        }

        .form-login .form .sign-up button:hover{
            background-color: rgb(143, 24, 24);
            cursor: pointer;
        }

        .form-login .form .sign-up>div i{
            position: absolute;
            top: 50%;
            right: 7%;
            transform: translateY(-50%);
            font-size: 12px;
        }

        
        label.form-label { /* ten đn, mật khẩu */
        font-size: 20px;
         }

        .sign-up a{
            margin-left: 35px;
            color: rgb(190, 189, 187);
            font-size: 140px;
            text-underline-position: under;
        }

        .sign-up a:hover{
            color: red;
        }
        button {
            width: 100%;
            height: 50%;
           padding:20px;
            border-radius:20px;
            background-color: white;
            transition: background-color 0.3s ease, transform 0.3s ease;
           
        }
         button:hover {
        background-color: #696969;
        transform: translateY(-2px);
    }

    button .active {
        background-color: #8f4c8a;
    }

  
    </style>
</head>
<body>
<div class="overlay"></div>
    <div class="login-container">
        <div>
          
           
        </div>

        <div class="form-login">
            <form action="" method="post">
                <h3 class="heading">Đăng nhập Admin</h3>      
                <div class="form-group">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input id="username" name="username" type="text" placeholder="Tên đăng nhập" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="password" name="password" type="password" placeholder="Mật khẩu" class="form-control" required>
                </div>
                <br>
                <br>

                <button type="submit" name="login" class="form-submit">Đăng nhập</button>
            </form>
        </div>
    </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public_admin/lib/chart/chart.min.js"></script>
    <script src="public_admin/lib/easing/easing.min.js"></script>
    <script src="public_admin/lib/waypoints/waypoints.min.js"></script>
    <script src="public_admin/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="public_admin/lib/tempusdominus/js/moment.min.js"></script>
    <script src="public_admin/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="public_admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="public_admin/js/main.js"></script>
    
</body>

</html>

<?php
ob_end_flush();
?>