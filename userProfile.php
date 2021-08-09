<?php
session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateIsNow = date("Y-m-d");
$timeIsNow = date("H:i:s");

$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');
$dateNow = substr(getValue('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnext'), 0, 11);

if (empty($dateNow) || ($dateNow == '1900-01-01')) {
    $dateNow = $dateIsNow;
}

// Get profile for milNumber
// Define variables
$sqlcmd_milProfile = "SELECT * FROM mas_profiles WHERE mil_number='" . $milNumber . "'";
$sqlres_milProfile = mysqli_query($dbConn, $sqlcmd_milProfile);
if ($sqlres_milProfile) {
    $sqlnum_milProfile = mysqli_num_rows($sqlres_milProfile);
    if ($sqlnum_milProfile !== 0) {
        $sqlfet_milProfile = mysqli_fetch_assoc($sqlres_milProfile);

        $pfNameFirst = $sqlfet_milProfile['pf_namefirst'];
        $pfNameLast = $sqlfet_milProfile['pf_namelast'];
        $pfSex = $sqlfet_milProfile['pf_sex'];
        $pfRank = $sqlfet_milProfile['pf_rank'];
        $pfASNow = $sqlfet_milProfile['pf_asnow'];
        $pfWorkOffice = $sqlfet_milProfile['pf_office'];
        $pfWorkPosition = $sqlfet_milProfile['pf_position'];

        $pfDateBirth = $sqlfet_milProfile['pf_datebirth'];
        if (!empty($pfDateBirth))
            $pfDateBirth = dateBE(substr($pfDateBirth, 0, 11));
        $pfDateInGov = $sqlfet_milProfile['pf_dateingov'];
        if (!empty($pfDateInGov))
            $pfDateInGov = dateBE(substr($pfDateInGov, 0, 11));
        $pfDateASNow = $sqlfet_milProfile['pf_dateasnow'];
        if (!empty($pfDateASNow))
            $pfDateASNow = dateBE(substr($pfDateASNow, 0, 11));

        $pfSalaryLevel = $sqlfet_milProfile['pf_salarylevel'];
        $pfSalaryFloor = $sqlfet_milProfile['pf_salaryfloor'];
        $pfSalary = $sqlfet_milProfile['pf_salary'];
    } else {
        $pfNameFirst = '';
        $pfNameLast = '';
        $pfSex = '';
        $pfRank = '';
        $pfASNow = '';
        $pfWorkOffice = '';
        $pfWorkPosition = '';

        $pfDateBirth = '';
        $pfDateInGov = '';
        $pfDateASNow = '';

        $pfSalaryLevel = '';
        $pfSalaryFloor = '';
        $pfSalary = '';
    }
} else {
    echo "ERROR!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
}

