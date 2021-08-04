<?php
session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_milNumber = filter_input(INPUT_POST, 'milNumber');
$varpost_levelASNext = filter_input(INPUT_POST, 'levelASNext');
$varpost_dateASNext = filter_input(INPUT_POST, 'dateASNext');

var_dump($_POST);
echo $varpost_dateASNext;

$chkASNow = getValue('tbl_profiles', 'mil_number', $varpost_milNumber, 2, 'pf_asnow');
if ($varpost_levelASNext <= $chkASNow) {
    ?>
    <script>
        alert("ต้องเลือกระดับวิทยฐานที่สูงขึ้น");
        window.location.href = "./userBegin.php";
    </script>
    <?php
}

if (empty($varpost_dateASNext)) {
    ?>
    <script>
        alert("ไม่ได้กำหนดวันที่ขอมี/เลื่อนวิทยฐานะ");
        window.location.href = "./userBegin.php";
    </script>
    <?php
} else {
    echo "xxxx";
    $varpost_dateASNext = dateAD($varpost_dateASNext) . " 08:00:00";
    echo $varpost_dateASNext;
}
//echo $varpost_levelASNext;


if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updateASNext':
//            updateDB('tbl_profiles', 'mil_number', $varpost_milNumber, 2, 'pf_asnext', $varpost_levelASNext, 2);
//            updateDB('tbl_profiles', 'mil_number', $varpost_milNumber, 2, 'pf_dateasnext', $varpost_dateASNext, 2);
            $sqlcmd = "INSERT INTO tbl_profiles (mil_number, pf_asnext, pf_dateasnext, pf_dateasnow) VALUES ('$varpost_milNumber', '$varpost_levelASNext','$varpost_dateASNext', '$varpost_dateASNext')";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                ?>
                <script>
                    alert("อัพเดทข้อมูลแล้ว");
                    window.location.href = "./userProfile.php";
                </script>
                <?php
            }
            break;
    }
}