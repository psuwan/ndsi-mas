<?php
session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$milNumber = '';

if (empty($_SESSION['userLogin'])) {
    echo "<script>alert('ยังไม่ได้ login เข้าระบบ หรือไม่มีสิทธิ์เข้าหน้านี้');</script>";
    echo "<script>window.location.href='./userLogin.php';</script>";
} else {
    $milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');
//    $userLevel = getValue('mas_users', 'mil_number', $milNumber, 2, 'user_level');

    $queryString = "mil_number='" . $milNumber . "'";
}

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


    <title>MQA - Add User</title>
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

        <h3>เปลี่ยนรหัสผ่านของ : <?= $milNumber; ?></h3>
        <?php
        //include_once './fileSession.php';
        ?>
        <hr>
        <div class="container-fluid">
            <div class="form-group">
                <form action="./fileProcess.php" method="post">
                    <div class="row mt-4">
                        <div class="col-12 col-md-8 col-lg-4">
                            <label for="id4UserName">ชื่อผู้ปฏิบัติงาน : </label>
                            <input class="form-control form-control-sm" type="text" name="milNumber" id="id4UserName"
                                   placeholder="username" readonly value="<?= $milNumber; ?>">
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="row mt-3">
                        <div class="col-12 col-md-8 col-lg-4">
                            <label for="id41stPassword">ตั้งรหัสผ่านใหม่ : </label>
                            <input class="form-control form-control-sm" type="password" name="password"
                                   id="id41stPassword" placeholder="1st-Password" onkeyup="chkPwdMatch()">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-8 col-lg-4">
                            <label for="id42ndPassword">พิมพ์รหัสผ่านอีกครั้ง :&nbsp;</label>
                            <input class="form-control form-control-sm" type="password" name="2ndPassword"
                                   id="id42ndPassword" placeholder="2nd-Password" onkeyup="chkPwdMatch()">
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="row mt-4">
                        <div class="col-12 col-md-8 col-lg-4">
                            <button type="reset" class="btn btn-sm btn-warning">ล้างข้อมูล</button>
                            <button type="submit" class="btn btn-sm btn-success" id="id4btnSubmbit" disabled>บันทึก
                            </button>
                            &nbsp;<span id="id4matchPass"></span>
                        </div>
                    </div>
                    <input type="hidden" name="processName" value="changePwd">
                </form>
            </div>
            <hr>
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
            // $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>


<script>
    let pwd1st = document.getElementById('id41stPassword');
    let pwd2nd = document.getElementById('id42ndPassword');
    let txt2sh = document.getElementById('id4matchPass');
    let chk1stPwd = document.getElementById('check1stPwdOK');
    let chk2ndPwd = document.getElementById('check2ndPwdOK');

    let chkPwdMatch = function () {
        if (pwd1st.value.length < 8) {
            // $('#id4btnSubmbit').addClass('disabled');
            $('#id4matchPass').addClass('text-danger');
            $('#id41stPassword').css({
                "box-shadow": "0 0 0 0.2rem rgba(255, 0, 0, 0.50)"
            });
            txt2sh.innerHTML = '[รหัสผ่าน 8 ตัวอักษรขึ้นไป]';
        } else {
            $('#id41stPassword').css({
                "box-shadow": "0 0 0 0.2rem rgba(40, 167, 69, 0.25)"
            });
            if (pwd1st.value != pwd2nd.value) {
                $('#id42ndPassword').css({
                    "box-shadow": "0 0 0 0.2rem rgba(255, 0, 0, 0.50)"
                });
                // $('#id4btnSubmbit').attr("disabled", true);
                $('#id4matchPass').addClass('text-danger');
                //chk1stPwd.innerHTML = '<i class=\"fas fa-check\"><\/i>'
                txt2sh.innerHTML = '[รหัสผ่านไม่เหมือนกัน]';

            } else {
                $('#id42ndPassword').css({
                    "box-shadow": "0 0 0 0.2rem rgba(40, 167, 69, 0.25)"
                });
                $('#id4btnSubmbit').attr("disabled", false);
                $('#id4matchPass').removeClass('text-danger');
                $('#id4matchPass').addClass('text-success');
                txt2sh.innerHTML = '[รหัสผ่านเหมือนกัน]';
            }
        }
    }
</script>
<!-- password validation form check : https://www.w3schools.com/howto/howto_js_password_validation.asp -->

<!-- javaScript check existing username using "GET" method -->
<script>
    //let userName = document.getElementById('id4UserName');
    let regx = /^[A-Za-z0-9]+$/;
    let chkUsername = function (userName) {
        if (userName != '') {
            if (!isNaN(userName.charAt(0))) {
                $('#id4UserName').css({
                    "box-shadow": "0 0 0 0.2rem rgba(255, 0, 0, 0.50)"
                });
                document.getElementById('id4userText').innerHTML = "ห้ามขึ้นต้นด้วยตัวเลข";
            } else {
                if (regx.test(userName)) {
                    if ((userName.length < 13) || (userName.indexOf(' ') > -1)) {
                        $('#id4UserName').css({
                            "box-shadow": "0 0 0 0.2rem rgba(255, 0, 0, 0.50)"
                        });
                        document.getElementById('id4userText').innerHTML = "username เป็นภาษาอังกฤษ 13 ตัวขึ้นไป";
                    } else {
                        document.getElementById('id4userText').innerHTML = "";
                        chkExisting(userName);
                    }
                } else {
                    document.getElementById('id4userText').innerHTML = "username เป็นภาษาอังกฤษเท่านั้น และไม่มีเว้นวรรค";
                }
            }
        } else {
            document.getElementById('id4userText').innerHTML = "username ห้ามว่าง";
        }
    }

    function chkExisting(userName) {
        if (userName != "") {
            queryData("chkExisting.php?tblName=tbl_users&colName=user_name&val2Chk=" + userName);
            {
                if (xhr_object.responseText == 1) {
                    $('#id4UserName').css({
                        "box-shadow": "0 0 0 0.2rem rgba(255, 0, 0, 0.50)"
                    });
                    document.getElementById('id4userText').innerHTML = "username ซ้ำ!!! ใช้ไม่ได้";
                } else {
                    $('#id4UserName').css({
                        "box-shadow": "0 0 0 0.2rem rgba(40, 167, 69, 0.25)"
                    });
                }
            }
        }
    }

    function queryData(URL) {
        if (window.XMLHttpRequest) {
            xhr_object = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            return false;
        }

        xhr_object.open("GET", URL, false);
        xhr_object.send(null);

        if (xhr_object.readyState == 4) {
            return xhr_object.responseText;
        } else {
            return false;
        }
    }

    function Validate() {
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/

        //Validate TextBox value against the Regex.
        var isValid = regex.test(document.getElementById("txtName").value);
        if (!isValid) {
            alert("Only Alphabets and Numbers allowed.");
        }

        return isValid;
    }
</script>

</body>
</html>