<?php
require_once './lib/apksFunctions.php';

$varpost_processName = filter_input(INPUT_POST, 'processName');

$db_host = confParam('lib', 'dbConf.json', 'db_host');
$db_user = confParam('lib', 'dbConf.json', 'db_user');
$db_pass = confParam('lib', 'dbConf.json', 'db_pass');
$db_name = confParam('lib', 'dbConf.json', 'db_name');
$db_char = confParam('lib', 'dbConf.json', 'db_char');
$db_port = confParam('lib', 'dbConf.json', 'db_port');

if (!empty($varpost_processName)) {
    $param = array(
        "db_host" => filter_input(INPUT_POST, 'dbHost'),
        "db_user" => filter_input(INPUT_POST, 'dbUser'),
        "db_pass" => filter_input(INPUT_POST, 'dbPass'),
        "db_name" => filter_input(INPUT_POST, 'dbName'),
        "db_char" => filter_input(INPUT_POST, 'dbChar'),
        "db_port" => filter_input(INPUT_POST, 'dbPort')
    );

    // Encode the array back into a JSON string.
    $json = json_encode($param);

    // Save the file.
    file_put_contents('./lib/dbConf.json', $json);

    // Refresh page
    $dir = __DIR__;
    $file = __FILE__;
    $thisFile = str_replace($dir, '', $file);
    $thisFile = trim($thisFile, DIRECTORY_SEPARATOR);
    //echo $thisFile;
    header('location:' . $thisFile);
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/font.css">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <div class="row mt-3 h5">
        <div class="col-md-12 text-info">
            Database Configuration Parameters
        </div>
    </div>

    <div class="row mt-1">

        <!-- 1st Column -->
        <div class="col-md-4">
            <form action="" method="post">
                <!-- Database Host's Name -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <label for="id4_dbHost" class="form-label">Databse Host: </label>
                        <input type="text" name="dbHost" id="id4_dbHost" class="form-control form-control-sm"
                               value="<?= $db_host; ?>" placeholder="default : localhost">
                    </div>
                </div>

                <!-- Database Username -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <label for="id4_dbUser" class="form-label">Database User: </label>
                        <input type="text" name="dbUser" id="id4_dbUser" class="form-control form-control-sm"
                               value="<?= $db_user; ?>" placeholder="database user">
                    </div>
                </div>

                <!-- Database Password -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <label for="id4_dbPass" class="form-label">Database Password: </label>
                        <input type="password" name="dbPass" id="id4_dbPass" class="form-control form-control-sm"
                               value="<?= $db_pass; ?>" placeholder="database password">
                    </div>
                </div>

                <!-- Database Name -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <label for="id4_dbName" class="form-label">Database Name: </label>
                        <input type="text" name="dbName" id="id4_dbName" class="form-control form-control-sm"
                               value="<?= $db_name; ?>" placeholder="database name">
                    </div>
                </div>

                <!-- Database Port -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <label for="id4_dbPort" class="form-label">Database Port: </label>
                        <input type="text" name="dbPort" id="id4_dbPort" class="form-control form-control-sm"
                               value="<?= $db_port; ?>" placeholder="default : 3306">
                    </div>
                </div>

                <!-- Database Charset -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <label for="id4_dbChar" class="form-label">Database Charset: </label>
                        <input type="text" name="dbChar" id="id4_dbChar" class="form-control form-control-sm"
                               value="<?= $db_char; ?>" placeholder="default : utf8">
                    </div>
                </div>

                <hr>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="reset" class="btn btn-sm btn-warning">Clear</button>
                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
                    </div>
                </div>
                <input type="hidden" name="processName" value="saveParam">
            </form>
        </div>

        <!-- 2nd Column::image to show database -->
        <div class="col-md-8 d-none d-sm-block text-center">
            <img class="border" src="https://dummyimage.com/600x400/000/fff.png&text=database" alt="database system">
        </div>

    </div>
</div>


<!-- Popper and Bootstrap JS -->
<script src="./js/jquery-3.5.1.slim.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>

<!-- Project script -->
<script src="./js/prjScript.js"></script>

</body>
</html>