<?php
session_start();
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$queryString = '1';
$varget_level2Edit = filter_input(INPUT_GET, 'level2Edit');
if (empty($varget_level2Edit)) {
    $queryString = " WHERE user_level<7";
} else {
    $queryString = " WHERE user_level>6";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap 4.6.x -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <!-- Project stylesheet -->
    <link rel="stylesheet" href="./css/prjStyle.css">
    <link rel="stylesheet" href="./css/font.css"><!-- Our Custom CSS -->

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="./css/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="./css/all.css">


    <title>MAS - USERs VIEW</title>
</head>
<body>
<div class="wrapper">
    <?php
    include_once './fileSidebar.php';
    ?>

    <!-- Page Content  -->
    <div id="content">

        <?php
        include_once './fileNavbar.php';
        ?>
        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-center">

                <div class="card shadow-lg" style="width: 95%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">ข้อมูลทั้งหมด</h6>
                        <h5 class="card-title">รายชื่อที่ลงทะเบียน</h5>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <thead class="bg-info">
                                    <th>#</th>
                                    <th>เลขทหาร</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>level</th>
                                    <th></th>
                                    </thead>
                                </tr>
                                <tbody>
                                <?php
                                $cntUser = 0;
                                $sqlcmd_listUser = "SELECT * FROM mas_users " . $queryString;
                                $sqlres_listUser = mysqli_query($dbConn, $sqlcmd_listUser);
                                if ($sqlres_listUser) {
                                    while ($sqlfet_listUser = mysqli_fetch_assoc($sqlres_listUser)) {
                                        ?>
                                        <tr>
                                            <td><?= ++$cntUser; ?></td>
                                            <td><?= $sqlfet_listUser['mil_number']; ?></td>
                                            <td></td>
                                            <td><?= $sqlfet_listUser['user_level']; ?></td>
                                            <td>
                                                <?php
                                                if ($sqlfet_listUser['user_status'] === '0') {
                                                    ?>
                                                    <a href="userEnable.php?milNum2En=<?=$sqlfet_listUser['mil_number'];?>"><i class="fas fa-power-off text-warning"></i></a>
                                                        <?php
                                                } else {
                                                    ?>
                                                    <a href="userEnable.php?milNum2En=<?=$sqlfet_listUser['mil_number'];?>"><i class="fas fa-power-off text-success"></i></a>
                                                    <?php
                                                }
                                                echo "&nbsp;";
                                                if ($sqlfet_listUser['user_level'] !== '9') {
                                                    echo "<i class=\"fas fa-trash-alt text-danger\"></i>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Popper and Bootstrap JS -->
<script src="./js/jquery-3.5.1.slim.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Project script -->
<script src="./js/prjScript.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>

<!--<script>-->
<!--    $("#id4MasSubMenu").removeClass("collapsed");-->
<!--    $("#masSubMenu").addClass("show");-->
<!--    $("#masSubMenuUserView").addClass("bg-danger");-->
<!--</script>-->

</body>
</html>