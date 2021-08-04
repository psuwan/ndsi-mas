<?php
session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

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
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">

                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row mt-3">
                            <div class="col-6"><h5 class="card-title">
                                    รายงานเกี่ยวกับการปฏิบัติงานในปีที่ขอรับการประเมิน</h5>
                            </div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <span data-toggle="modal" data-target="#id4MilWork4ASModal">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="เพิ่มข้อมูล"><i
                                            class="fas fa-plus font-weight-bold text-success pr-3"></i></a>
                                </span>
                            </div><!-- Toggle switch -->
                        </div>

                        <?php
                        $cntWrk = 0;
                        $sqlcmd_listWorkReport = "SELECT * FROM mas_wrkreport WHERE mil_number='" . $milNumber . "' ORDER BY id";
                        $sqlres_listWorkReport = mysqli_query($dbConn, $sqlcmd_listWorkReport);

                        if ($sqlres_listWorkReport) {
                            while ($sqlfet_listWorkReport = mysqli_fetch_assoc($sqlres_listWorkReport)) {
                                ?>
                                <div class="row mt-3">
                                    <div class="col-10 font-weight-bold">
                                        <?= ++$cntWrk . ". "; ?>
                                        <?= $sqlfet_listWorkReport['mil_wrktopic']; ?>
                                    </div>
                                    <div class="col-2 text-right">
                                        <a href="./userWorkReportAct.php?command=delete&id2delete=<?= $sqlfet_listWorkReport['id']; ?>">
                                            <i class="far fa-times-circle text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <?= $sqlfet_listWorkReport['mil_wrkdetails']; ?>
                                    </div>
                                </div>
                                <?
                            }
                        }
                        ?>


                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="id4MilWork4ASModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">เพิ่มรายงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./userWorkReportAct.php" method="post">

                <div class="modal-body">

                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="id4MilWorkTopic" class="font-weight-bold">หัวข้อการปฏิบัติงาน</label>
                            <input type="text" name="milWorkTopic" id="id4MilWorkTopic"
                                   class="form-control form-control-sm"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="id4MilWorkDetails" class="font-weight-bold">รายละเอียด</label>
                            <textarea name="milWorkDetails" id="id4MilWorkDetails" rows="10"
                                      class="form-control form-control-sm"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                </div>

                <input type="hidden" name="processName" value="addWorkReport">
                <input type="hidden" name="milNumber" value="<?= $milNumber; ?>">
                <!--                <input type="hidden" name="milWorkIsNow" value="1" disabled id="id4MilWorkIsNow">-->
            </form>
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


</script>

</body>
</html>