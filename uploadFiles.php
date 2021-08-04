<?php
include_once './lib/apksFunctions.php';

$varpost_fileRefNumber = filter_input(INPUT_POST, 'fileRefNumber');
//$varpost_fileRefString = filter_input(INPUT_POST, 'fileRefString');
$varpost_folder2Upload = filter_input(INPUT_POST, 'folder2Upload');
//echo "\n" . $varpost_fileRefNumber . "\n" . $varpost_fileRefString . "\n" . $varpost_folder2Upload . "\n";
//echo $varpost_fileRefNumber . "\nเก็บที่ " . $varpost_folder2Upload . "\n";
// Upload directory
$upload_location = $varpost_folder2Upload . DIRECTORY_SEPARATOR;
$countType = "evdFiles_" . $varpost_fileRefNumber;

if (!file_exists($upload_location)) {
    mkdir($upload_location, 0755, true);
}

// Count total files
$countfiles = count($_FILES[$countType]['name']);
//echo "\n";

$count = 0;
for ($i = 0; $i < $countfiles; $i++) {

    // File name
    $filename = $_FILES[$countType]['name'][$i];
    //echo $filename;
    //echo "\n";

    // File path
    $path = $upload_location . $filename;

    // file extension
    $file_extension = pathinfo($path, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

    // Valid file extensions
    $valid_ext = array("pdf", "doc", "docx", "jpg", "png", "jpeg", "xls", "xlsx");

    // Check extension
    if (in_array($file_extension, $valid_ext)) {
        // Change file name
        $fileNameExtend = getToken(10);
        $temp = explode(".", $_FILES[$countType]['name'][$i]);
//        $newfilename = $upload_location . $varpost_fileRefNumber . "_" . $i . '.' . end($temp);
        $newfilename = $upload_location . $varpost_fileRefNumber . "_" . $fileNameExtend . '.' . end($temp);
        //psuwan's edited
        if (move_uploaded_file($_FILES[$countType]['tmp_name'][$i], $newfilename)) {
            // from Example
            // if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $path)) {
            $count += 1;
            $cntRefInEvdChk = countDB('mas_evdchk', 'evd_refnumber', $varpost_fileRefNumber, 2);
            if($cntRefInEvdChk==='0'){
                insertDB('mas_evdchk', 'evd_refnumber', $varpost_fileRefNumber, 2);
                updateDB('mas_evdchk', 'evd_refnumber', $varpost_fileRefNumber, 2, 'evd_newup', '1',2);
                updateDB('mas_evdchk', 'evd_refnumber', $varpost_fileRefNumber, 2, 'evd_chked', '0',2);
            }else{
                updateDB('mas_evdchk', 'evd_refnumber', $varpost_fileRefNumber, 2, 'evd_newup', '1',2);
                updateDB('mas_evdchk', 'evd_refnumber', $varpost_fileRefNumber, 2, 'evd_chked', '0',2);
            }
        }
    }
}
echo "รวม : " . $count;
exit;