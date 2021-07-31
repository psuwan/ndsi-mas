<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_nameTbl = filter_input(INPUT_GET, 'tblName');
$varget_nameCol = filter_input(INPUT_GET, 'colName');
$varget_val2Chk = filter_input(INPUT_GET, 'val2Chk');

$sqlcmd = "SELECT * FROM " . $varget_nameTbl . " WHERE " . $varget_nameCol . "='" . $varget_val2Chk . "'";
//echo $sqlcmd;die();
$sqlres = mysqli_query($dbConn, $sqlcmd);
if ($sqlres) {
    $sqlnum = mysqli_num_rows($sqlres);
    if ($sqlnum == 0) {
        echo "0";
    } else {
        echo "1";
    }
}
