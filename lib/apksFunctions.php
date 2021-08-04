<?php
$baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;

if (file_exists($baseDir . "dbConf.json")) {
//    echo "file existing...<br>";
    $db_param = file_get_contents($baseDir . "dbConf.json");

    $db_param = json_decode($db_param);

    $db_host = $db_param->db_host;
    $db_user = $db_param->db_user;
    $db_pass = $db_param->db_pass;
    $db_name = $db_param->db_name;
    $db_port = $db_param->db_port;
    $db_char = $db_param->db_char;
} else {
    echo "No existing files plese create...<br>";
}

function dbConnect()
{
    $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name'], $GLOBALS['db_port']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
//        echo "Connect OK";
        $conn->set_charset($GLOBALS['db_char']);
        return $conn;
    }
}

function insertDB($tblName, $colName, $colValue, $colType)
{
    $dbConnect = dbConnect();

    if ($colType == 1)
        $sqlcmd = "INSERT INTO " . $tblName . " (" . $colName . ") VALUES (" . $colValue . ")";
    else if ($colType == 2)
        $sqlcmd = "INSERT INTO " . $tblName . " (" . $colName . ") VALUES ('" . $colValue . "')";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        // Do nothing...
    } else {
        echo "<br>" . $sqlcmd . "<br>";
        echo "ERROR : " . mysqli_error($dbConnect);
    }
}

// dataType 1:int, 2:char or string, 3:timestamp
function updateDB($tblName, $refColumn, $refValue, $refType, $colName, $colValue, $dataType)
{
    $dbConnect = dbConnect();

    $errProtect = ($refType * 10) + $dataType;
    switch ($errProtect) {
        case 11:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "=" . $colValue . " WHERE " . $refColumn . "=" . $refValue;
            break;
        case 12:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "='" . $colValue . "' WHERE " . $refColumn . "=" . $refValue;
            break;
        case 21:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "=" . $colValue . " WHERE " . $refColumn . "='" . $refValue . "'";
            break;
        case 22:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "='" . $colValue . "' WHERE " . $refColumn . "='" . $refValue . "'";
            break;
    }

    $sqlres = mysqli_query($dbConnect, $sqlcmd);
    if ($sqlres) {
        // Do nothing...
        // echo "<br><br><br><br><br><br>" . $sqlcmd . "<br>";
        // echo $sqlcmd . "<br>";
    } else {
        echo "<br>" . $sqlcmd . "<br>";
        echo "ERROR : " . $colName . " | " . mysqli_error($dbConnect);
    }
}

function deleteDB($tblName, $refColumn, $refValue, $refType)
{
    $dbConnect = dbConnect();

    if ($refType == 1)
        $sqlcmd = "DELETE FROM " . $tblName . " WHERE " . $refColumn . "=" . $refValue;
    else if ($refType == 2)
        $sqlcmd = "DELETE FROM " . $tblName . " WHERE " . $refColumn . "='" . $refValue . "'";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        // Do nothing...
    } else {
        echo "<br>" . $sqlcmd . "<br>";
        echo "ERROR : " . mysqli_error($dbConnect);
    }
}

function countDB($tblName, $refColumn, $refValue, $refType)
{
    $dbConnect = dbConnect();

    switch ($refType) {
        case 1:
            $sqlcmd = "SELECT COUNT(*) AS cntDB FROM " . $tblName . " WHERE " . $refColumn . "=" . $refValue;
            break;

        case 2:
            $sqlcmd = "SELECT COUNT(*) AS cntDB FROM " . $tblName . " WHERE " . $refColumn . "='" . $refValue . "'";
//            echo $sqlcmd;
            break;

        default:
            break;
    }
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['cntDB'];
    } else {
        echo "<br>" . $sqlcmd . "<br>";
        echo "ERROR : " . mysqli_error($dbConnect);
    }
}

function countAllRow($tblName)
{
    $dbConnect = dbConnect();
    $sqlcmd = "SELECT * FROM " . $tblName . " WHERE 1";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        $sqlnum = mysqli_num_rows($sqlres);
        return $sqlnum;
    } else {
        echo "ERROR : " . mysqli_error($dbConnect);
        echo "<br>" . $sqlcmd . "<br>";
    }
}

function getValue($tblName, $refColumn, $refValue, $refType, $colName)
{
    $dbConnect = dbConnect();

    if ($refType == 1)
        $sqlcmd = "SELECT * FROM " . $tblName . " WHERE " . $refColumn . "=" . $refValue;
    else if ($refType == 2)
        $sqlcmd = "SELECT * FROM " . $tblName . " WHERE " . $refColumn . "='" . $refValue . "'";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        // echo $sqlcmd;
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet[$colName];
    } else {
        echo "<br>" . $sqlcmd . "<br>";
        echo "ERROR : " . mysqli_error($dbConnect);
    }
}

function writeLog($logType, $logText)
{
    date_default_timezone_set('Asia/Bangkok');
    $dateNow = date('Y-m-d');
    $timeNow = date('H:i:s');

    $logFolder = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "log" . DIRECTORY_SEPARATOR;

    $log2Write = $dateNow . " " . $timeNow . ", " . $logType . ", " . $logText;

    file_put_contents($logFolder . $dateNow . ".log", $log2Write . "\n", FILE_APPEND);
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDiff($date_1, $date_2, $differenceFormat = '%y, %m, %d')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function dateBE($dateAD)
{
    list($yy, $mm, $dd) = explode('-', $dateAD);
    return ($yy + 543) . "-" . $mm . "-" . $dd;
}

function dateAD($dateBE)
{
    list($yy, $mm, $dd) = explode('-', $dateBE);
    return ($yy - 543) . "-" . $mm . "-" . $dd;
}

function monthThai($dateBE)
{
    list($yy, $mm, $dd) = explode('-', $dateBE);
    $mm = str_replace(
        array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'),
        array('ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'),
        $mm
    );
    return number_format($dd) . " " . $mm . " " . $yy;
}

function numCharThai($numChar)
{
    $numCharThai = str_replace(
        array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
        array('๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙'),
        $numChar
    );
    return $numCharThai;
}

function confParam($confFolder, $confFile, $retParam)
{
    $confParam = dirname(dirname(__FILE__) . DIRECTORY_SEPARATOR);

    $confParam .= DIRECTORY_SEPARATOR . $confFolder . DIRECTORY_SEPARATOR . $confFile;

    if (file_exists($confParam)) {
        $parameter = file_get_contents($confParam);
        $parameter = json_decode($parameter);

        return $parameter->$retParam;
    } else {
        return '';
    }
}

// Generate token
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max - 1)];
    }

    return $token;
}

function encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}