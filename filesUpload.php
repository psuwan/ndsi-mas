<?php
include_once './lib/apksFunctions.php';

$varpost_docRefNumber = filter_input(INPUT_POST, 'docRefNumber');
$varpost_folder2Upload = filter_input(INPUT_POST, 'folder2Upload');


// Upload directory
$upload_location = $varpost_folder2Upload . DIRECTORY_SEPARATOR . $varpost_docRefNumber . DIRECTORY_SEPARATOR;
$countType = 'filesEvidence_' . $varpost_docRefNumber;

if (!file_exists($upload_location)) {
    mkdir($upload_location, 0755, true);
}

// Count total files
$countfiles = count($_FILES[$countType]['name']);
echo "\n";

$count = 0;
for ($i = 0; $i < $countfiles; $i++) {

    // File name
    $filename = $_FILES[$countType]['name'][$i];
    echo $filename;
    echo "\n";

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
        $temp = explode(".", $_FILES[$countType]['name'][$i]);
        $newfilename = $upload_location . getToken(25) . '.' . end($temp);
        //psuwan's edited
        if (move_uploaded_file($_FILES[$countType]['tmp_name'][$i], $newfilename)) {
            // from Example
            // if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $path)) {
            $count += 1;
        }
    }
}
echo "รวม : " . $count;
exit;