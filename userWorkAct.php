<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$milNumber = filter_input(INPUT_POST, 'milNumber');
$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_milWorkPos = filter_input(INPUT_POST, 'milWorkPos');
$varpost_milWorkCmd = filter_input(INPUT_POST, 'milWorkCmd');
$varpost_milWorkStart = filter_input(INPUT_POST, 'milWorkStart');
$varpost_milWorkStop = filter_input(INPUT_POST, 'milWorkStop');
$varpost_milWorkIsNow = filter_input(INPUT_POST, 'milWorkIsNow');

// Get variable section
$varget_command = filter_input(INPUT_GET, 'command');
$varget_id2Delete = filter_input(INPUT_GET, 'id2Delete');

if (empty($varpost_milWorkIsNow))
    $varpost_milWorkIsNow = 0;

if (!empty($varpost_milWorkStart))
    $varpost_milWorkStart = dateAD($varpost_milWorkStart) . " 08:00:00";
else
    $varpost_milWorkStart = "1900-01-01 08:00:00";

if (!empty($varpost_milWorkStop))
    $varpost_milWorkStop = dateAD($varpost_milWorkStop) . " 08:00:00";
else
    $varpost_milWorkStop = "1900-01-01 08:00:00";

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addMilWork':
            $sqlcmd_addMilWork = "INSERT INTO mas_milwork (mil_number, mil_position, mil_command, mil_numext, mil_workstart, mil_workstop, mil_workisnow) VALUES ('$milNumber', '$varpost_milWorkPos', '$varpost_milWorkCmd','', '$varpost_milWorkStart', '$varpost_milWorkStop', '$varpost_milWorkIsNow')";
            $sqlres_addMilWork = mysqli_query($dbConn, $sqlcmd_addMilWork);
            if ($sqlres_addMilWork) {
                echo "<script>alert('เพิ่มข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php'</script>";
            } else {
                echo "ERROR!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            break;
    }
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'delCourseData':
            deleteDB('mas_milwork', 'id', $varget_id2Delete, 1);

            echo "<script>alert('ลบข้อมูลแล้ว')</script>";
            echo "<script>window.location.href='./userProfile.php'</script>";
            break;
    }
}