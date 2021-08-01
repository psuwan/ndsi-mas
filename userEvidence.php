<?php
session_start();
include_once './lib/apksFunctions.php';

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');
$asNext = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_asnext');
if (!empty($asNext)) {
    header('location:./userMgrEvd.php?evd2Upload=' . $asNext);
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


    <title>MQA - Index</title>
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
        <div class="row mt-3">
            <div class="col-md-8 offset-md-2 d-flex justify-content-center">

                <div class="card shadow-lg pt-5 pb-5" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-12"><h5 class="card-title h4">ข้อมูลหลักฐานที่ใช้ประกอบการขอมี
                                    หรือขอเลื่อนวิทยฐานะ</h5></div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-6 offset-3">
                                <label class="h4" for="id4ASLevel">ต้องการเพิ่มข้อมูลสำหรับวิทยฐานะระดับ</label>
                                <select class="form-control form-control-sm" name="" id="id4ASLevel" required
                                        onchange="asLevelGo(this.value);">
                                    <option value="">เลือกระดับวิทยฐานะ</option>
                                    <option value="1">ครูชำนาญการต้น</option>
                                    <option value="2">ครูชำนาญการ (ครูทหาร)</option>
                                    <option value="3">ครูชำนาญการ (ครูวิชาการ)</option>
                                    <option value="4">ครูชำนาญการพิเศษ</option>
                                </select>
                            </div>
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
            // $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>

<script>
    let asLevelGo = function (asLevel) {
        switch (asLevel) {
            case '1':
                window.location.href = 'userMgrEvd.php?evd2Upload=' + asLevel;
                break;
            case '2':
                window.location.href = 'userMgrEvd.php?evd2Upload=' + asLevel;
                break;
            case '3':
                window.location.href = 'userMgrEvd.php?evd2Upload=' + asLevel;
                break;
            case '4':
                window.location.href = 'userMgrEvd.php?evd2Upload=' + asLevel;
                break;
        }
    }
</script>

</body>
</html>