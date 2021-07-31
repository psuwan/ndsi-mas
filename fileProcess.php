<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_milNumber = filter_input(INPUT_POST, 'milNum2Chk');

/* User's data */
$userData = array(
    "milNumber" => filter_input(INPUT_POST, 'milNumber'),
    "password" => filter_input(INPUT_POST, 'password')
);
$milNumber = $userData['milNumber'];
$password = $userData['password'];
$hashPass = password_hash($password . md5($milNumber), PASSWORD_BCRYPT);
/* User's data */

switch ($varpost_processName) {
    case 'userRegister':
        insertDB('mas_users', 'mil_number', $milNumber, 2);
        updateDB('mas_users', 'mil_number', $milNumber, 2, 'user_pass', $hashPass, 2);
        updateDB('mas_users', 'mil_number', $milNumber, 2, 'user_createdat', $dateNow . " " . $timeNow, 2);

        echo "<script>alert('เพิ่มผู้ใช้งานแล้ว');</script>";
        echo "<script>window.location.href='./userLogin.php';</script>";
        break;

    case 'checkMilNumber':
        $isExist = countDB('mas_users', 'mil_number', $varpost_milNumber, 2);
        echo $isExist;
        break;

    case 'userLogin':
        $chkLogin = countDB('mas_users', 'mil_number', $milNumber, 2);
        // countDB return string
        if ($chkLogin === '0') {
            echo "<script>alert('เลขทหารนี้ยังไม่ได้ลงทะเบียน')</script>";
            echo "<script>window.location.href='./userRegis.php';</script>";
        } else {
            $password2Check = getValue('mas_users', 'mil_number', $milNumber, 2, 'user_pass');
            $verifyPassword = password_verify($password . md5($milNumber), $password2Check);

            if (!$verifyPassword) {
                echo "<script>alert('รหัสผ่านผิด')</script>";
                echo "<script>window.location.href='./userLogin.php';</script>";
            } else {
                $isUserEn = getValue('mas_users', 'mil_number', $milNumber, 2, 'user_status');
                if ($isUserEn === '0') {
                    echo "<script>alert('เลขทหารยังไม่ได้รับอนุญาติ\\nโปรดติดต่อ กวท.')</script>";
                    echo "<script>window.location.href='./userLogin.php';</script>";
                } else {
                    writeLog("NORMAL", "USER \"" . $milNumber . "\" WAS LOGGING IN");
                    $_SESSION['userLogin'] = encrypt_decrypt($milNumber, 'encrypt');
                    echo "<script>alert('เข้าสู่ระบบสำเร็จ')</script>";
                    echo "<script>window.location.href='./index0.php';</script>";
                }
            }
        }
        break;

    case 'changePwd':
//        echo $milNumber;
//        echo "<br>";
//        echo $password;
//        echo "<br>";
//        echo $hashPass;
        updateDB('mas_users', 'mil_number', $milNumber, 2, 'user_pass', $hashPass, 2);

        echo "<script>alert('เปลี่ยนรหัสผ่านแล้ว');</script>";
        echo "<script>window.location.href='./index0.php';</script>";
        break;

    default:
        break;
}
