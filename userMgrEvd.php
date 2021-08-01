<?php
session_start();

/*-- Date Time --*/
date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");
/*-- Date Time --*/

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

// Get mil-Number from session
$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');

// Get evidence as to upload
$varget_evd2Upload = filter_input(INPUT_GET, 'evd2Upload');
updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_asnext', $varget_evd2Upload, 1);

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
            <!--<div class="col-sm-3">-->
            &nbsp;<span class="badge badge-pill badge-warning"> ไม่มีไฟล์ </span>
            <!--</div>-->
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
        <div class="container-fluid">
            <!-- col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
            <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-12"><h5 class="card-title font-weight-bold">
                                    เอกสารหลักฐานประกอบการขอมี/เลื่อนวิทยฐานะระดับ
                                    "<?= getValue('mas_as', 'as_number', $varget_evd2Upload, 1, 'as_name'); ?>"</h5>
                            </div>
                        </div>
                        <hr>
                        <?php
                        $cntEvd = 0;
                        $sqlcmd_listEvd = "SELECT * FROM mas_evidence WHERE SUBSTR(evd_usefor," . $varget_evd2Upload . ",1)='1'";
                        $sqlres_listEvd = mysqli_query($dbConn, $sqlcmd_listEvd);
                        if ($sqlres_listEvd) {
                            while ($sqlfet_listEvd = mysqli_fetch_assoc($sqlres_listEvd)) {
                                // Start of while loop
                                $evdName = $milNumber . 'mAS' . $varget_evd2Upload . 'evd' . str_pad(++$cntEvd, 2, '0', STR_PAD_LEFT);
                                ?>
                                <div class="row mt-3">
                                    <div class="col-md-12"><?= $cntEvd . ". "; ?><?= $sqlfet_listEvd['evd_name']; ?></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2 text-md-right">ไฟล์หลักฐาน :</div>
                                    <div class="col-md-10" id="chkFile_<?= $evdName; ?>">
                                        <?= chkFileExists($evdName, 'filesEvd', $varget_evd2Upload); ?>
                                    </div>
                                </div>
                                <div class="row mt-0">
                                    <div class="col-2">&nbsp;</div>
                                    <div class="col-10">
                                        <label class="btn btn-outline-info btn-sm mt-2" id="id4BtnEvd_<?= $evdName; ?>"
                                               style="width:65px;">ไฟล์<input
                                                    type="file" multiple
                                                    style="display:none;"
                                                    name="evdFiles_<?= $evdName; ?>" id="id4EvdFiles_<?= $evdName; ?>"
                                                    onchange="updFile2Upload('<?= $evdName; ?>', 'filesEvd', 'userMgrEvd.php?evd2Upload=<?= $varget_evd2Upload; ?>');">
                                        </label><span id="span4Evd_<?= $evdName; ?>"></span>
                                    </div>
                                </div>
                                <?php
                                // End of while loop
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

            <br><br>

        </div>

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
<script src="./js/uploadFiles.js"></script>

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

        let btn2Sel = document.getElementById("id4BtnEvd_" + filesName);
        let input = document.getElementById("id4EvdFiles_" + filesName);
        let output = document.getElementById("span4Evd_" + filesName);

        btn2Sel.hidden = true;
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