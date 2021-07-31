<?php

$file2Delete = filter_input(INPUT_GET, 'file2Del');
$refNumber = filter_input(INPUT_GET, 'refNumber');
$replaceStr = __DIR__ . DIRECTORY_SEPARATOR . 'filesEvidence' . DIRECTORY_SEPARATOR . $refNumber . DIRECTORY_SEPARATOR;
$name2Delete = str_replace($replaceStr, '', $file2Delete);

if (!empty($file2Delete)) {
    unlink($file2Delete);
    ?>
    <script>
        let name2Delete = '<?=$name2Delete;?>';
        let courseRefnum = '<?=substr($refNumber, 11, 26);?>';
        let div2Return = '<?=substr($refNumber, 0, 11);?>';

        let tabNumber = div2Return.charAt(6);
        alert('file: ' + name2Delete + '\ncourse: ' + courseRefnum + '\nreturn: divReturn_' + div2Return + '\ntab no: ' + tabNumber);
        window.location.href = './unitCourseQA.php?courseRefnum=' + courseRefnum + '&#divReturn_' + div2Return;
    </script>
    <?php
} else {
    echo "No file to delete";
}