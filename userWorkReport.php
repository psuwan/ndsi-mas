<?php

session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');

// Function to check existing uploaded files
function chkFileExists($fileName, $fileFolder, $dspTxt)
{
//    list($refNumber, $section) = explode('_', $fileName);
    $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    //$folder2Scan = $baseDir . $fileFolder . DIRECTORY_SEPARATOR . $fileRefNumber;
    $folder2Scan = $baseDir . $fileFolder;

    if (!empty($fileName)) {
        //$directory = getcwd() . $folder2Scan;
        $files2 = glob($folder2Scan . DIRECTORY_SEPARATOR . $fileName . "*");

        if ($files2) {
            $filecount = count($files2);
            for ($iFiles2 = 0; $iFiles2 < $filecount; ++$iFiles2) {
                ?>
                <!-- <div class="col-sm-3">-->
                <?php
                $tmpGenID4DelIcon = explode(".", str_replace($baseDir . $fileFolder . DIRECTORY_SEPARATOR, '', $files2[$iFiles2]));
                $genID4DelIcon = $tmpGenID4DelIcon[0];
                ?>
                <a id="id4DelFile_<?= $genID4DelIcon; ?>"
                   href="./deleteFile.php?file2Del=<?= $files2[$iFiles2]; ?>&file2Ret=<?= $_SERVER['SCRIPT_NAME']; ?>"><i
                            class="far fa-minus-square text-danger"></i></a>
                <a href="<?= str_replace($baseDir, '', $folder2Scan) . str_replace($folder2Scan, '', $files2[$iFiles2]); ?>"
                   target="_blank"><span
                            class="badge badge-pill badge-primary"> <?= $dspTxt; ?>
                        <?php
                        if ($filecount > 1) {
                            echo " ที่ " . ($iFiles2 + 1);
                        }
                        ?>
                </a>
                <!-- </div>-->
                <?php
            }
        } else {
            // Do nothing.....
            echo "<span class=\"badge badge-pill badge-warning\">-</span>";
        }
    }
}// Function to check existing uploaded files

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
    <link rel="stylesheet" href="./summernote/summernote.min.css">

    <title>MAS - WORK REPORT</title>
</head>
<body>

<!-- Floating menu -->
<nav class="floating-menu">
    <span data-toggle="modal" data-target="#id4MilWork4ASModal">
                                <a href="#"><i class="fas fa-plus font-weight-bold text-info"></i> เพิ่มข้อมูล </a>
                                </span>
    <?php
    $sqlcmd_cntRepGrp = "SELECT DISTINCT(mil_wrkrepgrp) AS WRKGRP FROM mas_wrkreport WHERE mil_number='" . $milNumber . "' ORDER BY WRKGRP ASC";
    $sqlres_cntRepGrp = mysqli_query($dbConn, $sqlcmd_cntRepGrp);
    if ($sqlres_cntRepGrp) {
        while ($sqlfet_cntRepGrp = mysqli_fetch_assoc($sqlres_cntRepGrp)) {

            ?>
            <a href="#boxGrp<?= $sqlfet_cntRepGrp['WRKGRP']; ?>"><?= getValue('mas_wrkrepgrp', 'repgrp_code', $sqlfet_cntRepGrp['WRKGRP'], 2, 'repgrp_name'); ?></a>
            <?php
        }
    }
    ?>
</nav><!-- Floating menu -->

