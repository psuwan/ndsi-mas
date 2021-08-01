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

$tmpNameFirst = explode(" ", $pfData['pfNameFirst']);
if (count($tmpNameFirst) > 1)
    $pfNameFirst = $tmpNameFirst[1];
else
    $pfNameFirst = $tmpNameFirst[0];

$pfNameLast = $pfData['pfNameLast'];
$pfSex = $pfData['pfSex'];
$pfASNow = $pfData['pfASNow'];
$pfWorkOffice = $pfData['pfWorkOffice'];
$pfWorkPosition = $pfData['pfWorkPosition'];

$pfDateBirth = $pfData['pfDateBirth'];
if (!empty($pfDateBirth))
    $pfDateBirth = dateAD($pfDateBirth) . " 08:00:00";
else {
    $tmpDateBirth = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_datebirth');
    if (empty($tmpDateBirth))
        $pfDateBirth = "1970-01-01 08:00:00";
    else
        $pfDateBirth = $tmpDateBirth;
}

$pfDateInGov = $pfData['pfDateInGov'];
if (!empty($pfDateInGov))
    $pfDateInGov = dateAD($pfDateInGov) . " 08:00:00";
else {
    $tmpDateInGov = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateingov');
    if (empty($tmpDateInGov))
        $pfDateInGov = "1970-01-01 08:00:00";
    else
        $pfDateInGov = $tmpDateInGov;
}

$pfDateASNow = $pfData['pfDateASNow'];
if (!empty($pfDateASNow))
    $pfDateASNow = dateAD($pfDateASNow) . " 08:00:00";
else {
    $tmpDateASNow = getValue('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnow');
    if (empty($tmpDateASNow))
        $pfDateASNow = "1970-01-01 08:00:00";
    else
        $pfDateASNow = $tmpDateASNow;
}

$pfSalaryLevel = $pfData['pfSalaryLevel'];
$pfSalaryFloor = $pfData['pfSalaryFloor'];
$pfSalary = $pfData['pfSalary'];
if (!empty($pfSalary))
    $pfSalary = $pfData['pfSalary'];
else
    $pfSalary = 0;

// Profile data
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updateProfile':
            $chkExist = countDB('tbl_profiles', 'mil_number', $milNumber, 2);
            if ($chkExist == '0') {
                insertDB('tbl_profiles', 'mil_number', $milNumber, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_namefirst', $pfNameFirst, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_namelast', $pfNameLast, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_rank', $pfRank, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_sex', $pfSex, 2);

                if (!empty($pfDateBirth))
                    updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_datebirth', $pfDateBirth, 2);
                if (!empty($pfDateInGov))
                    updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateingov', $pfDateInGov, 2);

                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_office', $pfWorkOffice, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_position', $pfWorkPosition, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_asnow', $pfASNow, 2);

                if (!empty($pfDateASNow))
                    updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnow', $pfDateASNow, 2);

                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_salarylevel', $pfSalaryLevel, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_salaryfloor', $pfSalaryFloor, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_salary', $pfSalary, 1);

                echo "<script>alert('เพิ่มข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php';</script>";
            } else {
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_namefirst', $pfNameFirst, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_namelast', $pfNameLast, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_rank', $pfRank, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_sex', $pfSex, 2);

                if (!empty($pfDateBirth))
                    updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_datebirth', $pfDateBirth, 2);
                if (!empty($pfDateInGov))
                    updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateingov', $pfDateInGov, 2);

                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_office', $pfWorkOffice, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_position', $pfWorkPosition, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_asnow', $pfASNow, 2);

                if (!empty($pfDateASNow))
                    updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_dateasnow', $pfDateASNow, 2);

                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_salarylevel', $pfSalaryLevel, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_salaryfloor', $pfSalaryFloor, 2);
                updateDB('tbl_profiles', 'mil_number', $milNumber, 2, 'pf_salary', $pfSalary, 1);

                echo "<script>alert('อัพเดทข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='./userProfile.php';</script>";
            }
            break;
    }
}