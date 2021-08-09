<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

// Primary variables
$varpost_processName = filter_input(INPUT_POST, 'processName');
$milNumber = filter_input(INPUT_POST, 'milNum2Update');
$varget_command = filter_input(INPUT_GET, 'command');
$varget_milNumb = filter_input(INPUT_GET, 'milNumber');

// Profile data
$pfData = array(
    "pfNameFirst" => filter_input(INPUT_POST, 'nameFirst'),
    "pfNameLast" => filter_input(INPUT_POST, 'nameLast'),
    "pfSex" => filter_input(INPUT_POST, 'sex'),
    "pfRank" => filter_input(INPUT_POST, 'rank'),
    "pfDateBirth" => filter_input(INPUT_POST, 'dateBirth'),
    "pfDateInGov" => filter_input(INPUT_POST, 'dateInGov'),
    "pfWorkOffice" => filter_input(INPUT_POST, 'workOffice'),
    "pfWorkPosition" => filter_input(INPUT_POST, 'workPosition'),
    "pfASNow" => filter_input(INPUT_POST, 'ASNow'),
    "pfDateASNow" => filter_input(INPUT_POST, 'dateAS'),
    "pfSalaryLevel" => filter_input(INPUT_POST, 'salaryLevel'),
    "pfSalaryFloor" => filter_input(INPUT_POST, 'salaryFloor'),
    "pfSalary" => filter_input(INPUT_POST, 'salary')
);

$pfRank = $pfData['pfRank'];
$pfSex = $pfData['pfSex'];
if (empty($pfSex)) {
    $pfSex = '1';
}

$tmpNameFirst = str_replace("หญิง ", "", $pfData['pfNameFirst']);
$tmpNameFirst = explode(" ", $tmpNameFirst);
if (count($tmpNameFirst) > 1) {
    $pfNameFirst = $tmpNameFirst[1];
} else {
    $pfNameFirst = $tmpNameFirst[0];
}

// Remove ร.น.
$tmpNameLast = str_replace(" ร.น.", "", $pfData['pfNameLast']);
$pfNameLast = $tmpNameLast;

$pfASNow = $pfData['pfASNow'];
$pfWorkOffice = $pfData['pfWorkOffice'];
$pfWorkPosition = $pfData['pfWorkPosition'];
//echo $pfWorkPosition;die();

$pfDateBirth = $pfData['pfDateBirth'];
if (!empty($pfDateBirth)) {
    $pfDateBirth = dateAD($pfDateBirth) . " 08:00:00";
} else {
    $tmpDateBirth = getValue('mas_profiles', 'mil_number', $milNumber, 2, 'pf_datebirth');
    if (empty($tmpDateBirth)) {
        $pfDateBirth = "1900-01-01 08:00:00";
    } else {
        $pfDateBirth = $tmpDateBirth;
    }
}

$pfDateInGov = $pfData['pfDateInGov'];
if (!empty($pfDateInGov)) {
    $pfDateInGov = dateAD($pfDateInGov) . " 08:00:00";
} else {
    $tmpDateInGov = getValue('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateingov');
    if (empty($tmpDateInGov)) {
        $pfDateInGov = "1900-01-01 08:00:00";
    } else {
        $pfDateInGov = $tmpDateInGov;
    }
}

$pfDateASNow = $pfData['pfDateASNow'];
if (!empty($pfDateASNow)) {
    $pfDateASNow = dateAD($pfDateASNow) . " 08:00:00";
} else {
    $tmpDateASNow = getValue('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnow');
    if (empty($tmpDateASNow)) {
        $pfDateASNow = "1900-01-01 08:00:00";
    } else {
        $pfDateASNow = $tmpDateASNow;
    }
}


$pfSalaryLevel = $pfData['pfSalaryLevel'];
$pfSalaryFloor = $pfData['pfSalaryFloor'];
$pfSalary = $pfData['pfSalary'];
if (!empty($pfSalary)) {
    $pfSalary = str_replace(',', '', $pfData['pfSalary']);
    $pfSalary = floatval($pfSalary);
} else {
    $pfSalary = 0;
}

// Profile data
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updateProfile':
            $chkUserExist = countDB('mas_profiles', 'mil_number', $milNumber, 2);
            if ($chkUserExist === '0') {
                // 0 for no user existing
                insertDB('mas_profiles', 'mil_number', $milNumber, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_namefirst', $pfNameFirst, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_namelast', $pfNameLast, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_rank', $pfRank, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_sex', $pfSex, 2);

                //if (!empty($pfDateBirth))
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_datebirth', $pfDateBirth, 2);
                //if (!empty($pfDateInGov))
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateingov', $pfDateInGov, 2);

                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_office', $pfWorkOffice, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_position', $pfWorkPosition, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_asnow', $pfASNow, 2);

                //if (!empty($pfDateASNow))
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnow', $pfDateASNow, 2);

                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_salarylevel', $pfSalaryLevel, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_salaryfloor', $pfSalaryFloor, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_salary', $pfSalary, 1);

                echo "<script>alert('เพิ่มข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php';</script>";
            } else {
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_namefirst', $pfNameFirst, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_namelast', $pfNameLast, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_rank', $pfRank, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_sex', $pfSex, 2);

                //if (!empty($pfDateBirth))
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_datebirth', $pfDateBirth, 2);
                //if (!empty($pfDateInGov))
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateingov', $pfDateInGov, 2);

                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_office', $pfWorkOffice, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_position', $pfWorkPosition, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_asnow', $pfASNow, 2);

                //if (!empty($pfDateASNow))
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnow', $pfDateASNow, 2);

                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_salarylevel', $pfSalaryLevel, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_salaryfloor', $pfSalaryFloor, 2);
                updateDB('mas_profiles', 'mil_number', $milNumber, 2, 'pf_salary', $pfSalary, 1);

                echo "<script>alert('อัพเดทข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php';</script>";
            }
            break;
    }
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'want2Up';
            updateDB('mas_profiles', 'mil_number', $varget_milNumb, 2, 'pf_asnext', NULL, 2);
            echo "<script>alert('แจ้งขอรับการประเมินแล้ว')</script>";
            echo "<script>window.location.href='./userProfile.php';</script>";
            break;
    }
}