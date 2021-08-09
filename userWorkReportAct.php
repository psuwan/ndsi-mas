<?php
session_start();
include_once './lib/apksFunctions.php';
$dbCOnn = dbConnect();

// Get variable here
$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varget_command = filter_input(INPUT_GET, 'command');

// Post variable here

$varpost_id2edit = filter_input(INPUT_POST, 'id2edit');
$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_milNumber = filter_input(INPUT_POST, 'milNumber');
$varpost_milWorkTopic = filter_input(INPUT_POST, 'milWorkTopic');
$varpost_milWorkDetails = filter_input(INPUT_POST, 'milWorkDetails');
$varpost_milWorkGroup = filter_input(INPUT_POST, 'reportGroup');
$varpost_milWorkDate = filter_input(INPUT_POST, 'reportDate');

if (!empty($varpost_milWorkDate)) {
    $varpost_milWorkDate = dateAD($varpost_milWorkDate) . " 08:00:00";
} else {
    $tmpMilWrkDate = getValue('mas_wrkreport', 'id', $varpost_id2edit, 1, 'mil_wrkrepdate');
    if (!empty($tmpMilWrkDate))
        $varpost_milWorkDate = $tmpMilWrkDate;
    else
        $varpost_milWorkDate = "1900-01-01 08:00:00";
}

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addWorkReport':
            $sqlcmd_updateReport = "INSERT INTO mas_wrkreport (mil_number, mil_wrktopic, mil_wrkdetails, mil_wrkrepgrp, mil_wrkrepdate) VALUES ('$varpost_milNumber','$varpost_milWorkTopic','$varpost_milWorkDetails', '$varpost_milWorkGroup', '$varpost_milWorkDate')";
            $sqlres_updateReport = mysqli_query($dbCOnn, $sqlcmd_updateReport);
            if ($sqlres_updateReport) {
                ?>
                <script>
                    alert('เพิ่มข้อมูลรายงานแล้ว');
                    window.location.href = './userWorkReport.php';
                </script>
                <?php
            } else {
                echo "ERROR !!! [" . mysqli_errno($dbCOnn) . "]--[" . mysqli_error($dbCOnn) . "]";
            }
            break;

        case 'editWorkReport':
//            echo "<pre>";
//            var_dump($_POST);
//            echo "</pre>";
            $sqlcmd_updateReport = "UPDATE mas_wrkreport SET mil_wrktopic='$varpost_milWorkTopic', mil_wrkdetails='$varpost_milWorkDetails', mil_wrkrepgrp='$varpost_milWorkGroup', mil_wrkrepdate='$varpost_milWorkDate' WHERE id=" . $varpost_id2edit;
//            echo $sqlcmd_updateReport;
//            echo "<br>";
            $sqlres_updateReport = mysqli_query($dbCOnn, $sqlcmd_updateReport);
            if ($sqlres_updateReport) {
                ?>
                <script>
                    alert('แก้ข้อมูลรายงานแล้ว');
                    window.location.href = './userWorkReport.php';
                </script>
                <?php
            } else {
                echo "ERROR !!! [" . mysqli_errno($dbCOnn) . "]--[" . mysqli_error($dbCOnn) . "]";
            }
            break;
    }
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'delete':
            deleteDB('mas_wrkreport', 'id', $varget_id2delete, 1);
            ?>
            <script>
                alert('ลบข้อมูลรายงานแล้ว');
                window.location.href = './userWorkReport.php';
            </script>
            <?php
            break;
    }
}
//command=delete&id2delete=1