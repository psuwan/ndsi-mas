<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_id2edit = filter_input(INPUT_POST, 'id2edit');
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
else {
    if ($varpost_milWorkIsNow !== '1') {
        $tmpWorkStart = getValue('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_workstart');
        if (!empty($tmpWorkStart))
            $varpost_milWorkStart = $tmpWorkStart;
        else
            $varpost_milWorkStart = "1900-01-01 08:00:00";
    } else
        $varpost_milWorkStart = "1900-01-01 08:00:00";
}

if (!empty($varpost_milWorkStop))
    $varpost_milWorkStop = dateAD($varpost_milWorkStop) . " 08:00:00";
else {
    if ($varpost_milWorkIsNow !== '1') {
        $tmpWorkStop = getValue('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_workstop');
        if (!empty($tmpWorkStop))
            $varpost_milWorkStop = $tmpWorkStop;
        else
            $varpost_milWorkStop = "1900-01-01 08:00:00";
    } else
        $varpost_milWorkStop = "1900-01-01 08:00:00";
}

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addMilWork':
            if ($varpost_milWorkIsNow === '1') {
                $day_before = date('Y-m-d', strtotime($varpost_milWorkStart . ' -1 day'));
                $day_before .= " 08:00:00";

                $sqlcmd_tmp = "UPDATE mas_milwork SET mil_workStop='" . $day_before . "' WHERE mil_number='" . $milNumber . "' AND mil_workisnow='1'";
                echo $sqlcmd_tmp . "<br>";
                $sqlres_tmp = mysqli_query($dbConn, $sqlcmd_tmp);
                if (!$sqlres_tmp) {
                    echo "ERROR!!! [" . mysqli_errno($dbConn) . "] -- [" . mysqli_error($dbConn) . "]";
                }

                // Set all work before this adding to old work
                $sqlcmd_tmp = "UPDATE mas_milwork SET mil_workisnow = '0' WHERE mil_number='" . $milNumber . "'";
                echo $sqlcmd_tmp . "<br>";
                $sqlres_tmp = mysqli_query($dbConn, $sqlcmd_tmp);
                if (!$sqlres_tmp) {
                    echo "ERROR!!! [" . mysqli_errno($dbConn) . "] -- [" . mysqli_error($dbConn) . "]";
                }
            }

            // update work
            $sqlcmd_addMilWork = "INSERT INTO mas_milwork (mil_number, mil_position, mil_command, mil_numext, mil_workstart, mil_workstop, mil_workisnow) VALUES ('$milNumber', '$varpost_milWorkPos', '$varpost_milWorkCmd','', '$varpost_milWorkStart', '$varpost_milWorkStop', '$varpost_milWorkIsNow')";
            echo $sqlcmd_addMilWork . "<br>";
            $sqlres_addMilWork = mysqli_query($dbConn, $sqlcmd_addMilWork);

            if ($sqlres_addMilWork) {
//                echo "<script>alert('เพิ่มข้อมูลแล้ว')</script>";
//                echo "<script>window.location.href='./userProfile.php'</script>";
            } else {
                echo "ERROR!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            break;

        case 'editMilWork':
//            echo "<pre>";
//            var_dump($_POST);
//            echo "</pre>";
            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_position', $varpost_milWorkPos, 2);
            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_command', $varpost_milWorkCmd, 2);
            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_workstart', $varpost_milWorkStart, 2);
            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_workstop', $varpost_milWorkStop, 2);

            echo "<script>alert('แก้ไขข้อมูลแล้ว')</script>";
            echo "<script>window.location.href='./userProfile.php#Box4'</script>";
            break;

        case 'editMilWorkNow':
//            echo "<pre>";
//            var_dump($_POST);
//            echo "</pre>";

            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_position', $varpost_milWorkPos, 2);
            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_command', $varpost_milWorkCmd, 2);
            updateDB('mas_milwork', 'id', $varpost_id2edit, 1, 'mil_workstart', $varpost_milWorkStart, 2);

            echo "<script>alert('แก้ไขข้อมูลแล้ว')</script>";
            echo "<script>window.location.href='./userProfile.php#Box4'</script>";
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