<div class="wrapper">
    <?php
    include_once './fileSidebar.php';
    ?>

    <!-- Page Content  -->
    <div id="content">

        <?php
        include_once './fileNavbar.php';
        ?>

        <div class="row">
            <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row mt-3">
                            <div class="col-10"><h4 class="card-title text-center">
                                    รายงานเกี่ยวกับการปฏิบัติงานในปีที่ขอรับการประเมิน</h4>
                            </div>
                            <div class="col-2 text-success text-right">
                                <span data-toggle="modal" data-target="#id4MilWork4ASModal">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="เพิ่มข้อมูล"><i
                                            class="fas fa-plus font-weight-bold text-info"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
        $sqlcmd_listByGrp = "SELECT DISTINCT(mil_wrkrepgrp) AS WRKGRP FROM mas_wrkreport WHERE mil_number='" . $milNumber . "' ORDER BY mil_wrkrepgrp ASC";
        $sqlres_listByGrp = mysqli_query($dbConn, $sqlcmd_listByGrp);

        if ($sqlres_listByGrp) {
            while ($sqlfet_listByGrp = mysqli_fetch_assoc($sqlres_listByGrp)) {
                ?>
                <!-- Box Card -->
                <div class="row mt-3" id="boxGrp<?= $sqlfet_listByGrp['WRKGRP']; ?>">
                    <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                        <div class="card shadow-lg" style="width: 100%;">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                                <div class="row mt-3">
                                    <div class="col-6"><h5 class="card-title">
                                            <?= getValue('mas_wrkrepgrp', 'repgrp_code', $sqlfet_listByGrp['WRKGRP'], 2, 'repgrp_name'); ?></h5>
                                    </div>
                                </div>
                                <?php
                                $cntRep = 0;
                                $sqlcmd_listInGrp = "SELECT * FROM mas_wrkreport WHERE mil_number='" . $milNumber . "' AND mil_wrkrepgrp='" . $sqlfet_listByGrp['WRKGRP'] . "' ORDER BY DATE(mil_wrkrepdate) ASC";
                                $sqlres_listInGrp = mysqli_query($dbConn, $sqlcmd_listInGrp);

                                if ($sqlres_listByGrp) {
                                    $sqlnum_listByGrp = mysqli_num_rows($sqlres_listByGrp);
                                    while ($sqlfet_listInGrp = mysqli_fetch_assoc($sqlres_listInGrp)) {
                                        ?>
                                        <div class="row mt-3">
                                            <div class="col-10 font-weight-bold">
                                                <?= ++$cntRep . ". "; ?>
                                                <?= $sqlfet_listInGrp['mil_wrktopic']; ?>
                                            </div>
                                            <div class="col-2 text-right">

                                                <!-- Toggle switch -->
                                                <span data-toggle="modal" data-target="#id4MilWork4ASModalEdit"
                                                      data-milnumber="<?= $milNumber; ?>"
                                                      data-repid="<?= $sqlfet_listInGrp['id']; ?>"
                                                      data-reptopic="<?= $sqlfet_listInGrp['mil_wrktopic']; ?>"
                                                      data-repgrp="<?= $sqlfet_listInGrp['mil_wrkrepgrp']; ?>"
                                                      data-repdate="<?= monthThai(dateBE(substr($sqlfet_listInGrp['mil_wrkrepdate'], 0, 10))); ?>"
                                                      data-repdets="<?= $sqlfet_listInGrp['mil_wrkdetails']; ?>">
                                                    <a href="#" data-toggle="tooltip" data-placement="top"
                                                       title="แก้ไข"><i class="far fa-edit"></i></a>
                                                </span><!-- Toggle switch -->

                                                <!--<a data-toggle="tooltip" data-placement="top" title="แก้ไข" href="#"><i
                                                            class="far fa-edit"></i></a>-->
                                                <a data-toggle="tooltip" data-placement="top" title="ลบ"
                                                   href="./userWorkReportAct.php?command=delete&id2delete=<?= $sqlfet_listInGrp['id']; ?>">
                                                    <i class="far fa-times-circle text-danger"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-12 text-left text-muted font-sm">
                                                <?= monthThai(dateBE(substr($sqlfet_listInGrp['mil_wrkrepdate'], 0, 10))); ?>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <?= $sqlfet_listInGrp['mil_wrkdetails']; ?>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <u>หลักฐาน / เอกสารเพิ่มเติม</u>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-12">
                                                <?php
                                                $filesReportIndex = $milNumber . "Report" . $sqlfet_listInGrp['id'];
                                                //echo $filesReportIndex;
                                                ?>
                                                <?= chkFileExists($filesReportIndex, 'filesReport', 'หลักฐาน'); ?>
                                                <label class="btn btn-sm" data-toggle="tooltip"
                                                       data-placement="right"
                                                       title="หลักฐาน (pdf, png, jpg)"
                                                       id="id4Btn_<?= $filesReportIndex; ?>"
                                                       style="margin:0rem!important;"><i
                                                            class="far fa-plus-square text-success"></i><input
                                                            type="file" style="display:none;" multiple
                                                            name="Files_<?= $filesReportIndex; ?>"
                                                            id="id4Files_<?= $filesReportIndex; ?>"
                                                            onchange="updateFilesAll('<?= $filesReportIndex; ?>', 'filesReport', 'userWorkReport.php')"></label>
                                                <span id="span4_<?= $filesReportIndex; ?>"></span>

                                                <!--
                                                                                                <a href="#" data-toggle="tooltip" data-placement="right"
                                                                                                   title="เอกสารเพิ่มเติม"><i
                                                                                                            class="far fa-plus-square text-success"></i></a>-->
                                            </div>
                                        </div>
                                        <?php
                                        if ($cntRep < $sqlnum_listByGrp)
                                            echo "<hr>";
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
        }
        ?>

        <br><br>
    </div>
</div>

<!-- Modal to add report -->
<div class="modal fade" id="id4MilWork4ASModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content px-3">
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
                        <div class="col-3">
                            <label for="id4ReportGroup">ประเภทของรายงาน</label>
                            <select name="reportGroup" id="id4ReportGroup" class="form-control form-control-sm"
                                    required>
                                <?php
                                $sqlcmd_listRepGrp = "SELECT * FROM mas_wrkrepgrp WHERE 1";
                                $sqlres_listRepGrp = mysqli_query($dbConn, $sqlcmd_listRepGrp);
                                if ($sqlres_listRepGrp) {
                                    while ($sqlfet_listRepGrp = mysqli_fetch_assoc($sqlres_listRepGrp)) {
                                        ?>
                                        <option value="<?= $sqlfet_listRepGrp['repgrp_code']; ?>"><?= $sqlfet_listRepGrp['repgrp_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="id4ReportDate">รายงานลงวันที่</label>
                            <input type="text" name="reportDate" id="id4ReportDate"
                                   class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="id4MilWorkDetails" class="font-weight-bold">รายละเอียด</label>
                            <!-- Alert -->
                            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                                <strong>Demo version</strong>
                                <!--                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
                                <!--                                    <span aria-hidden="true">&times;</span>-->
                                <!--                                </button>-->
                            </div><!-- Alert -->
                            <textarea name="milWorkDetails" id="id4MilWorkDetails" rows="10"
                                      class="form-control form-control-sm">(พิมพ์รายงานที่นี่)</textarea>
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
</div><!-- Modal to add report -->

<!-- Modal to edit report -->
<div class="modal fade" id="id4MilWork4ASModalEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content px-3">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">แก้ไขรายงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./userWorkReportAct.php" method="post">

                <div class="modal-body">

                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="id4MilWorkTopicEdit" class="font-weight-bold">หัวข้อการปฏิบัติงาน</label>
                            <input type="text" name="milWorkTopic" id="id4MilWorkTopicEdit"
                                   class="form-control form-control-sm"
                                   placeholder="">
                        </div>
                        <div class="col-3">
                            <label for="id4ReportGroupEdit">ประเภทของรายงาน</label>
                            <div class="id_100">
                                <select name="reportGroup" id="id4ReportGroupEdit" class="form-control form-control-sm"
                                        required>
                                    <?php
                                    $sqlcmd_listRepGrp = "SELECT * FROM mas_wrkrepgrp WHERE 1";
                                    $sqlres_listRepGrp = mysqli_query($dbConn, $sqlcmd_listRepGrp);
                                    if ($sqlres_listRepGrp) {
                                        while ($sqlfet_listRepGrp = mysqli_fetch_assoc($sqlres_listRepGrp)) {
                                            ?>
                                            <option value="<?= $sqlfet_listRepGrp['repgrp_code']; ?>"><?= $sqlfet_listRepGrp['repgrp_name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="id4ReportDateEdit">รายงานลงวันที่</label>
                            <input type="text" name="reportDate" id="id4ReportDateEdit"
                                   class="form-control form-control-sm" placeholder="">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="id4MilWorkDetailsEdit" class="font-weight-bold">รายละเอียด</label>

                            <!-- Alert -->
                            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                                <strong>Demo version</strong>
                                <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>-->
                            </div><!-- Alert -->

                            <textarea name="milWorkDetails" id="id4MilWorkDetailsEdit" rows="10"
                                      class="form-control form-control-sm"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                </div>

                <input type="hidden" name="processName" value="editWorkReport">
                <input type="hidden" name="id2edit" id="id4ID2Edit" value="">
                <!--                <input type="hidden" name="milWorkIsNow" value="1" disabled id="id4MilWorkIsNow">-->
            </form>
        </div>
    </div>
</div><!-- Modal to edit report -->

<!-- Popper and Bootstrap JS -->
<script src="./js/jquery-3.5.1.slim.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Project script -->
<script src="./js/prjScript.js"></script>
<script src="./js/picker_date.js"></script>
<script src="./js/uploadFilesAll.js"></script>

<!-- Sumernote js -->
<script src="./summernote/summernote.min.js"></script>

<!-- Sidebar -->
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
</script><!-- Sidebar -->

<!-- Tooltips bootstrap -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><!-- Tooltips bootstrap -->

<!-- Edit modal -->
<script>
    $('#id4MilWork4ASModalEdit').on('show.bs.modal', function (event) {
        let reprefev = $(event.relatedTarget);
        let repid = reprefev.data('repid');
        let repdate = reprefev.data('repdate');
        let reptopic = reprefev.data('reptopic');
        let repgrp = reprefev.data('repgrp');
        let repdets = reprefev.data('repdets');

        let modal = $(this);

        modal.find(".modal-title").text("แก้ไขข้อมูลรายงาน");
        modal.find("#id4MilWorkDetailsEdit").val(repdets);
        modal.find("#id4MilWorkDetailsEdit").summernote();
        modal.find("#id4ID2Edit").val(repid);
        modal.find("#id4ReportDateEdit").attr("placeholder", repdate + " คลิกแก้ไข");
        modal.find("#id4MilWorkTopicEdit").val(reptopic);
        modal.find(".id_100 select").val(repgrp).change();
    })

    $('#id4MilWork4ASModalEdit').on('hidden.bs.modal', function () {
        window.location.reload();
    })
</script><!-- Edit modal -->


<!-- Summernote textarea -->
<script>
    $(document).ready(function () {
        $("#id4MilWorkDetails").summernote();
        // $("#id4MilWorkDetailsEdit").summernote();
    });
</script><!-- Summernote textarea -->

<!-- Picker date -->
<script>
    picker_date(document.getElementById("id4ReportDate"), {year_range: "-5:+2"});
    picker_date(document.getElementById("id4ReportDateEdit"), {year_range: "-5:+2"});
</script><!-- Picker date -->

<!-- List and upload files -->
<script>
    let updateFilesAll = function (filesName, filesDir, fileRet) {
        // console.log(filesName);
        // console.log(filesDir);
        // console.log(fileRet);

        let btn2Sel = document.getElementById("id4Btn_" + filesName);
        let input = document.getElementById("id4Files_" + filesName);
        let output = document.getElementById("span4_" + filesName);

        btn2Sel.hidden = true;
        // console.log(input.files.length);

        for (let i = 0; i < input.files.length; ++i) {
            output.innerHTML += input.files.item(i).name;
            if ((input.files.length > 1) && (i < (input.files.length - 1)))
                output.innerHTML += ',';
        }

        output.innerHTML += '<label class="btn btn-sm mt-2" onclick="uploadFilesAll(\'' + filesName + '\',\'' + filesDir + '\', \'' + fileRet + '\')"><i class="fas fa-cloud-upload-alt text-success"></i></label>';
    }
</script><!-- List and upload files -->

</body>
</html>
