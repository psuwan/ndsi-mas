<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap 4.6.x -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <!-- Project stylesheet -->
    <link rel="stylesheet" href="./css/prjStyle.css">
    <link rel="stylesheet" href="./css/font.css"><!-- Our Custom CSS -->

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="./css/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="./css/all.css">


    <title>MAS - Login</title>
</head>
<body>
<div class="wrapper">
    <?php
    include_once './fileSidebar.php';
    ?>

    <!-- Page Content  -->
    <div id="content">

        <?php
        include_once './fileNavbar.php';
        ?>

        <div id="login">
            <!--            <h3 class="text-center text-dark pt-5">Login form</h3>-->
            <h3 class="text-center text-info">ผู้ใช้งานเข้าสู่ระบบ</h3>
            <div class="container mt-5">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6 col-10 col-lg-6 col-xl-4">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="./fileProcess.php" method="post">
                                <div class="form-group">
                                    <label for="id4MilNumber" class="text-info">ชื่อเข้าใช้งาน:</label><br>
                                    <input type="text" name="milNumber" id="id4MilNumber"
                                           class="form-control-sm form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password" class="text-info">รหัสผ่าน:</label><br>
                                    <input type="password" name="password" id="password"
                                           class="form-control form-control-sm">
                                </div>

                                <div class="form-group text-center mt-5">
                                    <button type="reset" class="btn btn-sm btn-warning">ล้างข้อมูล</button>
                                    <button type="submit" class="btn btn-sm btn-success">เข้าสู่ระบบ</button>
                                </div>
                                <!--<div id="register-link" class="text-right">
                                    <a href="#" class="text-info">Register here</a>
                                </div>-->
                                <input type="hidden" name="processName" value="userLogin">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popper and Bootstrap JS -->
<script src="./js/jquery-3.5.1.slim.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Project script -->
<script src="./js/prjScript.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>


</body>
</html>