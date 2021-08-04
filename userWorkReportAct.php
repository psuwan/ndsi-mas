<?php
session_start();
include_once './lib/apksFunctions.php';
$dbCOnn = dbConnect();
//
//echo "<pre>";
//var_dump($_POST);
//echo "</pre>";

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varget_command = filter_input(INPUT_GET, 'delete');


$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_milNumber = filter_input(INPUT_POST, 'milNumber');
$varpost_milWorkTopic = filter_input(INPUT_POST, 'milWorkTopic');
$varpost_milWorkDetails = filter_input(INPUT_POST, 'milWorkDetails');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addWorkReport':
            $sqlcmd_updateReport = "INSERT INTO mas_wrkreport (mil_number, mil_wrktopic, mil_wrkdetails) VALUES ('$varpost_milNumber','$varpost_milWorkTopic','$varpost_milWorkDetails')";
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
    }
}

if(!empty($varget_command)){
    switch ($varget_command){
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