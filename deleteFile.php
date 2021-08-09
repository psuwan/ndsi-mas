<?php

$varget_file2Delete = filter_input(INPUT_GET, 'file2Del');
$varget_file2Return = filter_input(INPUT_GET, 'file2Ret');
//$varget_fileRef = filter_input(INPUT_GET, 'refNumber');

//$strSplit = explode('_', $varget_fileRef);

$ret2File = trim($varget_file2Return, DIRECTORY_SEPARATOR);
$tmpRetTo = explode(DIRECTORY_SEPARATOR, $ret2File);
$ret2File = $tmpRetTo[1];
//$ret2File .= "?evd2Upload=" . $varget_fileRef;

if (file_exists($varget_file2Delete)) {
    unlink($varget_file2Delete);
    ?>
    <script>
        let retFile = '<?=$ret2File;?>';
        console.log(retFile);
        alert('ลบไฟล์แล้ว');
        window.location.href = retFile;
    </script>
    <?php
} else {
    ?>
    <script>
        alert('ไม่มีไฟล์ที่เลือก');
        window.history.go(-1);
    </script>
    <?php
}