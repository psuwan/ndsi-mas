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


    <title>MAS - Register</title>
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
            <h3 class="text-center text-info">ลงทะเบียนเข้าใช้งาน</h3>
            <div class="container mt-5">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6 col-10 col-lg-6 col-xl-4">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="./fileProcess.php" method="post">

                                <div class="form-group">
                                    <label for="id4MilNumber" class="text-info">เลขทหาร :</label><br>
                                    <input type="text" name="milNumber" id="id4MilNumber" pattern="[0-9]+"
                                           class="form-control-sm form-control">
                                    <span id="id4MilNumChk"></span>
                                </div>

                                <div class="form-group">
                                    <label for="id4Password" class="text-info">รหัสผ่าน :</label><br>
                                    <input type="password" name="password" id="id4Password"
                                           class="form-control form-control-sm">
                                    <span id="id4ChkPass"></span>
                                </div>

                                <div class="form-group">
                                    <label for="id4RePassword" class="text-info">รหัสผ่าน (ซ้ำ) :</label><br>
                                    <input type="password" name="rePassword" id="id4RePassword"
                                           class="form-control form-control-sm" required>
                                    <span id="id4ChkPassRe"></span>
                                </div>

                                <div class="form-group text-center mt-5">
                                    <button type="reset" class="btn btn-sm btn-warning">ล้างข้อมูล</button>
                                    <button type="submit" class="btn btn-sm btn-success" id="id4BtnSave" disabled>
                                        บันทึก
                                    </button>
                                </div>
                                <!--<div id="register-link" class="text-right">
                                    <a href="#" class="text-info">Register here</a>
                                </div>-->
                                <input type="hidden" name="processName" value="userRegister">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popper and Bootstrap JS -->
<!--<script src="./js/jquery-3.5.1.slim.min.js"></script>-->
<script src="./js/jquery-3.6.0.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Project script -->
<!--<script src="./js/prjScript.js"></script>-->

<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            // $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>

<script>
    let milNumber = document.getElementById("id4MilNumber");
    let usrPasswd = document.getElementById("id4Password");
    let usrPassre = document.getElementById("id4RePassword");
    let chkPasswd = document.getElementById("id4ChkPass");

    // check mil-number existing
    // let milNumExisting = function (){
    $("#id4MilNumber").on("keyup change", function () {
        if (milNumber.value.length < 10) {
            $("#id4Password").attr("disabled", true);
            $("#id4RePassword").attr("disabled", true);
        } else {
            $("#id4Password").attr("disabled", false);
            $("#id4RePassword").attr("disabled", false);
        }
        $.ajax({
            url: 'fileProcess.php',
            type: 'POST',
            data: {
                processName: "checkMilNumber",
                milNum2Chk: milNumber.value
            },
            success: function (response) {
                if (response == '1') {
                    $("#id4MilNumChk").addClass("text-danger")
                    $("#id4MilNumChk").text("เลขทหารนี้ลงทะบียนแล้ว");
                    // $("#id4BtnSave").attr("disabled", true);
                } else {
                    $("#id4MilNumChk").text("");
                    // $("#id4BtnSave").attr("disabled", false);
                }
            }
        });
    });

    // check password length more than 8 characters
    $("#id4Password").on("keyup change", function () {
        if (usrPasswd.value.length < 8) {
            $("#id4Password").removeClass("border-success");
            $("#id4Password").addClass("border-danger shadow-lg");
            // $("#id4BtnSave").attr("disabled", true);
            $("#id4ChkPass").addClass("text-danger");
            $("#id4ChkPass").text("รหัสผ่านต้องมากกว่า 8 ตัวอักษร");
        } else {
            $("#id4Password").removeClass("border-danger");
            $("#id4Password").addClass("border-success shadow-lg");
            // $("#id4BtnSave").attr("disabled", false);
            $("#id4ChkPass").text("");
        }
    });

    $("#id4RePassword").on("keyup change", function () {
        if (usrPassre.value.length < 8) {
            $("#id4RePassword").removeClass("border-success");
            $("#id4RePassword").addClass("border-danger shadow-lg");
            $("#id4BtnSave").attr("disabled", true);
            $("#id4ChkPassRe").addClass("text-danger");
            $("#id4ChkPassRe").text("รหัสผ่านไม่เหมือนกัน");
        } else {
            $("#id4RePassword").removeClass("border-danger");
            $("#id4RePassword").addClass("border-success shadow-lg");
            if (usrPassre.value === usrPasswd.value) {
                $("#id4BtnSave").attr("disabled", false);
                $("#id4ChkPassRe").text("");
            } else {
                $("#id4BtnSave").attr("disabled", true);
                $("#id4ChkPassRe").addClass("text-danger");
                $("#id4ChkPassRe").text("รหัสผ่านไม่เหมือนกัน");
            }
        }
    });

</script>


</body>
</html>