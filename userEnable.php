<?php
include_once './lib/apksFunctions.php';
$varget_milNumber = filter_input(INPUT_GET, 'milNum2En');
$status2Up = getValue('mas_users', 'mil_number', $varget_milNumber, 2, 'user_status');
if ($status2Up === '0')
    $status2Up = '1';
else
    $status2Up = '0';

updateDB('mas_users', 'mil_number', $varget_milNumber, 2, 'user_status', $status2Up, 2);

header('location:userView.php');