if ($pfDateASNow === '')
    $pfDateASNow = "1900-01-01";

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
                            class="badge badge-pill badge-primary"> <?= $dspTxt; ?><!--ที่ --><?/*= $iFiles2 + 1*/; ?>
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


    <title>MQA - USER PROFILE</title>

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

        <!-- Box#01 -->
        <div class="row mt-3" id="Box1">
            <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                <!-- Card#01 -->
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">
                                    ข้อมูลผู้ขอรับการประเมิน</h5>
                            </div>
                            <!-- Toggle switch -->
                            <div class="col-6 custom-control custom-switch d-flex justify-content-end">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label pr-0" for="customSwitch1" data-toggle="tooltip"
                                       data-placement="top" title="แก้ไขข้อมูล"></label>
                            </div><!-- Toggle switch -->
                        </div>
                        <form action="./userProfileAct.php" method="post">

                            <!-- Row #01 -->
                            <div class="row mt-3" id="id4PersonDetail">
                                <div class="col-md-6">
                                    <label for="if4PfNameFirst">ชื่อ</label>
                                    <input type="text" name="nameFirst" id="if4PfNameFirst"
                                           class="form-control form-control-sm" disabled value="<?php
                                    $rank4MilNumber = getValue('rtarf_ranks', 'rank_code', $pfRank, 2, 'rank_abbrv');
                                    if ($pfSex === '2')
                                        $rank4MilNumber .= " หญิง";
                                    echo $rank4MilNumber . " " . $pfNameFirst; ?>" autofocus>
                                </div>
                                <div class="col-md-6">
                                    <label for="if4PfNameLast">สกุล</label>
                                    <input type="text" name="nameLast" id="if4PfNameLast"
                                           class="form-control form-control-sm" disabled value="<?php
                                    echo $pfNameLast;
                                    if ((substr($pfRank, 2, 3) < 210) && (substr($pfRank, 2, 3) > 203)) {
                                        echo " ร.น.";
                                    }
                                    ?>">
                                </div>
                            </div><!-- Row #01 -->

                            <!-- Edit Row #01 -->
                            <div class="row mt-2 d-none" id="id4RowMisc1">
                                <div class="col-md-3">
                                    <div>เพศ</div>
                                    <div class="mt-2 form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" id="id4Sex1" value="1"
                                            <?php if ($pfSex == '1') echo "checked"; ?>>
                                        <label class="form-check-label" for="id4Sex1">ชาย</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" id="id4Sex2"
                                               value="2" <?php if ($pfSex == '2') echo "checked"; ?>>
                                        <label class="form-check-label" for="id4Sex2">หญิง</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="id4Rank">ยศ</label>
                                    <select name="rank" id="id4Rank" class="form-control form-control-sm" required>
                                        <option value="">เลือกยศ</option>
                                        <?php
                                        $sqlcmd_listRank = "SELECT * FROM rtarf_ranks WHERE rank_masuse=1 ORDER BY rank_order, rank_group";
                                        $sqlres_listRank = mysqli_query($dbConn, $sqlcmd_listRank);
                                        if ($sqlres_listRank) {
                                            while ($sqlfet_listRank = mysqli_fetch_assoc($sqlres_listRank)) {
                                                ?>
                                                <option value="<?= $sqlfet_listRank['rank_code']; ?>" <?php if ($sqlfet_listRank['rank_code'] == $pfRank) echo "selected"; ?>><?= $sqlfet_listRank['rank_name']; ?>
                                                    (<?= $sqlfet_listRank['rank_abbrv']; ?>)
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="id4DateBirth">เกิดเมื่อ</label>
                                    <input type="text" name="dateBirth" id="id4DateBirth"
                                           class="form-control form-control-sm"
                                           placeholder="<?= $pfDateBirth; ?> คลิกเพื่อแก้ไข">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4DateInGov">เข้ารับราชการเมื่อ</label>
                                    <input type="text" name="dateInGov" id="id4DateInGov"
                                           class="form-control form-control-sm"
                                           placeholder="<?= $pfDateInGov; ?> คลิกเพื่อแก้ไข">
                                </div>
                            </div><!-- Row Misc #1 -->

                            <!-- Row #02 -->
                            <div class="row mt-3" id="id4Row2">
                                <div class="col-md-3">
                                    <label for="id4Age">อายุ</label>
                                    <input type="text" name="age" id="id4Age" class="form-control form-control-sm"
                                           placeholder="<?php
                                           if (!empty($pfDateBirth)) {
                                               list($yy, $mm, $dd) = explode(",", dateDiff($pfDateBirth, dateBE($dateIsNow)));
                                               if ($yy < 120) {
                                                   if ($yy != 0)
                                                       echo $yy . " ปี ";
                                                   if ($mm != 0)
                                                       echo $mm . " เดือน ";
                                                   if ($dd != 0)
                                                       echo $dd . " วัน";
                                               } else
                                                   echo "ข้อมูลผิดพลาด";
                                           } else
                                               echo "อายุ ปี เดือน วัน";
                                           ?>" disabled value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4GovAge">อายุราชการ</label>
                                    <input type="text" name="govAge" id="id4GovAge"
                                           class="form-control form-control-sm" placeholder="<?php
                                    if (!empty($pfDateInGov)) {
                                        list($yy, $mm, $dd) = explode(",", dateDiff($pfDateInGov, dateBE($dateNow)));
                                        if ($yy < 60) {
                                            if ($yy != 0)
                                                echo $yy . " ปี ";
                                            if ($mm != 0)
                                                echo $mm . " เดือน ";
                                            if ($dd != 0)
                                                echo $dd . " วัน";
                                        } else
                                            echo "ข้อมูลผิดพลาด";
                                    } else
                                        echo "อายุ ปี เดือน วัน";
                                    ?>" disabled value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="id4Position">ตำแหน่ง</label>
                                    <input type="text" name="position" id="id4Position"
                                           class="form-control form-control-sm" placeholder="ตำแหน่งงาน" disabled
                                           value="<?php
                                           // Get current military work position from mas_milwork table
                                           $sqlcmd_getMilWrkPos = "SELECT * FROM mas_milwork WHERE mil_number='" . $milNumber . "' AND mil_workisnow='1' ORDER BY id DESC LIMIT 1";
                                           $sqlres_getMilWrkPos = mysqli_query($dbConn, $sqlcmd_getMilWrkPos);
                                           if ($sqlres_getMilWrkPos) {
                                               $sqlfet_getMilWrkPos = mysqli_fetch_assoc($sqlres_getMilWrkPos);
                                               $workPosNow = $sqlfet_getMilWrkPos['mil_position'];

                                               if (!empty($workPosNow)) {
                                                   echo $workPosNow;
                                               } else {
                                                   echo "-";
                                               }
                                           }
                                           ?>">
                                </div>
                            </div><!-- Row #02 -->

                            <!-- Row #03 -->
                            <div class="row mt-3" id="id4Row3">
                                <div class="col-md-5">
                                    <label for="id4WorkOffice">สถานศึกษา/หน่วยงาน</label>
                                    <input type="text" name="workOffice" id="id4WorkOffice"
                                           class="form-control form-control-sm" placeholder="สถานศึกษา/หน่วยงาน"
                                           disabled value="<?= $pfWorkOffice; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4ASNowShow">ปัจจุบันมีวิทยฐานะระดับ</label>
                                    <input type="text" name="ASNowShow" id="id4ASNowShow"
                                           class="form-control form-control-sm"
                                           placeholder="ระดับวิทยฐานะปัจจุบัน" disabled value="<?php
                                    switch ($pfASNow) {
                                        case '0':
                                            echo "ไม่มีวิทยฐานะ";
                                            break;
                                        case '1':
                                            echo "ครูชำนาญการต้น";
                                            break;
                                        case '2':
                                            echo "ครูชำนาญการ (ครูทหาร)";
                                            break;
                                        case '3':
                                            echo "ครูชำนาญการ (ครูวิชาการ)";
                                            break;
                                        case '4':
                                            echo "ครูชำนาญการพิเศษ";
                                            break;
                                    } ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4ASAge2Show">ระยะเวลา</label>
                                    <input type="text" name="ASAge2Show" id="id4ASAge2Show"
                                           class="form-control form-control-sm"
                                           placeholder="<?php
                                           if ($pfASNow === '0') {
                                               echo "-";
                                           } else {
                                               if (!empty($pfDateInGov)) {
                                                   list($yy, $mm, $dd) = explode(",", dateDiff($pfDateASNow, dateBE($dateNow)));
                                                   if ($yy < 50) {
                                                       if ($yy != 0)
                                                           echo $yy . " ปี ";
                                                       if ($mm != 0)
                                                           echo $mm . " เดือน ";
                                                       if ($dd != 0)
                                                           echo $dd . " วัน";
                                                   } else
                                                       echo "ข้อมูลผิดพลาด";
                                               } else
                                                   echo "ระยะเวลา ปี เดือน วัน";
                                           }
                                           ?>" disabled value="">
                                </div>
                            </div><!-- Row #03 -->

                            <!-- Row #03 for edit -->
                            <div class="row mt-3 d-none" id="id4EditRow3">
                                <div class="col-md-3">
                                    <label for="id4WorkOffice">สถานศึกษา/หน่วยงาน</label>
                                    <input type="text" name="workOffice" id="id4WorkOffice"
                                           class="form-control form-control-sm" placeholder="สถานศึกษา/หน่วยงาน"
                                           value="<?= $pfWorkOffice; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4WorkPosition">ตำแหน่งงาน</label>
                                    <input type="text" name="workPosition" id="id4WorkPosition"
                                           class="form-control form-control-sm" placeholder="ตำแหน่งงาน" disabled
                                           value="<?= $workPosNow; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="id4ASNow">ปัจจุบันมีวิทยฐานะระดับ</label>
                                    <!--<input type="text" name="ASNow" id="id4ASNow" class="form-control form-control-sm"
                                           placeholder="ระดับวิทยฐานะปัจจุบัน" value="">-->
                                    <select name="ASNow" id="id4ASNow" class="form-control form-control-sm"
                                            required>
                                        <option value="">เลือกระดับวิทยฐานะ</option>
                                        <option value="0" <?php if ($pfASNow == 0) echo "selected"; ?>>ไม่มีวิทยฐานะ
                                        </option>
                                        <option value="1" <?php if ($pfASNow == 1) echo "selected"; ?>>
                                            ครูชำนาญการต้น
                                        </option>
                                        <option value="2" <?php if ($pfASNow == 2) echo "selected"; ?>>ครูชำนาญการ
                                            (ครูทหาร)
                                        </option>
                                        <option value="3" <?php if ($pfASNow == 3) echo "selected"; ?>>ครูชำนาญการ
                                            (ครูวิชาการ)
                                        </option>
                                        <option value="4" <?php if ($pfASNow == 4) echo "selected"; ?>>
                                            ครูชำนาญการพิเศษ
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="id4DateAS">วันที่ได้รับวิทยฐานะปัจจุบัน</label>
                                    <input type="text" name="dateAS" id="id4DateAS" class="form-control form-control-sm"
                                           placeholder="<?= $pfDateASNow; ?> คลิกเพื่อแก้ไข" value="">
                                </div>
                            </div><!-- Row #03 for edit -->

                            <!-- Row #04 -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="id4SalaryLevel">รับเงินเดือนระดับ</label>
                                    <input type="text" name="salaryLevel" id="id4SalaryLevel"
                                           class="form-control form-control-sm text-center" placeholder="ระดับเงินเดือน"
                                           disabled value="<?= $pfSalaryLevel; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4SalaryFloor">รับเงินเดือนชั้น</label>
                                    <input type="text" name="salaryFloor" id="id4SalaryFloor"
                                           class="form-control form-control-sm text-center" placeholder="ชั้นเงินเดือน"
                                           disabled value="<?= $pfSalaryFloor; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4Salary">จำนวนเงินเดือน</label>
                                    <input type="text" name="salary" id="id4Salary"
                                           class="form-control form-control-sm text-center" placeholder="จำนวนเงินเดือน"
                                           disabled value="<?= number_format($pfSalary, 2, '.', ','); ?> บาท">
                                </div>
                            </div>

                            <div class="row mt-3 d-none" id="id4Row4Button">
                                <div class="col-12 text-right">
                                    <hr>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        บันทึก
                                    </button>
                                </div>
                            </div>

                            <input type="hidden" name="processName" value="updateProfile">
                            <input type="hidden" name="milNum2Update" value="<?= $milNumber; ?>">

                        </form><!-- End of Card#01 Form -->

                    </div>
                </div><!-- End of Card#01 -->

            </div>
        </div><!-- End of Box#01 -->

        <!-- Box#02 -->
        <div class="row mt-3" id="Box2">
            <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                <!-- Card#02 -->
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลคุณวุฒิทางการศึกษา</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <span data-toggle="modal" data-target="#id4StudyModal">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="เพิ่มข้อมูล"><i
                                            class="fas fa-plus font-weight-bold text-success pr-3"></i></a>
                                </span>
                            </div><!-- Toggle switch -->
                        </div>
                        <?php
                        $cntData = countDB('mas_userschool', 'mil_number', $milNumber, 2);
                        if ($cntData > '0') {
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>สถาบันการศึกษา</th>
                                            <th>สาขา</th>
                                            <th>วิชาเอก</th>
                                            <th>ปีที่สำเร็จการศึกษา</th>
                                            <th>สำเนาวุฒิการศึกษา</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sqlcmd_listStudyData = "SELECT * FROM mas_userschool WHERE mil_number='" . $milNumber . "' ORDER BY school_level, school_year";
                                        $sqlres_listStudyData = mysqli_query($dbConn, $sqlcmd_listStudyData);
                                        if ($sqlres_listStudyData) {
                                            while ($sqlfet_listStudyData = mysqli_fetch_assoc($sqlres_listStudyData)) {
                                                ?>
                                                <tr>
                                                    <td><?= $sqlfet_listStudyData['school_name']; ?></td>
                                                    <td><?= $sqlfet_listStudyData['school_branch']; ?></td>
                                                    <td><?= $sqlfet_listStudyData['school_major']; ?></td>
                                                    <td><?= $sqlfet_listStudyData['school_year']; ?></td>
                                                    <td><?php
                                                        $sqlcmd_listStudySchool = "SELECT * FROM mas_milcourse WHERE id=" . $sqlfet_listStudyData['id'];
                                                        $sqlres_listStudySchool = mysqli_query($dbConn, $sqlcmd_listStudySchool);
                                                        if ($sqlres_listStudySchool)
                                                            $sqlfet_listStudySchool = mysqli_fetch_assoc($sqlres_listStudySchool);
                                                        $filesStudyCertIndex = $milNumber . "StudyCert" . $sqlfet_listStudySchool['id'];
                                                        ?>
                                                        <?= chkFileExists($filesStudyCertIndex, 'filesMilCert', 'สำเนาวุฒิการศึกษา'); ?>
                                                        <label class="btn btn-sm" data-toggle="tooltip"
                                                               data-placement="right"
                                                               title="สำเนาประกาศนียบัตร (pdf, png, jpg)"
                                                               id="id4Btn_<?= $filesStudyCertIndex; ?>"
                                                               style="margin:0rem!important;"><i
                                                                    class="far fa-plus-square text-success"></i><input
                                                                    type="file" style="display:none;"
                                                                    name="Files_<?= $filesStudyCertIndex; ?>"
                                                                    id="id4Files_<?= $filesStudyCertIndex; ?>"
                                                                    onchange="updateFilesAll('<?= $filesStudyCertIndex; ?>', 'filesMilCert', 'userProfile.php')"></label>
                                                        <span id="span4_<?= $filesStudyCertIndex; ?>"></span>
                                                    </td>
                                                    <td class="text-right">
                                                        <span data-toggle="modal" data-target="#id4EditStudyModal"
                                                              data-schid="<?= $sqlfet_listStudyData['id']; ?>"
                                                              data-schname="<?= $sqlfet_listStudyData['school_name']; ?>"
                                                              data-schvel="<?= $sqlfet_listStudyData['school_level']; ?>"
                                                              data-schbrn="<?= $sqlfet_listStudyData['school_branch']; ?>"
                                                              data-schmaj="<?= $sqlfet_listStudyData['school_major']; ?>"
                                                              data-schyrs="<?= $sqlfet_listStudyData['school_year']; ?>">
                                                        <a data-toggle="tooltip" data-placement="top" title="แก้ไข"
                                                           href="#Box2"><i class="far fa-edit text-primary"></i></a>
                                                        </span>

                                                        <!--<a data-toggle="tooltip" data-placement="top" title="แก้ไข"
                                                           href="#"><i class="far fa-edit text-primary"></i></a>-->
                                                        <a data-toggle="tooltip" data-placement="top" title="ลบ"
                                                           href="./userStudyAct.php?command=delStudyData&id2delete=<?= $sqlfet_listStudyData['id']; ?>"
                                                           onclick="return confirm('ต้องการลบข้อมูลนี้')"><i
                                                                    class="far fa-times-circle text-danger"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 table-responsive text-danger text-center">
                                    <h5>ไม่มีข้อมูล</h5>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div><!-- End of Card#02 -->
            </div>
        </div><!-- End of Box#02 -->

        <!-- Box#03 -->
        <div class="row mt-3" id="Box3">
            <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                <!-- Card #03 -->
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลคุณวุฒิทางการศึกษาทหาร</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <span data-toggle="modal" data-target="#id4MilStudyModal">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="เพิ่มข้อมูล"><i
                                            class="fas fa-plus font-weight-bold text-success pr-3"></i></a>
                                </span>
                            </div><!-- Toggle switch -->
                        </div>

                        <?php
                        $cntData = countDB('mas_milcourse', 'mil_number', $milNumber, 2);
                        if ($cntData > '0') {
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>หลักสูตร</th>
                                            <th>จัดโดย</th>
                                            <th>ระยะเวลา</th>
                                            <th>สำเนาประกาศนียบัตร</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sqlcmd_listCourse = "SELECT * FROM mas_milcourse WHERE mil_number='" . $milNumber . "'";
                                        $sqlres_listCourse = mysqli_query($dbConn, $sqlcmd_listCourse);
                                        if ($sqlres_listCourse) {
                                            while ($sqlfet_listCourse = mysqli_fetch_assoc($sqlres_listCourse)) {
                                                ?>
                                                <tr>
                                                    <td><?= $sqlfet_listCourse['course_name']; ?></td>
                                                    <td><?= $sqlfet_listCourse['course_opener']; ?></td>
                                                    <td><?= $sqlfet_listCourse['course_year']; ?></td>
                                                    <td>
                                                        <?php
                                                        $sqlcmd_listMilCourse = "SELECT * FROM mas_milcourse WHERE id=" . $sqlfet_listCourse['id'];
                                                        $sqlres_listMilCourse = mysqli_query($dbConn, $sqlcmd_listMilCourse);
                                                        if ($sqlres_listMilCourse)
                                                            $sqlfet_listMilCourse = mysqli_fetch_assoc($sqlres_listMilCourse);

                                                        $filesMilCertIndex = $milNumber . "MilCert" . $sqlfet_listMilCourse['id'];
                                                        ?>
                                                        <?= chkFileExists($filesMilCertIndex, 'filesMilCert', 'สำเนาประกาศนียบัตร'); ?>
                                                        <label class="btn btn-sm" data-toggle="tooltip"
                                                               data-placement="right"
                                                               title="สำเนาประกาศนียบัตร (pdf, png, jpg)"
                                                               id="id4Btn_<?= $filesMilCertIndex; ?>"
                                                               style="margin:0rem!important;"><i
                                                                    class="far fa-plus-square text-success"></i><input
                                                                    type="file" style="display:none;"
                                                                    name="Files_<?= $filesMilCertIndex; ?>"
                                                                    id="id4Files_<?= $filesMilCertIndex; ?>"
                                                                    onchange="updateFilesAll('<?= $filesMilCertIndex; ?>', 'filesMilCert', 'userProfile.php')"></label>
                                                        <span id="span4_<?= $filesMilCertIndex; ?>"></span>
                                                    </td>
                                                    <td style="text-align: right">
                                                        <span data-toggle="modal" data-target="#id4EditMilStudyModal"
                                                              data-crsid="<?= $sqlfet_listCourse['id']; ?>"
                                                              data-crsname="<?= $sqlfet_listCourse['course_name']; ?>"
                                                              data-crsoper="<?= $sqlfet_listCourse['course_opener']; ?>"
                                                              data-crsyear="<?= $sqlfet_listCourse['course_year']; ?>">
                                                        <a data-toggle="tooltip" data-placement="top" title="แก้ไข"
                                                           href="#Box3"><i class="far fa-edit text-primary"></i></a>
                                                        </span>
                                                        <a data-toggle="tooltip" data-placement="top" title="ลบ"
                                                           href="./userStudyAct.php?command=delCourseData&id2delete=<?= $sqlfet_listCourse['id']; ?>"
                                                           onclick="return confirm('ต้องการลบข้อมูลนี้')"><i
                                                                    class="far fa-times-circle text-danger"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="row mt-3">
                                <div class="col-12 table-responsive text-danger text-center">
                                    <h5>ไม่มีข้อมูล</h5>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                </div><!-- Card #03 -->
            </div>
        </div><!-- End of Box#03 -->

        <!-- Box#04 -->
        <div class="row mt-3 mb-5" id="Box4">
            <div class="col-md-10 offset-md-1 d-flex justify-content-center">

                <!-- Card #04 -->
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลการรับราชการ</h5></div>
                        </div>

                        <!-- Box4Row1 -->
                        <div class="row mt-3" id="Box4Row1">
                            <div class="col-3"><label for="id4DateGovStart">บรรจุเข้ารับราชการเมื่อ</label>
                            </div>
                            <div class="col-3">
                                <input type="text" name="" id="id4DateGovStart" class="form-control form-control-sm"
                                       disabled value="<?= monthThai($pfDateInGov); ?>">
                            </div>
                            <div class="col-3 text-md-right"><label
                                        for="id4SumDateInGov">รวมระยะเวลารับราชการ</label>
                            </div>
                            <div class="col-3">
                                <input type="text" name="" id="id4SumDateInGov"
                                       class="form-control form-control-sm" disabled value="<?php
                                if (!empty($pfDateInGov)) {
                                    list($yy, $mm, $dd) = explode(",", dateDiff($pfDateInGov, dateBE($dateIsNow)));
                                    if ($yy < 60) {
                                        if ($yy != 0)
                                            echo $yy . " ปี ";
                                        if ($mm != 0)
                                            echo $mm . " เดือน ";
                                        if ($dd != 0)
                                            echo $dd . " วัน";
                                    } else
                                        echo "-";
                                } else
                                    echo "อายุ ปี เดือน วัน";
                                ?>">
                            </div>
                        </div><!-- in Gov infomation -->

                        <!-- Box4Row2 -->
                        <div class="row mt-3" id="Box4Row2">
                            <div class="col-8"><label for="id4MilSumDateWork">การปฏิบัติหน้าที่ครูทหาร/ครูวิชาการ
                                    ก่อนดำรงตำแหน่งปัจจุบัน รวมเป็นระยะเวลา</label>
                            </div>
                            <div class="col-3 offset-1">
                                <input type="text" name="" id="id4MilSumDateWork"
                                       class="form-control form-control-sm"
                                       readonly value="">
                                <!-- onclick="milSumDateWork()" placeholder="คลิกเพื่ออัพเดทข้อมูล"> -->
                            </div>
                        </div><!-- Box4Row2 -->

                        <!-- Box4Row3 -->
                        <div class="row mt-3" id="Box4Row3">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr class="bg-light">
                                        <th>ดำรงตำแหน่ง</th>
                                        <th>คำสั่ง</th>
                                        <th>สำเนาคำสั่ง</th>
                                        <th>ระยะเวลา</th>
                                        <th class="" style="text-align: right">
                                            <!-- Toggle switch -->
                                            <span data-toggle="modal" data-target="#id4MilWorkModal">
                                                    <a href="#Box4" data-toggle="tooltip" data-placement="top"
                                                       title="เพิ่มข้อมูล"><i
                                                                class="fas fa-plus font-weight-bold text-success"></i></a>
                                                </span><!-- Toggle switch -->
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ySum = 0;
                                    $mSum = 0;
                                    $dSum = 0;
                                    $sqlcmd_listMilWork = "SELECT * FROM mas_milwork WHERE mil_number='" . $milNumber . "' AND mil_workisnow='0' ORDER BY mil_workstart";
                                    $sqlres_listMilWork = mysqli_query($dbConn, $sqlcmd_listMilWork);
                                    if ($sqlres_listMilWork) {
                                        while ($sqlfet_listMilWork = mysqli_fetch_assoc($sqlres_listMilWork)) {
                                            ?>
                                            <tr>
                                                <td><?= $sqlfet_listMilWork['mil_position']; ?></td>
                                                <td><?= $sqlfet_listMilWork['mil_command']; ?></td>
                                                <td><!--< upload file command >-->
                                                    <?php
                                                    $fileCmdIndex = $milNumber . "Cmd" . $sqlfet_listMilWork['id'];
                                                    // echo $fileCmdIndex;
                                                    ?>
                                                    <?= chkFileExists($fileCmdIndex, 'filesCmd', 'คำสั่ง'); ?>
                                                    <label class="btn btn-sm" data-toggle="tooltip"
                                                           data-placement="right" title="สำเนาคำสั่ง (pdf, png, jpg)"
                                                           id="id4BtnCmd_<?= $fileCmdIndex; ?>"
                                                           style="margin:0;!important"><i
                                                                class="far fa-plus-square text-success"></i><input
                                                                type="file" style="display:none;margin:0;!important"
                                                                name="cmdFiles_<?= $fileCmdIndex; ?>"
                                                                id="id4CmdFiles_<?= $fileCmdIndex; ?>"
                                                                onchange="updFile2Upload('<?= $fileCmdIndex; ?>', 'filesCmd', 'userProfile.php')"></label><span
                                                            id="span4Cmd_<?= $fileCmdIndex; ?>"></span>
                                                </td>
                                                <td><?php
                                                    $milWorkStart = substr($sqlfet_listMilWork['mil_workstart'], 0, 11);
                                                    $milWorkStop = substr($sqlfet_listMilWork['mil_workstop'], 0, 11);
                                                    ?>
                                                    <div><?= monthThai(dateBE($milWorkStart)) . " ถึง " . monthThai(dateBE($milWorkStop)); ?></div>
                                                    <div>(<?php
                                                        if (!empty($pfDateInGov)) {
                                                            list($yy, $mm, $dd) = explode(",", dateDiff($milWorkStart, $milWorkStop));
                                                            if ($yy < 60) {
                                                                if ($yy != 0)
                                                                    echo $yy . " ปี ";
                                                                if ($mm != 0)
                                                                    echo $mm . " เดือน ";
                                                                if ($dd != 0)
                                                                    echo $dd . " วัน";
                                                            } else
                                                                echo "ข้อมูลผิดพลาด";
                                                        } else
                                                            echo "อายุ ปี เดือน วัน";
                                                        ?>)
                                                    </div>
                                                </td>
                                                <td style="text-align:right;">
                                                    <span data-toggle="modal" data-target="#id4EditMilWorkModal"
                                                          data-wrkid="<?= $sqlfet_listMilWork['id']; ?>"
                                                          data-wrkpos="<?= $sqlfet_listMilWork['mil_position']; ?>"
                                                          data-wrkcmd="<?= $sqlfet_listMilWork['mil_command']; ?>"
                                                          data-wrkstart="<?= monthThai(dateBE(substr($sqlfet_listMilWork['mil_workstart'], 0, 10))); ?>"
                                                          data-wrkstop="<?= monthThai(dateBE(substr($sqlfet_listMilWork['mil_workstop'], 0, 10))); ?>">
                                                    <a data-toggle="tooltip" data-placement="top" title="แก้ไข"
                                                       href="#Box4"><i class="far fa-edit text-primary"></i></a>
                                                    </span>
                                                    <a data-toggle="tooltip" data-placement="top" title="ลบ"
                                                       href="./userWorkAct.php?command=delCourseData&id2Delete=<?= $sqlfet_listMilWork['id']; ?>#Box4"
                                                       onclick="return confirm('ต้องการลบข้อมูลนี้')"><i
                                                                class="far fa-times-circle text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $dSum += $dd;
                                            if ($dSum > 30) {
                                                $mSum += floor($dSum / 30);
                                                $dSum = $dSum % 30;
                                            }
                                            $mSum += $mm;
                                            if ($mSum > 12) {
                                                $ySum += floor($mSum / 12);
                                                $mSum = $mSum % 12;
                                            }
                                            $ySum += $yy;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            รวมระยะเวลาปฏิบัติงานตามหน้าที่รับผิดชอบดานการเรียนการสอน
                                        </td>
                                        <td class="font-weight-bold">
                                            <?php
                                            if ($ySum < 60) {
                                                $milSumDateWork = $ySum . " ปี " . $mSum . " เดือน " . $dSum . " วัน";
                                                echo $milSumDateWork;
                                            } else {
                                                echo "ข้อมูลผิดพลาด";
                                            }
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div><!-- Box4Row3 -->

                        <!-- Box4Row4 -->
                        <div class="row mt-3" id="Box4Row4">
                            <div class="col-3"><label for="id4ASNow">ปัจจุบันดำรงตำแหน่งประเภทวิทยฐานะ</label></div>

                            <div class="col-4">
                                <?php
                                $sqlcmd_milWorkNow = "SELECT * FROM mas_milwork WHERE mil_number='" . $milNumber . "' AND mil_workisnow='1'";
                                $sqlres_milWorkNow = mysqli_query($dbConn, $sqlcmd_milWorkNow);
                                if ($sqlres_milWorkNow)
                                    $sqlfet_milWorkNow = mysqli_fetch_assoc($sqlres_milWorkNow);

                                $milWorkPosNow = $sqlfet_milWorkNow['mil_position'];
                                $milWorkPosNowDateIn = $sqlfet_milWorkNow['mil_workstart'];
                                ?>
                                <input type="text" name="" id="id4ASNow" class="form-control form-control-sm"
                                       disabled value="<?php
                                if (!empty($milWorkPosNow)) {
                                    echo $milWorkPosNow;
                                } else
                                    echo "ยังไม่ได้บันทึกข้อมูล";
                                ?>">
                            </div>
                            <div class="col-2 text-right">
                                <?php
                                $sqlcmd_getWrkNowID = "SELECT * FROM mas_milwork WHERE mil_number='" . $milNumber . "' AND mil_workisnow='1'";
                                $sqlres_getWrkNowID = mysqli_query($dbConn, $sqlcmd_getWrkNowID);
                                if ($sqlres_getWrkNowID) {
                                    $sqlfet_getWrkNowID = mysqli_fetch_assoc($sqlres_getWrkNowID);
                                }
                                $nowID = $sqlfet_getWrkNowID['id'];
                                if (!empty($nowID)) {
                                    $fileCmdIndex = $milNumber . "Cmd" . $nowID;
                                    ?>
                                    <?= chkFileExists($fileCmdIndex, 'filesCmd', 'คำสั่ง'); ?>
                                    <label class="btn btn-sm" data-toggle="tooltip"
                                           data-placement="right" title="สำเนาคำสั่ง (pdf, png, jpg)"
                                           id="id4BtnCmd_<?= $fileCmdIndex; ?>" style="margin:0rem!important;"><i
                                                class="far fa-plus-square text-success"></i><input
                                                type="file" style="display:none;"
                                                name="cmdFiles_<?= $fileCmdIndex; ?>"
                                                id="id4CmdFiles_<?= $fileCmdIndex; ?>"
                                                onchange="updFile2Upload('<?= $fileCmdIndex; ?>', 'filesCmd', 'userProfile.php')"></label>
                                    <span
                                            id="span4Cmd_<?= $fileCmdIndex; ?>"></span>

                                    <!--<a href="#Box4Row4" data-toggle="tooltip" data-placement="top"
                                       title="ไฟล์หลักฐาน (pdf หรือ png หรือ jpg)"><i
                                                class="far fa-plus-square text-success"></i></a>-->

                                    <span data-toggle="modal" data-target="#id4EditMilWorkNowModal"
                                          data-wrkid="<?= $nowID; ?>"
                                          data-wrkpos="<?= $sqlfet_milWorkNow['mil_position']; ?>"
                                          data-wrkcmd="<?= $sqlfet_milWorkNow['mil_command']; ?>"
                                          data-wrkstart="<?= monthThai(dateBE(substr($sqlfet_milWorkNow['mil_workstart'], 0, 10))); ?>">
                                                    <a data-toggle="tooltip" data-placement="top" title="แก้ไข"
                                                       href="#Box4"><i class="far fa-edit text-primary"></i></a>
                                                    </span>

                                    <!--<a data-toggle="tooltip" data-placement="top" title="แก้ไข"
                                       href="#BoxRow4"><i class="far fa-edit text-primary"></i></a>-->
                                    <a data-toggle="tooltip" data-placement="top" title="ลบ"
                                       href="./userWorkAct.php?command=delCourseData&id2Delete=<?= $nowID; ?>#Box4"
                                       onclick="return confirm('ต้องการลบข้อมูลนี้')"><i
                                                class="far fa-times-circle text-danger"></i></a>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--
                            <div class="col-3">
                                <input type="text" name="" id="" class="form-control form-control-sm" disabled
                                       value="<? /*= getValue('mas_as', 'as_number', $pfASNow, 1, 'as_name'); */ ?>">
                            </div> -->
                            <div class="col-1 text-md-right">
                                <label for="id4DateASNowStart">เมื่อวันที่</label>
                            </div>

                            <div class="col-2">
                                <input type="text" name="" id="id4DateASNowStart"
                                       class="form-control form-control-sm"
                                       value="<?php
                                       if (!empty($milWorkPosNowDateIn))
                                           echo monthThai(dateBE(substr($milWorkPosNowDateIn, 0, 10)));
                                       else
                                           echo "-";
                                       ?>"
                                       disabled>
                            </div>

                        </div><!-- Box4Row4 -->

                        <!-- Box4Row5 -->
                        <div class="row mt-3" id="Box4Row5">

                            <div class="col-3">
                                <label for="id4SumDate2Show">รวมดำรงตำแหน่งวิทยะฐานะปัจจุบัน</label>
                            </div>
                            <div class="col-2">
                                <?php
                                //$tmpStart = substr($sqlfet_milWorkNow['mil_workstart'], 0, 11);
                                //echo $pfDateASNow;
                                $dateWorkNowStart = substr($milWorkPosNowDateIn, 0, 10);
                                list($yy, $mm, $dd) = explode(",", dateDiff($dateWorkNowStart, $dateNow));
                                $date2Show = '';
                                if ($yy < 60) {
                                    if ($yy != 0)
                                        $date2Show .= $yy . " ปี ";
                                    if ($mm != 0)
                                        $date2Show .= $mm . " เดือน ";
                                    if ($dd != 0)
                                        $date2Show .= $dd . " วัน";
                                } else
                                    $date2Show = "ข้อมูลผิดพลาด";
                                ?>
                                <input type="text" name="" id="id4SumDate2Show" class="form-control form-control-sm"
                                       value="<?= $date2Show; ?>" disabled>
                            </div>

                            <div class="col-5"><label for="id4SumDateTeach">รวมระยะเวลาปฏิบัติงานตามหน้าที่รับผิดชอบด้านการเรียนการสอนทั้งสิ้น</label>
                            </div>
                            <div class="col-2">
                                <input type="text" name="" id="id4SumDateTeach" class="form-control form-control-sm"
                                       value="<?php
                                       $yyW = $ySum + $yy;
                                       $mmW = $mSum + $mm;
                                       $ddW = $dSum + $dd;
                                       if ($$yyW < 60) {
                                           if ($ddW > 30) {
                                               $mmW += floor($ddW / 30);
                                               $ddW = $ddW % 30;
                                           }

                                           if ($mmW > 12) {
                                               $yyW += floor($mmW / 12);
                                               $mmW = $mmW % 12;
                                           }

                                           echo $yyW . " ปี " . $mmW . " เดือน " . $ddW . " วัน";
                                       } else {
                                           echo "ข้อมูลผิดพลาด";
                                       }
                                       ?>" disabled>
                            </div>
                        </div><!-- Box4Row5 -->

                    </div>

                </div><!-- Card #04 -->
            </div>
        </div><!-- End of Box#04 -->

    </div>

    <!-- Modal for study -->
    <div class="modal fade" id="id4StudyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลคุณวุฒิทางการศึกษา</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./userStudyAct.php" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="id4SchoolLevel">ระดับการศึกษา</label>
                                <select name="schoolLevel" id="id4SchoolLevel"
                                        class="form-control form-control-sm" required>
                                    <option value="1">ตำกว่าปริญญาตรี</option>
                                    <option value="2">ระดับปริญญาตรี</option>
                                    <option value="3">ระดับปริญญาโท</option>
                                    <option value="4">ระดับปริญญาเอก</option>
                                    <option value="5">หลังปริญญาเอก</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <label for="id4SchoolName">ชื่อสถาบันการศึกษา</label>
                                <input type="text" name="schoolName" id="id4SchoolName"
                                       class="form-control form-control-sm" placeholder="ชื่อสถาบันการศึกษา">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="id4YrFinish">ปีที่สำเร็จการศึกษา</label>
                                <input type="text" name="yrFinish" id="id4YrFinish"
                                       class="form-control form-control-sm"
                                       placeholder="ปีที่สำเร็จการศึกษา">
                            </div>
                            <div class="col-4">
                                <label for="id4SchoolBranch">สาขาที่สำเร็จการศึกษา</label>
                                <input type="text" name="schoolBranch" id="id4SchoolBranch"
                                       class="form-control form-control-sm" placeholder="สาขาที่สำเร็จการศึกษา">
                            </div>
                            <div class="col-4">
                                <label for="id4SchoolMajor">วิชาเอกที่สำเร็จการศึกษา</label>
                                <input type="text" name="schoolMajor" id="id4SchoolMajor"
                                       class="form-control form-control-sm" placeholder="วิชาเอกที่สำเร็จการศึกษา">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="addDataStudy">
                    <input type="hidden" name="milNumber" value="<?= $milNumber; ?>">
                </form>
            </div>
        </div>
    </div><!-- Modal for study -->

    <!-- Modal for edit study -->
    <div class="modal fade" id="id4EditStudyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลคุณวุฒิทางการศึกษา</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./userStudyAct.php" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="id_100 col-4">
                                <label for="id4EditSchoolLevel">ระดับการศึกษา</label>
                                <select name="schoolLevel" id="id4EditSchoolLevel"
                                        class="form-control form-control-sm" required>
                                    <option value="1">ตำกว่าปริญญาตรี</option>
                                    <option value="2">ระดับปริญญาตรี</option>
                                    <option value="3">ระดับปริญญาโท</option>
                                    <option value="4">ระดับปริญญาเอก</option>
                                    <option value="5">หลังปริญญาเอก</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <label for="id4EditSchoolName">ชื่อสถาบันการศึกษา</label>
                                <input type="text" name="schoolName" id="id4EditSchoolName"
                                       class="form-control form-control-sm" placeholder="ชื่อสถาบันการศึกษา">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="id4EditYrFinish">ปีที่สำเร็จการศึกษา</label>
                                <input type="text" name="yrFinish" id="id4EditYrFinish"
                                       class="form-control form-control-sm"
                                       placeholder="ปีที่สำเร็จการศึกษา">
                            </div>
                            <div class="col-4">
                                <label for="id4EditSchoolBranch">สาขาที่สำเร็จการศึกษา</label>
                                <input type="text" name="schoolBranch" id="id4EditSchoolBranch"
                                       class="form-control form-control-sm" placeholder="สาขาที่สำเร็จการศึกษา">
                            </div>
                            <div class="col-4">
                                <label for="id4EditSchoolMajor">วิชาเอกที่สำเร็จการศึกษา</label>
                                <input type="text" name="schoolMajor" id="id4EditSchoolMajor"
                                       class="form-control form-control-sm" placeholder="วิชาเอกที่สำเร็จการศึกษา">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="editDataStudy">
                    <!--                    <input type="hidden" name="milNumber" value="-->
                    <? //= $milNumber; ?><!--">-->
                    <input type="hidden" name="id2edit" id="id4ID2EditStudy" value="">
                </form>
            </div>
        </div>
    </div><!-- Modal for edit study -->

    <!-- Modal for military study -->
    <div class="modal fade" id="id4MilStudyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลคุณวุฒิทางการศึกษาทางทหาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./userStudyAct.php" method="post">

                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="id4CourseName">หลักสูตร</label>
                                <input type="text" name="courseName" id="id4CourseName"
                                       class="form-control form-control-sm"
                                       placeholder="ชื่อหลักสูตร">
                            </div>
                            <div class="col-4">
                                <label for="id4CourseOpener">จัดโดย</label>
                                <input type="text" name="courseOpener" id="id4CourseOpener"
                                       class="form-control form-control-sm" placeholder="หน่วยงานที่จัดฝึกอบรม">
                            </div>
                            <div class="col-4">
                                <label for="id4CourseYear">วัน-เวลาที่ฝึกอบรม</label>
                                <input type="text" name="courseYear" id="id4CourseYear"
                                       class="form-control form-control-sm" placeholder="วัน-เวลาที่ฝึกอบรม">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="addMilCourse">
                    <input type="hidden" name="milNumber" value="<?= $milNumber; ?>">
                </form>
            </div>
        </div>
    </div><!-- Modal for military study -->

    <!-- Modal for edit military study -->
    <div class="modal fade" id="id4EditMilStudyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลคุณวุฒิทางการศึกษาทางทหาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./userStudyAct.php" method="post">

                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col-4">
                                <label for="id4CourseName">หลักสูตร</label>
                                <input type="text" name="courseName" id="id4EditCourseName"
                                       class="form-control form-control-sm"
                                       placeholder="ชื่อหลักสูตร">
                            </div>
                            <div class="col-4">
                                <label for="id4CourseOpener">จัดโดย</label>
                                <input type="text" name="courseOpener" id="id4EditCourseOpener"
                                       class="form-control form-control-sm" placeholder="หน่วยงานที่จัดฝึกอบรม">
                            </div>
                            <div class="col-4">
                                <label for="id4CourseYear">วัน-เวลาที่ฝึกอบรม</label>
                                <input type="text" name="courseYear" id="id4EditCourseYear"
                                       class="form-control form-control-sm" placeholder="วัน-เวลาที่ฝึกอบรม">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="editMilCourse">
                    <input type="hidden" name="milNumber" value="<?= $milNumber; ?>">
                    <input type="hidden" name="id2edit" id="id4ID2EditMilCourse" value="">
                </form>
            </div>
        </div>
    </div><!-- Modal for edit military study -->

    <!-- Modal for military work -->
    <div class="modal fade" id="id4MilWorkModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการรับราชการ</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="./userWorkAct.php" method="post">

                    <div class="modal-body">
                        <div class="row mt-3">

                            <!-- Toggle switch -->
                            <div class="col-6 pl-5 custom-control custom-switch d-flex justify-content-start">
                                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2">เป็นตำแหน่งปัจจุบัน</label>
                            </div><!-- Toggle switch -->

                        </div>

                        <div class="row mt-3 px-3">
                            <div class="col-3">
                                <label for="id4MilWorkPos">ดำรงตำแหน่ง</label>
                                <input type="text" name="milWorkPos" id="id4MilWorkPos"
                                       class="form-control form-control-sm"
                                       placeholder="ตำแหน่งงาน" value="">
                            </div>
                            <div class="col-3 pl-2">
                                <label for="id4MilWorkCmd">คำสั่ง</label>
                                <input type="text" name="milWorkCmd" id="id4MilWorkCmd"
                                       class="form-control form-control-sm"
                                       placeholder="คำสั่งให้ดำรงตำแหน่ง">
                            </div>
                            <div class="col-3 pl-2">
                                <label for="id4MilWorkStart">ตั้งแต่</label>
                                <input type="text" name="milWorkStart" id="id4MilWorkStart"
                                       class="form-control form-control-sm" placeholder="คลิกกรอกข้อมูล">
                            </div>
                            <div class="col-3 pl-2">
                                <label for="id4MilWorkStop">ถึง</label>
                                <input type="text" name="milWorkStop" id="id4MilWorkStop"
                                       class="form-control form-control-sm" placeholder="คลิกกรอกข้อมูล">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="addMilWork">
                    <input type="hidden" name="milNumber" value="<?= $milNumber; ?>">
                    <input type="hidden" name="milWorkIsNow" value="1" disabled id="id4MilWorkIsNow">
                </form>
            </div>
        </div>
    </div><!-- Modal for military work -->

    <!-- Modal for edit military work -->
    <div class="modal fade" id="id4EditMilWorkModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลการรับราชการ</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="./userWorkAct.php" method="post">

                    <div class="modal-body">

                        <div class="row mt-3 px-3">
                            <div class="col-3">
                                <label for="id4EditMilWorkPos">ดำรงตำแหน่ง</label>
                                <input type="text" name="milWorkPos" id="id4EditMilWorkPos"
                                       class="form-control form-control-sm"
                                       placeholder="ตำแหน่งงาน" value="">
                            </div>
                            <div class="col-3 pl-2">
                                <label for="id4EditMilWorkCmd">คำสั่ง</label>
                                <input type="text" name="milWorkCmd" id="id4EditMilWorkCmd"
                                       class="form-control form-control-sm"
                                       placeholder="คำสั่งให้ดำรงตำแหน่ง">
                            </div>
                            <div class="col-3 pl-2">
                                <label for="id4EditMilWorkStart">ตั้งแต่</label>
                                <input type="text" name="milWorkStart" id="id4EditMilWorkStart"
                                       class="form-control form-control-sm" placeholder="คลิกกรอกข้อมูล">
                            </div>
                            <div class="col-3 pl-2">
                                <label for="id4EditMilWorkStop">ถึง</label>
                                <input type="text" name="milWorkStop" id="id4EditMilWorkStop"
                                       class="form-control form-control-sm" placeholder="คลิกกรอกข้อมูล">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="editMilWork">
                    <input type="hidden" name="milNumber" value="">
                    <input type="hidden" name="id2edit" id="id4ID2Edit" value="">
                    <!--                    <input type="hidden" name="milWorkIsNow" value="1" disabled id="id4MilWorkIsNow">-->
                </form>
            </div>
        </div>
    </div><!-- Modal for edit military work -->

    <!-- Modal for military present position -->
    <div class="modal fade" id="id4EditMilWorkNowModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลการรับราชการตำแหน่งปีจจุบัน</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="./userWorkAct.php" method="post">

                    <div class="modal-body">

                        <div class="row mt-3 px-3">
                            <div class="col-4">
                                <label for="id4EditMilWorkNowPos">ดำรงตำแหน่ง</label>
                                <input type="text" name="milWorkPos" id="id4EditMilWorkNowPos"
                                       class="form-control form-control-sm"
                                       placeholder="ตำแหน่งงาน" value="">
                            </div>
                            <div class="col-4 pl-2">
                                <label for="id4MilWorkCmd">คำสั่ง</label>
                                <input type="text" name="milWorkCmd" id="id4EditMilWorkNowCmd"
                                       class="form-control form-control-sm"
                                       placeholder="คำสั่งให้ดำรงตำแหน่ง">
                            </div>
                            <div class="col-4 pl-2">
                                <label for="id4MilWorkStart">ตั้งแต่</label>
                                <input type="text" name="milWorkStart" id="id4EditMilWorkNowStart"
                                       class="form-control form-control-sm" placeholder="คลิกกรอกข้อมูล">
                            </div>
                            <!--<div class="col-3 pl-2">
                                <label for="id4MilWorkStop">ถึง</label>
                                <input type="text" name="milWorkStop" id="id4EditMilWorkStop"
                                       class="form-control form-control-sm" placeholder="คลิกกรอกข้อมูล">
                            </div>-->
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                    </div>

                    <input type="hidden" name="processName" value="editMilWorkNow">
                    <input type="hidden" name="milNumber" value="">
                    <input type="hidden" name="id2edit" id="id4WorkNowID2Edit" value="">
                    <!-- <input type="hidden" name="milWorkIsNow" value="1" disabled id="id4MilWorkIsNow">-->
                </form>
            </div>
        </div>
    </div><!-- Modal for military present position -->

    <!-- Modal for edit military work -->
    <!-- Modal for edit military work -->

    <!-- Popper and Bootstrap JS -->
    <script src="./js/jquery-3.5.1.slim.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Project script -->
    <script src="./js/prjScript.js"></script>
    <script src="./js/picker_date.js"></script>
    <script src="./js/uploadFilesCmd.js"></script>
    <script src="./js/uploadFilesAll.js"></script>

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

    <!-- Date Picker -->
    <script>
        //กำหนดให้ textbox ที่มี id เท่ากับ my_date เป็นตัวเลือกแบบ ปฎิทิน
        picker_date(document.getElementById("id4DateBirth"), {year_range: "-60:+2"});
        picker_date(document.getElementById("id4DateInGov"), {year_range: "-50:+2"});
        picker_date(document.getElementById("id4DateAS"), {year_range: "-30:+2"});
        picker_date(document.getElementById("id4MilWorkStart"), {year_range: "-50:+2"});
        picker_date(document.getElementById("id4MilWorkStop"), {year_range: "-50:+2"});
        picker_date(document.getElementById("id4EditMilWorkStart"), {year_range: "-50:+2"});
        picker_date(document.getElementById("id4EditMilWorkStop"), {year_range: "-50:+2"});
        picker_date(document.getElementById("id4EditMilWorkNowStart"), {year_range: "-50:+2"});
        /*{year_range:"-12:+10"} คือ กำหนดตัวเลือกปฎิทินให้ แสดงปี ย้อนหลัง 12 ปี และ ไปข้างหน้า 10 ปี*/
    </script><!-- Date Picker -->

    <!-- Controller function for toggle button#1 -->
    <script>
        $("#customSwitch1").on("change click", function () {
            if ($("#customSwitch1").is(":checked")) {
                $("#id4Row4Button").removeClass("d-none");
                $("#id4RowMisc1").removeClass("d-none");
                $("#id4EditRow3").removeClass("d-none");
                // $("#id4Row0").removeClass("d-none");

                $("#id4Row2").addClass("d-none");
                $("#id4Row3").addClass("d-none");

                $("#if4PfNameFirst").attr("disabled", false);
                $("#if4PfNameLast").attr("disabled", false);
                $("#id4SalaryLevel").attr("disabled", false);
                $("#id4SalaryFloor").attr("disabled", false);
                $("#id4Salary").attr("disabled", false);
            } else {
                $("#id4Row4Button").addClass("d-none");
                $("#id4RowMisc1").addClass("d-none");
                $("#id4EditRow3").addClass("d-none");
                // $("#id4Row0").addClass("d-none");

                $("#id4Row2").removeClass("d-none");
                $("#id4Row3").removeClass("d-none");

                $("#if4PfNameFirst").attr("disabled", true);
                $("#if4PfNameLast").attr("disabled", true);
                $("#id4SalaryLevel").attr("disabled", true);
                $("#id4SalaryFloor").attr("disabled", true);
                $("#id4Salary").attr("disabled", true);
            }
        });
    </script><!-- Controller function for toggle button#1 -->

    <!-- Controller function for toggle button#2 -->
    <script>
        let dateIsNow = '<?=$dateIsNow;?>';
        //let pfWorkPosition = '<?//=$pfWorkPosition; ?>//';
        $("#customSwitch2").on("change click", function () {
            if ($("#customSwitch2").is(":checked")) {
                // $("#id4MilWorkPos").attr("disabled", true);
                // $("#id4MilWorkPos").val(pfWorkPosition);
                $("#id4MilWorkStop").attr("disabled", true);
                $("#id4MilWorkStop").attr("placeholder", "ปัจจุบัน");
                $("#id4MilWorkStop").css("background-color", "#eaecec");
                $("#id4MilWorkIsNow").attr("disabled", false);
            } else {
                // $("#id4MilWorkPos").attr("disabled", false);
                $("#id4MilWorkStop").attr("disabled", false);
                $("#id4MilWorkStop").attr("placeholder", "คลิกกรอกข้อมูล");
                $("#id4MilWorkStop").css("background-color", "white");
                $("#id4MilWorkIsNow").attr("disabled", false);
            }
        });
    </script><!-- Controller function for toggle button#2 -->

    <script>
        let milSumDateWork = '<?=$milSumDateWork;?>';
        //let milWorkPosition = '<?//=$milWorkPosition;?>//';
        $("#id4MilSumDateWork").addClass("text-muted");
        document.getElementById("id4MilSumDateWork").value = milSumDateWork;
        // document.getElementById("id4Position").value = milWorkPosition;
        // document.getElementById("id4WorkPosition").value = milWorkPosition;
    </script>

    <!-- List and upload files -->
    <script>
        let updFile2Upload = function (filesName, filesDir, fileRet) {
            // console.log(filesName);
            // console.log(filesDir);
            // console.log(fileRet);

            let btn2Sel = document.getElementById("id4BtnCmd_" + filesName);
            let input = document.getElementById("id4CmdFiles_" + filesName);
            let output = document.getElementById("span4Cmd_" + filesName);

            btn2Sel.hidden = true;
            // console.log(input.files.length);

            for (let i = 0; i < input.files.length; ++i) {
                output.innerHTML += input.files.item(i).name;
                if ((input.files.length > 1) && (i < (input.files.length - 1)))
                    output.innerHTML += ',';
            }

            output.innerHTML += '<label class="btn btn-sm mt-2" onclick="uploadCmdFiles(\'' + filesName + '\',\'' + filesDir + '\', \'' + fileRet + '\')"><i class="fas fa-cloud-upload-alt text-success"></i></label>';
        }
    </script><!-- List and upload files -->

    <!-- Edit modal -->
    <script>
        $('#id4EditMilWorkModal').on('show.bs.modal', function (event) {
            let refev = $(event.relatedTarget);
            let wrkid = refev.data('wrkid');
            let wrkpos = refev.data('wrkpos');
            let wrkcmd = refev.data('wrkcmd');
            let wrkstart = refev.data('wrkstart');
            let wrkstop = refev.data('wrkstop');

            let modal = $(this);

            // modal.find(".modal-title").text("แก้ไขข้อมูลรายงาน");
            modal.find("#id4ID2Edit").val(wrkid);
            modal.find("#id4EditMilWorkPos").val(wrkpos);
            modal.find("#id4EditMilWorkCmd").val(wrkcmd);
            modal.find("#id4EditMilWorkStart").attr("placeholder", wrkstart + " คลิกเพื่อแก้ไข");
            modal.find("#id4EditMilWorkStop").attr("placeholder", wrkstop + " คลิกเพื่อแก้ไข");

            // modal.find("#id4MilWorkDetailsEdit").val(repdets);
            // modal.find("#id4MilWorkDetailsEdit").summernote();
            // modal.find("#id4ReportDateEdit").attr("placeholder", repdate + " คลิกแก้ไข");
            // modal.find("#id4MilWorkTopicEdit").val(reptopic);
            // modal.find(".id_100 select").val(repgrp).change();
            //  $(".id_100 select").val("val3").change();
            //option[value=" + repgrp + "]").attr("selected", "selected");
            //    $('.id_100 option[value=val2]').attr('selected','selected');
        })

        $('#id4EditMilWorkModal').on('hidden.bs.modal', function () {
            window.location.reload();
        })
    </script><!-- Edit modal -->

    <!-- Edit work now modal -->
    <script>
        $('#id4EditMilWorkNowModal').on('show.bs.modal', function (event) {
            let refev = $(event.relatedTarget);
            let wrkid = refev.data('wrkid');
            let wrkpos = refev.data('wrkpos');
            let wrkcmd = refev.data('wrkcmd');
            let wrkstart = refev.data('wrkstart');
            // let wrkstop = refev.data('wrkstop');

            let modal = $(this);
            console.log(wrkpos);

            // modal.find(".modal-title").text("xxxxxxx");
            modal.find("#id4WorkNowID2Edit").val(wrkid);
            modal.find("#id4EditMilWorkNowPos").val(wrkpos);
            modal.find("#id4EditMilWorkNowCmd").val(wrkcmd);
            modal.find("#id4EditMilWorkNowStart").attr("placeholder", wrkstart + " คลิกเพื่อแก้ไข");
            // modal.find("#id4EditMilWorkStop").attr("placeholder", wrkstop + " คลิกเพื่อแก้ไข");

            // modal.find("#id4MilWorkDetailsEdit").val(repdets);
            // modal.find("#id4MilWorkDetailsEdit").summernote();
            // modal.find("#id4ReportDateEdit").attr("placeholder", repdate + " คลิกแก้ไข");
            // modal.find("#id4MilWorkTopicEdit").val(reptopic);
            // modal.find(".id_100 select").val(repgrp).change();
            //  $(".id_100 select").val("val3").change();
            //option[value=" + repgrp + "]").attr("selected", "selected");
            //    $('.id_100 option[value=val2]').attr('selected','selected');
        })

        $('#id4EditMilWorkNowModal').on('hidden.bs.modal', function () {
            window.location.reload();
        })
    </script><!-- Edit work now modal -->

    <!-- Edit mil course -->
    <script>
        $('#id4EditMilStudyModal').on('show.bs.modal', function (event) {
            let refev = $(event.relatedTarget);
            let crsid = refev.data('crsid');
            let crsname = refev.data('crsname');
            let crsoper = refev.data('crsoper');
            let crsyear = refev.data('crsyear');

            let modal = $(this);

            // modal.find(".modal-title").text("xxxxxxx");
            modal.find("#id4ID2EditMilCourse").val(crsid);
            modal.find("#id4EditCourseName").val(crsname);
            modal.find("#id4EditCourseOpener").val(crsoper);
            modal.find("#id4EditCourseYear").val(crsyear);
        })

        $('#id4EditMilStudyModal').on('hidden.bs.modal', function () {
            window.location.reload();
            window.location.hash();
        })
    </script><!-- Edit mil course -->

    <!-- Edit study school modal -->
    <script>
        $('#id4EditStudyModal').on('show.bs.modal', function (event) {
            let refev = $(event.relatedTarget);
            let schid = refev.data('schid');
            let schvel = refev.data('schvel');
            let schname = refev.data('schname');
            let schbrn = refev.data('schbrn');
            let schmaj = refev.data('schmaj');
            let schyrs = refev.data('schyrs');

            let modal = $(this);

            // modal.find(".modal-title").text("xxxxxxx");
            modal.find("#id4ID2EditStudy").val(schid);
            modal.find("#id4EditSchoolName").val(schname);
            modal.find("#id4EditYrFinish").val(schyrs);
            modal.find("#id4EditSchoolBranch").val(schbrn);
            modal.find("#id4EditSchoolMajor").val(schmaj);
            // modal.find("#id4EditSchoolLevel").val(schvel);
            modal.find(".id_100 select").val(schvel).change();
            // modal.find(".id_100 select").val(repgrp).change();
        })

        $('#id4EditStudyModal').on('hidden.bs.modal', function () {
            window.location.reload();
            window.location.hash();
        })
    </script><!-- Edit study school modal -->

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