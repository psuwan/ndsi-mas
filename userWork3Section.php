<?php
session_start();

/*-- Date Time --*/
date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");
/*-- Date Time --*/

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();
$varget_repSection = filter_input(INPUT_GET, 'repSection');

// Get mil-Number from session
$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');
$ASNextLevel = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_asnext');
$ASNextName = getValue('mas_as', 'as_number', $ASNextLevel, 2, 'as_name');


$thisFile = trim(str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']), DIRECTORY_SEPARATOR);

function chkFileExists($fileName, $fileFolder, $refNumber)
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
                   href="./deleteFile.php?file2Del=<?= $files2[$iFiles2]; ?>&file2Ret=<?= $_SERVER['SCRIPT_NAME']; ?>&refNumber=<?= $refNumber; ?>"><i
                            class="far fa-times-circle text-danger"></i></a>
                <a href="<?= str_replace($baseDir, '', $folder2Scan) . str_replace($folder2Scan, '', $files2[$iFiles2]); ?>"
                   target="_blank"><span class="badge badge-pill badge-primary"> ไฟล์ที่ <?= $iFiles2 + 1; ?> </a>
                <!-- </div>-->
                <?php
            }
        } else {
            ?>
            <span class="badge badge-pill badge-warning"> ไม่มีไฟล์ </span>
            <?php
        }
    }
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

    <title>MQA - Course QA</title>

    <!--    <script type="text/javascript" src="./js/floating-1.12.js"></script>-->
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

        <?php
        if ($varget_repSection === '1') {
            ?>
            <div class="row mt-3">
                <!-- col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">

                    <div class="card shadow-lg" style="width: 100%;">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>

                            <div class="row">
                                <div class="col-12"><h5 class="card-title font-weight-bold">
                                        รายงานด้านที่ 1 ด้านวินัย คุณธรรม จริยธรรม และจรรยาบรรณข้าราชการที่ทำหน้าที่สอน
                                </div>
                            </div>
                            <hr>
                            <!-- #01 Row -->
                            <div class="row mt-3">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-2 text-md-right">ไฟล์หลักฐาน :</div>
                                        <div class="col-md-10" id="chkFileSec1">
                                            <?= chkFileExists($milNumber . 'FileSec1', 'files3Sec', 2); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-10 offset-2">
                                                <label class="btn btn-outline-info btn-sm mt-2"
                                                       id="id4BtnEvd_<?= $milNumber; ?>FileSec1"
                                                       style="width:65px;">ไฟล์<input
                                                            type="file" multiple
                                                            style="display:none;"
                                                            name="evdFiles_<?= $milNumber; ?>FileSec1"
                                                            id="id4EvdFiles_<?= $milNumber; ?>FileSec1"
                                                            onchange="updFile2Upload('<?= $milNumber; ?>FileSec1', 'files3Sec', 'userWork3section.php');">
                                                </label><span id="span4Evd_<?= $milNumber; ?>FileSec1"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End of #01 Row -->

                        </div>
                    </div><!-- End of card #1 -->

                </div>
            </div><!-- End of row -->
            <?php
        } elseif ($varget_repSection === '2') {
            ?>

            <div class="row mt-3">
                <!-- col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">

                    <div class="card shadow-lg" style="width: 100%;">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                            <div class="row">
                                <div class="col-12"><h5 class="card-title font-weight-bold">
                                        รายงานด้านที่ 2 ความรู้ ความสามารถ
                                </div>
                            </div>
                            <hr>
                            <!-- #01 Row -->
                            <div class="row mt-3">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-2 text-md-right">ไฟล์หลักฐาน :</div>
                                        <div class="col-md-10" id="chkFileSec1">
                                            <?= chkFileExists($milNumber . 'FileSec2', 'files3Sec', 2); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-10 offset-2">
                                                <label class="btn btn-outline-info btn-sm mt-2"
                                                       id="id4BtnEvd_<?= $milNumber; ?>FileSec2"
                                                       style="width:65px;">ไฟล์<input
                                                            type="file" multiple
                                                            style="display:none;"
                                                            name="evdFiles_<?= $milNumber; ?>FileSec2"
                                                            id="id4EvdFiles_<?= $milNumber; ?>FileSec2"
                                                            onchange="updFile2Upload('<?= $milNumber; ?>FileSec2', 'files3Sec', 'userWork3section.php');">
                                                </label><span id="span4Evd_<?= $milNumber; ?>FileSec2"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End of #01 Row -->

                        </div>
                    </div><!-- End of card #1 -->

                </div>
            </div><!-- End of row -->
            <?php
        } elseif ($varget_repSection === '3') {
            ?>

            <div class="row mt-3">
                <!-- col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">

                    <div class="card shadow-lg" style="width: 100%;">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                            <div class="row">
                                <div class="col-12"><h5 class="card-title font-weight-bold">
                                        รายงานด้านที่ 3 ผลการปฏิบัติงาน
                                </div>
                            </div>
                            <hr>
                            <!-- #01 Row -->
                            <div class="row mt-3">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-2 text-md-right">ไฟล์หลักฐาน :</div>
                                        <div class="col-md-10" id="chkFileSec3">
                                            <?= chkFileExists($milNumber . 'FileSec3', 'files3Sec', 2); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-10 offset-2">
                                                <label class="btn btn-outline-info btn-sm mt-2"
                                                       id="id4BtnEvd_<?= $milNumber; ?>FileSec3"
                                                       style="width:65px;">ไฟล์<input
                                                            type="file" multiple
                                                            style="display:none;"
                                                            name="evdFiles_<?= $milNumber; ?>FileSec3"
                                                            id="id4EvdFiles_<?= $milNumber; ?>FileSec3"
                                                            onchange="updFile2Upload('<?= $milNumber; ?>FileSec3', 'files3Sec', 'userWork3section.php');">
                                                </label><span id="span4Evd_<?= $milNumber; ?>FileSec3"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End of #01 Row -->

                        </div>
                    </div><!-- End of card #1 -->

                </div>
            </div><!-- End of row -->
            <?php
        }
        ?>

    </div>
</div>

<br><br><br><br>

<!-- Popper and Bootstrap JS -->
<!--<script src="./js/jquery-3.5.1.slim.min.js"></script>-->
<script src="./js/jquery-3.6.0.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Project script -->
<script src="./js/prjScript.js"></script>
<script src="./js/uploadFiles3Sec.js"></script>

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


<!-- List files -->
<script>
    let updFile2Upload = function (filesName, filesDir, fileRet) {

        console.log(filesName);

        let btn2Sel = document.getElementById("id4BtnEvd_" + filesName);
        let input = document.getElementById("id4EvdFiles_" + filesName);
        let output = document.getElementById("span4Evd_" + filesName);

        btn2Sel.hidden = true;
        console.log(input.files.length);

        for (let i = 0; i < input.files.length; ++i) {
            output.innerHTML += '<br>' + input.files.item(i).name;
            if ((input.files.length > 1) && (i < (input.files.length - 1)))
                output.innerHTML += ',';
        }
        output.innerHTML += '<br><label class="btn btn-outline-info btn-sm mt-2" style="width:75px;" onclick="uploadFiles(\'' + filesName + '\',\'' + filesDir + '\', \'' + fileRet + '\')">นำเข้า</label>';
    }
</script><!-- List files -->

<!--<script>-->
<!--    $("#id4DelFile_7412589630147mAS4evd05_0").addClass("d-none");-->
<!--</script>-->

</body>
</html>