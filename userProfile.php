<?php
session_start();
include_once './lib/apksFunctions.php';

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');

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

                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลผู้ขอรับการประเมิน</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 custom-control custom-switch d-flex justify-content-end">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">แก้ไขข้อมูล</label>
                            </div><!-- Toggle switch -->
                        </div>

                        <form action="./temp.php" method="post">
                            <!-- Row #01 -->
                            <div class="row" id="id4PersonDetail">
                                <div class="col-md-6">
                                    <label for="if4PfNameFirst">ชื่อ</label>
                                    <input type="text" name="nameFirst" id="if4PfNameFirst"
                                           class="form-control form-control-sm" disabled value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="if4PfNameFirst">สกุล</label>
                                    <input type="text" name="nameLast" id="if4PfNameLast"
                                           class="form-control form-control-sm" disabled value="">
                                </div>
                            </div><!-- Row #01 -->

                            <!-- Row Misc #01 -->
                            <div class="row mt-2 d-none" id="id4RowMisc1">
                                <div class="col-md-3">
                                    <div><label for="">เพศ</label></div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" id="id4Sex1" value="1">
                                        <label class="form-check-label" for="id4Sex1">ชาย</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" id="id4Sex2" value="2">
                                        <label class="form-check-label" for="id4Sex2">หญิง</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="id4Rank">ยศ</label>
                                    <select name="rank" id="id4Rank" class="form-control form-control-sm">
                                        <option value="">เลือกยศ</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="id4DateBirth">เกิดวันที่</label>
                                    <input type="text" name="dateBirth" id="id4DateBirth"
                                           class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4DateInGov">เกิดวันที่</label>
                                    <input type="text" name="dateInGov" id="id4DateInGov"
                                           class="form-control form-control-sm">
                                </div>
                            </div><!-- Row Misc #1 -->

                            <!-- Row #02 -->
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="id4Age">อายุ</label>
                                    <input type="text" name="age" id="id4Age" class="form-control form-control-sm"
                                           placeholder="อายุ ปี เดือน" disabled value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4GovAge">อายุราชการ</label>
                                    <input type="text" name="govAge" id="id4GovAge"
                                           class="form-control form-control-sm" placeholder="อายุราชการ ปี เดือน"
                                           disabled value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="id4Position">ตำแหน่ง</label>
                                    <input type="text" name="position" id="id4Position"
                                           class="form-control form-control-sm" placeholder="ตำแหน่งงาน" disabled
                                           value="">
                                </div>
                            </div><!-- Row #02 -->

                            <!-- Row #03 -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="id4WorkOffice">สถานศึกษา/หน่วยงาน</label>
                                    <input type="text" name="workOffice" id="id4WorkOffice"
                                           class="form-control form-control-sm" placeholder="สถานศึกษา/หน่วยงาน"
                                           disabled value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4ASNow">ปัจจุบันมีวิทยฐานะระดับ</label>
                                    <input type="text" name="ASNow" id="id4ASNow" class="form-control form-control-sm"
                                           placeholder="ระดับวิทยฐานะปัจจุบัน" disabled value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4ASAge">ระยะเวลา</label>
                                    <input type="text" name="ASAge" id="id4ASAge" class="form-control form-control-sm"
                                           placeholder="ระยะเวลาวิทยฐานะ ปี เดือน" disabled value="">
                                </div>
                            </div><!-- Row #03 -->

                            <!-- Row #03 for edit -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="id4WorkOffice">สถานศึกษา/หน่วยงาน</label>
                                    <input type="text" name="workOffice" id="id4WorkOffice"
                                           class="form-control form-control-sm" placeholder="สถานศึกษา/หน่วยงาน"
                                           value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4ASNow">ปัจจุบันมีวิทยฐานะระดับ</label>
                                    <input type="text" name="ASNow" id="id4ASNow" class="form-control form-control-sm"
                                           placeholder="ระดับวิทยฐานะปัจจุบัน" value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4ASAge">ระยะเวลา</label>
                                    <input type="text" name="ASAge" id="id4ASAge" class="form-control form-control-sm"
                                           placeholder="ระยะเวลาวิทยฐานะ ปี เดือน" value="">
                                </div>
                            </div><!-- Row #03 for edit -->

                            <!-- Row #04 -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="id4SalaryLevel">รับเงินเดือนระดับ</label>
                                    <input type="text" name="salaryLevel" id="id4SalaryLevel"
                                           class="form-control form-control-sm text-center" placeholder="ระดับเงินเดือน"
                                           disabled value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4SalaryFloor">ชั้น</label>
                                    <input type="text" name="salaryFloor" id="id4SalaryFloor"
                                           class="form-control form-control-sm text-center" placeholder="ชั้นเงินเดือน"
                                           disabled value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4Salary">จำนวนเงินเดือน</label>
                                    <input type="text" name="salary" id="id4Salary"
                                           class="form-control form-control-sm text-center" placeholder="จำนวนเงินเดือน"
                                           disabled value="">
                                </div>
                            </div>

                            <div class="row mt-3 d-none" id="id4Row4Button">
                                <div class="col-12 text-center">
                                    <hr>
                                    <button type="submit" class="btn btn-sm btn-outline-success" style="width: 150px;">
                                        บันทึก
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

        <!-- Card #02 -->
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2 d-flex justify-content-center">
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลคุณวุฒิทางการศึกษา</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <a href="#" class="btn btn-sm btn-outline-success">&nbsp;+&nbsp;</a>&nbsp;&nbsp;เพิ่มข้อมูล
                            </div><!-- Toggle switch -->
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Card #02 -->

        <!-- Card #03 -->
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2 d-flex justify-content-center">
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลคุณวุฒิทางการศึกษาทหาร</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <a href="#" class="btn btn-sm btn-outline-success">&nbsp;+&nbsp;</a>&nbsp;&nbsp;เพิ่มข้อมูล
                            </div><!-- Toggle switch -->
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Card #03 -->
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
    $("#customSwitch1").on("change click", function () {
        if ($("#customSwitch1").is(":checked")) {
            $("#id4Row4Button").removeClass("d-none");
            $("#id4RowMisc1").removeClass("d-none");
            $("#if4PfNameFirst").attr("disabled", false);
            $("#if4PfNameLast").attr("disabled", false);
        } else {
            $("#id4Row4Button").addClass("d-none");
            $("#id4RowMisc1").addClass("d-none");
            $("#if4PfNameFirst").attr("disabled", true);
            $("#if4PfNameLast").attr("disabled", true);
        }
    });
</script>

</body>
</html>