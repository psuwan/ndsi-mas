<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varget_command = filter_input(INPUT_GET, 'command');
$varpost_processName = filter_input(INPUT_POST, 'processName');
$milNumber = filter_input(INPUT_POST, 'milNumber');

$studyData = array(
    "schoolLevel" => filter_input(INPUT_POST, 'schoolLevel'),
    "schoolName" => filter_input(INPUT_POST, 'schoolName'),
    "yrFinish" => filter_input(INPUT_POST, 'yrFinish'),
    "schoolBranch" => filter_input(INPUT_POST, 'schoolBranch'),
    "schoolMajor" => filter_input(INPUT_POST, 'schoolMajor')
);

$schoolLevel = $studyData['schoolLevel'];
$schoolName = $studyData['schoolName'];
$yrFinish = $studyData['yrFinish'];
$schoolBranch = $studyData['schoolBranch'];
$schoolMajor = $studyData['schoolMajor'];

$courseData = array(
    "courseName" => filter_input(INPUT_POST, 'courseName'),
    "courseOpener" => filter_input(INPUT_POST, 'courseOpener'),
    "courseYear" => filter_input(INPUT_POST, 'courseYear')
);
$courseName = $courseData['courseName'];
$courseOpener = $courseData['courseOpener'];
$courseYear = $courseData['courseYear'];

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addDataStudy':
            $sqlcmd_addDataStudy = "INSERT INTO mas_userschool (mil_number, school_level, school_name, school_year, school_branch,school_major) VALUES ('$milNumber','$schoolLevel','$schoolName', '$yrFinish', '$schoolBranch', '$schoolMajor')";
            $sqlres_addDataStudy = mysqli_query($dbConn, $sqlcmd_addDataStudy);
            if ($sqlres_addDataStudy) {
                echo "<script>alert('เพิ่มข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php';</script>";
            } else {
                echo "ERROR!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            break;

        case 'addMilCourse':
            $sqlcmd_addCourseStudy = "INSERT INTO mas_milcourse (mil_number, course_name, course_opener, course_year) VALUES ('$milNumber','$courseName','$courseOpener', '$courseYear')";
            $sqlres_addCourseStudy = mysqli_query($dbConn, $sqlcmd_addCourseStudy);
            if ($sqlres_addCourseStudy) {
                echo "<script>alert('เพิ่มข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php';</script>";
            } else {
                echo "ERROR!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            break;
    }
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'delStudyData':
            deleteDB('mas_userschool', 'id', $varget_id2delete, 1);

            echo "<script>alert('ลบข้อมูลแล้ว')</script>";
            echo "<script>window.location.href='./userProfile.php';</script>";
            break;

        case 'delCourseData':
            deleteDB('mas_milcourse', 'id', $varget_id2delete, 1);

            echo "<script>alert('ลบข้อมูลแล้ว')</script>";
            echo "<script>window.location.href='./userProfile.php';</script>";
            break;
    }
}
