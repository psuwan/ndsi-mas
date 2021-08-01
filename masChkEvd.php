<?php
session_start();

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

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
                            <div class="col-12"><h5 class="card-title h4">ตรวจสอบหลักฐานประกอบการขอประเมินวิทยฐานะ</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>เลขทหาร</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>วิทยฐานะปัจจุบัน</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sqlcmd_listMasRequest = "SELECT * FROM tbl_profiles WHERE pf_asnext IS NOT NULL ";
                                    $sqlres_listMasRequest = mysqli_query($dbConn, $sqlcmd_listMasRequest);
                                    if ($sqlres_listMasRequest) {
                                        while ($sqlfet_listMasRequest = mysqli_fetch_assoc($sqlres_listMasRequest)) {
                                            ?>
                                            <tr>
                                                <td><?= $sqlfet_listMasRequest['mil_number']; ?></td>
                                                <td><?= $sqlfet_listMasRequest['pf_namefirst'] . " " . $sqlfet_listMasRequest['pf_namelast']; ?></td>
                                                <td><?= getValue('mas_as', 'as_number', $sqlfet_listMasRequest['pf_asnow'], 1, 'as_name'); ?></td>
                                                <td>
                                                    <?php
                                                    $userASNext = getValue('tbl_profiles','mil_number', $sqlfet_listMasRequest['mil_number'], 2,'pf_asnext');
                                                    $criteria2SChk = $sqlfet_listMasRequest['mil_number']."mAS".$userASNext;
                                                    $newEvdCmd = "SELECT COUNT(evd_newup) AS newevd FROM mas_evdchk WHERE evd_newup=1 AND evd_refnumber LIKE '" . $criteria2SChk . "%'";
                                                    $newEvdRes = mysqli_query($dbConn, $newEvdCmd);
                                                    if ($newEvdRes) {
                                                        $newEvdFet = mysqli_fetch_assoc($newEvdRes);
                                                    }
                                                    ?>
                                                    <span class="badge badge-pill badge-warning">ข้อมูลใหม่: <?= $newEvdFet['newevd']; ?></span>
                                                </td>
                                                <td>
                                                    <select name="" id="id4MasAct" class="form-control form-control-sm"
                                                            onchange="courseOperation(this.value);">
                                                        <option value="">ตัวเลือก</option>
                                                        <option value="1_<?= $sqlfet_listMasRequest['mil_number']; ?>">
                                                            ตรวจสอบหลักฐาน
                                                        </option>
                                                        <option value="2_<?= $sqlfet_listMasRequest['mil_number']; ?>">
                                                            ดูประวัติ
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>


<script>
    let courseOperation = function (courseOperation) {
        let splitStr = courseOperation.split('_');

        switch (splitStr[0]) {
            case '1':
                window.location.href = './masMgrEvd.php?milNumber=' + splitStr[1];
                break;
            case '2':
                window.location.href = './masHistory.php?milNumber=' + splitStr[1];
                break;
        }
    }
</script>

</body>
</html>