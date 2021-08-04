<?php
session_start();
include_once './lib/apksFunctions.php';

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');
$asNext = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_asnext');
$asDate = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnext');
if (!empty($asNext) && !empty($asDate)) {
    header('location:./userProfile.php?asNext=' . $asNext);
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


    <title>MAS - MAS REQUEST BEGIN</title>
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

                <div class="card shadow-lg pt-3 pb-5" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-8 offset-2"><h5 class="card-title h4">ต้องการมี
                                    หรือขอเลื่อนวิทยฐานะเป็น</h5></div>
                        </div>

                        <form action="./userBeginAct.php" method="post">

                            <div class="row mt-0">

                                <div class="col-4 offset-2">
                                    <label class="" for="id4levelASNext">&nbsp;</label>
                                    <select class="form-control form-control-sm" name="levelASNext" id="id4levelASNext" required>
                                        <option value="">เลือกระดับวิทยฐานะ</option>
                                        <option value="1">ครูชำนาญการต้น</option>
                                        <option value="2">ครูชำนาญการ (ครูทหาร)</option>
                                        <option value="3">ครูชำนาญการ (ครูวิชาการ)</option>
                                        <option value="4">ครูชำนาญการพิเศษ</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="id4DateASNext">วันที่ขอมี / เลื่อนวิทยฐานะ</label>
                                    <input type="text" name="dateASNext" id="id4DateASNext"
                                           class="form-control form-control-sm"><span id="id4ChkASDateVal"></span>
                                </div>

                            </div>

                            <div class="row mt-5">
                                <div class="col-8 offset-2 text-center">
                                    <button type="reset" class="btn btn-sm btn-warning">ล้างข้อมูล</button>
                                    <button type="submit" class="btn btn-sm btn-success" id="id4BtnSubmit">
                                        บันทึก
                                    </button>
                                </div>
                            </div>

                            <input type="hidden" name="processName" value="updateASNext">
                            <input type="hidden" name="milNumber" value="<?= $milNumber; ?>">

                        </form>

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
<script src="./js/picker_date.js"></script>

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
    //กำหนดให้ textbox ที่มี id เท่ากับ my_date เป็นตัวเลือกแบบ ปฎิทิน
    picker_date(document.getElementById("id4DateASNext"), {year_range: "-5:+5"});
    /*{year_range:"-12:+10"} คือ กำหนดตัวเลือกปฎิทินให้ แสดงปี ย้อนหลัง 12 ปี และ ไปข้างหน้า 10 ปี*/
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

<script>
    let asLevel = document.getElementById("id4levelASNext");
    let asDate = document.getElementById("id4DateASNext");
    let warnTxt = document.getElementById("id4ChkASDateVal");

    $("#id4BtnSubmit").on("mouseover", function () {
        if (asDate.value === '') {
            // $("#id4BtnSubmit").attr("disabled", true);
            $("#id4ChkASDateVal").addClass("text-danger");
            warnTxt.innerHTML = "ต้องระบุวันที่ที่ขอ";
        } else {
            // $("#id4BtnSubmit").attr("disabled", false);
            warnTxt.innerHTML = "";
        }

    });

</script>

</body>
</html>