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

$thisFile = trim(str_replace(dirname($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']), DIRECTORY_SEPARATOR);

function chkFileExists($fileName, $fileFolder)
{
    list($refNumber, $section) = explode('_', $fileName);
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
                <a href="./deleteFile.php?file2Del=<?= $files2[$iFiles2]; ?>&file2Ret=<?= $_SERVER['SCRIPT_NAME']; ?>&refNumber=<?= $refNumber; ?>"><i
                            class="far fa-times-circle text-danger"></i></a>
                <a href="<?= str_replace($baseDir, '', $folder2Scan) . str_replace($folder2Scan, '', $files2[$iFiles2]); ?>"
                   target="_blank"><span class="badge badge-pill badge-primary"> ไฟล์ที่ <?= $iFiles2 + 1; ?> </a>
                <!-- </div>-->
                <?php
            }
        } else {
            ?>
            <!--<div class="col-sm-3">-->
            <span class="badge badge-pill badge-warning"> ไม่มีไฟล์ </span>
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
            <div class="row mt-3">
                <div class="col-12 h5">
                    การติดตามผลการพัฒนาคุณภาพการฝึกอบรมทางทหาร บก.ทท. ของหลักสูตร
                    "<?= getValue('tbl_courses', 'course_refnum', $varget_courseRefNumber, 2, 'course_name'); ?>"
                    โดย "<?= getValue('tbl_units', 'unit_refnum', $unitRefNo, 2, 'unit_abbrv'); ?>"
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-3 text-right">ไฟล์การติดตามผลการพัฒนาคุณภาพการฝึกอบรมทางทหาร บก.ทท. :</div>
                <div class="col-md-6 input-group input-group-sm">
                    <div class="col-12">
                        <?= chkFileExists($varget_courseRefNumber . "_follow", 'filesCourse'); ?>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="btn btn-outline-info btn-sm mt-3" id="follow_btnID"
                               style="width:65px;">ไฟล์<input
                                    type="file" multiple
                                    style="display:none;"
                                    name="follow_file" id="follow_fileID"
                                    onchange="updFileUpload('<?= "follow_" . $varget_courseRefNumber; ?>', 'filesCourse', '<?= $thisFile; ?>?courseRefNumber=<?= $varget_courseRefNumber; ?>')">
                        </label><span id="follow_selID"></span>
                    </div>
                </div>
            </div>

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
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>

<script>
    $('document').ready(function () {
        $('textarea').each(function () {
                $(this).val($(this).val().trim());
            }
        );
    });
</script>

<script>
    // Open tab where come from
    let locate = window.location.hash;
    let chkHash = locate.substring(1, 10);
    let id2Go = locate.substring(1, 26);

    if (locate !== '') {
        if (chkHash === 'divReturn') {
            let tabNo = 'nav-issue-' + locate.charAt(17);
            $('.nav-tabs a[href="#' + tabNo + '"]').tab('show');
        }
    }
</script>

<script>
    let updateDBX = function (dataX) {
        let critDetail = document.getElementById('txtarea_' + dataX);
        console.log('cirtDetDetails from updateDBX: ' + critDetail);
        $.ajax({
            url: 'updateQA.php',
            type: 'POST',
            data: {
                refNum: dataX,
                dat2Up: critDetail.value
            },
            success: function (result) {
                console.log('result from updateDBX: ' + result);
                window.location.hash = 'divReturn_' + dataX.substring(0, 11);
            }
        });
    }
</script>

<script>
    function deleteFile(file2Delete, refNumber) {
        // console.log(file2Delete);
        // console.log(refNumber);
        let r = confirm("ต้องการลบไฟล์");
        if (r == true) {
            window.location.href = './fileDelete.php?file2Del=' + file2Delete + '&refNumber=' + refNumber;
        }
    }
</script>

<!-- List files -->
<script>
    let updFileUpload = function (filesName, filesDir, fileRet) {
        let secName = filesName.split('_');
        console.log(secName);
        let btn2Sel = document.getElementById(secName[0] + '_btnID');
        let input = document.getElementById(secName[0] + '_fileID');
        let output = document.getElementById(secName[0] + '_selID');

        btn2Sel.hidden = true;
        for (let i = 0; i < input.files.length; ++i) {
            output.innerHTML += '<br>' + input.files.item(i).name;
            if ((input.files.length > 1) && (i < (input.files.length - 1)))
                output.innerHTML += ',';
        }
        output.innerHTML += '<br><label class="btn btn-outline-info btn-sm mt-2" style="width:75px;" onclick="uploadFiles(\'' + secName[1] + '_' + secName[0] + '\',\'' + filesDir + '\', \'' + fileRet + '\')">นำเข้า</label>';
    }
</script><!-- List files -->

</body>
</html>