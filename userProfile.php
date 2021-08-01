<?php
session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');

// Get profile for milNumber
$sqlcmd_milProfile = "SELECT * FROM tbl_profiles WHERE mil_number='" . $milNumber . "'";
$sqlres_milProfile = mysqli_query($dbConn, $sqlcmd_milProfile);
if ($sqlres_milProfile) {
    $sqlnum_milProfile = mysqli_num_rows($sqlres_milProfile);
    if ($sqlnum_milProfile != 0) {
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
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">

                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลผู้ขอรับการประเมิน</h5>
                            </div>
                            <!-- Toggle switch -->
                            <div class="col-6 custom-control custom-switch d-flex justify-content-end">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label pr-3" for="customSwitch1" data-toggle="tooltip"
                                       data-placement="right" title="แก้ไขข้อมูล"></label>
                            </div><!-- Toggle switch -->
                        </div>

                        <form action="./userProfileAct.php" method="post">
                            <!-- Row #00 -->
                            <div class="row" id="id4Row0">
                                <div class="col-12">
                                    <a href="./userProfileAct.php?command=want2Up&milNumber=<?=$milNumber;?>" class="btn btn-sm btn-outline-primary">ต้องการรับการประเมินวิทยฐานะ</a>
                                </div>
                            </div>
                            <!-- Row #00 -->

                            <!-- Row #01 -->
                            <div class="row mt-3" id="id4PersonDetail">
                                <div class="col-md-6">
                                    <label for="if4PfNameFirst">ชื่อ</label>
                                    <input type="text" name="nameFirst" id="if4PfNameFirst"
                                           class="form-control form-control-sm" disabled value="<?php
                                    $rank4MilNumber = getValue('rtarf_ranks', 'rank_code', $pfRank, 2, 'rank_abbrv');
                                    if ($pfSex == '2')
                                        $rank4MilNumber .= " หญิง";
                                    echo $rank4MilNumber . " " . $pfNameFirst;
                                    $tmpRank = substr($pfRank, 2, 3);
                                    if ((intval($tmpRank) > 203) && (intval($tmpRank) < 210))
                                        echo " ร.น.";
                                    ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="if4PfNameLast">สกุล</label>
                                    <input type="text" name="nameLast" id="if4PfNameLast"
                                           class="form-control form-control-sm" disabled value="<?= $pfNameLast; ?>">
                                </div>
                            </div><!-- Row #01 -->

                            <!-- Row Misc #01 -->
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
                                               list($yy, $mm, $dd) = explode(",", dateDiff($pfDateBirth, dateBE($dateNow)));
                                               if ($yy != 0)
                                                   echo $yy . " ปี ";
                                               if ($mm != 0)
                                                   echo $mm . " เดือน ";
                                               if ($dd != 0)
                                                   echo $dd . " วัน";
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
                                        if ($yy != 0)
                                            echo $yy . " ปี ";
                                        if ($mm != 0)
                                            echo $mm . " เดือน ";
                                        if ($dd != 0)
                                            echo $dd . " วัน";
                                    } else
                                        echo "อายุ ปี เดือน วัน";
                                    ?>"
                                           disabled value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="id4Position">ตำแหน่ง</label>
                                    <input type="text" name="position" id="id4Position"
                                           class="form-control form-control-sm" placeholder="ตำแหน่งงาน" disabled
                                           value="<?= $pfWorkPosition; ?>">
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
                                    <label for="">ปัจจุบันมีวิทยฐานะระดับ</label>
                                    <input type="text" name="" id="" class="form-control form-control-sm"
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
                                                   if ($yy != 0)
                                                       echo $yy . " ปี ";
                                                   if ($mm != 0)
                                                       echo $mm . " เดือน ";
                                                   if ($dd != 0)
                                                       echo $dd . " วัน";
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
                                           class="form-control form-control-sm" placeholder="ตำแหน่งงาน"
                                           value="<?= $pfWorkPosition; ?>">
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
                                    <label for="id4DateAS">วันที่ได้รับวิทยฐานะ</label>
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
                                    <label for="id4SalaryFloor">ชั้น</label>
                                    <input type="text" name="salaryFloor" id="id4SalaryFloor"
                                           class="form-control form-control-sm text-center" placeholder="ชั้นเงินเดือน"
                                           disabled value="<?= $pfSalaryFloor; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="id4Salary">จำนวนเงินเดือน</label>
                                    <input type="text" name="salary" id="id4Salary"
                                           class="form-control form-control-sm text-center" placeholder="จำนวนเงินเดือน"
                                           disabled value="<?= $pfSalary; ?>">
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

                        </form>

                    </div>
                </div>

            </div>
        </div>

        <!-- Card #02 -->
        <div class="row mt-5">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลคุณวุฒิทางการศึกษา</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <span data-toggle="modal" data-target="#id4StudyModal">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="เพิ่มข้อมูล"><i
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
                                        <tr>
                                            <thead>
                                            <th>สถาบันการศึกษา</th>
                                            <th>สาขา</th>
                                            <th>วิชาเอก</th>
                                            <th>ปีที่สำเร็จการศึกษา</th>
                                            <th></th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                        <?php
                                        $sqlcmd_listStudyData = "SELECT * FROM mas_userschool WHERE mil_number='" . $milNumber . "' ORDER BY school_level ASC, school_year ASC";
                                        $sqlres_listStudyData = mysqli_query($dbConn, $sqlcmd_listStudyData);
                                        if ($sqlres_listStudyData) {
                                            while ($sqlfet_listStudyData = mysqli_fetch_assoc($sqlres_listStudyData)) {
                                                ?>
                                                <tr>
                                                    <td><?= $sqlfet_listStudyData['school_name']; ?></td>
                                                    <td><?= $sqlfet_listStudyData['school_branch']; ?></td>
                                                    <td><?= $sqlfet_listStudyData['school_major']; ?></td>
                                                    <td><?= $sqlfet_listStudyData['school_year']; ?></td>
                                                    <td>
                                                        <a href="./userStudyAct.php?command=delStudyData&id2delete=<?= $sqlfet_listStudyData['id']; ?>"
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
                            <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div><!-- Card #02 -->

        <!-- Card #03 -->
        <div class="row mt-5">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 d-flex justify-content-center">
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $milNumber; ?></h6>
                        <div class="row">
                            <div class="col-6"><h5 class="card-title">ข้อมูลคุณวุฒิทางการศึกษาทหาร</h5></div>
                            <!-- Toggle switch -->
                            <div class="col-6 d-flex justify-content-end">
                                <span data-toggle="modal" data-target="#id4MilStudyModal">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="เพิ่มข้อมูล"><i
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
                                        <tr>
                                            <thead>
                                            <th>หลักสูตร</th>
                                            <th>จัดโดย</th>
                                            <th>ระยะเวลา</th>
                                            <th></th>
                                            </thead>
                                        </tr>
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
                                                        <a href="./userStudyAct.php?command=delCourseData&id2delete=<?= $sqlfet_listCourse['id']; ?>"
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
                            <?
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- Card #03 -->
</div>

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
                            <label for="id4ScoolLevel">ระดับการศึกษา</label>
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
                            <input type="text" name="yrFinish" id="id4YrFinish" class="form-control form-control-sm"
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
                            <label for="id4YrFinish">หลักสูตร</label>
                            <input type="text" name="courseName" id="id4CourseName" class="form-control form-control-sm"
                                   placeholder="ชือ่หลักสูตร">
                        </div>
                        <div class="col-4">
                            <label for="id4SchoolBranch">จัดโดย</label>
                            <input type="text" name="courseOpener" id="id4CourseOpener"
                                   class="form-control form-control-sm" placeholder="หน่วยงานที่จัดฝึกอบรม">
                        </div>
                        <div class="col-4">
                            <label for="id4SchoolMajor">วัน-เวลาที่ฝึกอบรม</label>
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

<!-- Tooltips bootstrap -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    //กำหนดให้ textbox ที่มี id เท่ากับ my_date เป็นตัวเลือกแบบ ปฎิทิน
    picker_date(document.getElementById("id4DateBirth"), {year_range: "-60:+2"});
    picker_date(document.getElementById("id4DateInGov"), {year_range: "-50:+2"});
    picker_date(document.getElementById("id4DateAS"), {year_range: "-30:+2"});
    /*{year_range:"-12:+10"} คือ กำหนดตัวเลือกปฎิทินให้ แสดงปี ย้อนหลัง 12 ปี และ ไปข้างหน้า 10 ปี*/
</script>

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
</script>

</body>
</html>