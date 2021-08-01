<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header text-center">
        <img src="./images/png/logo_ndsi_lg.png" alt="ndsi-mqa-logo" width="75px">
        <div class="h6">
            กองวิทยฐานะทหาร<br>กองบัญชาการกองทัพไทย
        </div>
    </div>

    <?php
    if (!empty($_SESSION['userLogin'])){
    $milNumber = encrypt_decrypt($_SESSION['userLogin'], 'decrypt');
    $userLevel = getValue('mas_users', 'mil_number', $milNumber, 2, 'user_level');
    ?>
    <ul class="list-unstyled components">
        <?php if ($userLevel > 6) {
            ?>
            <li>
                <a href="#masSubMenu" data-toggle="collapse" class="dropdown-toggle" id="id4MasSubMenu">กวท. บก.สปท.</a>
                <ul class="collapse list-unstyled" id="masSubMenu">
                    <li>
                        <a href="./userView.php?level2Edit=7" id="masSubMenuUserView">รายชือผู้ดูแลระบบ</a>
                    </li>
                    <li>
                        <a href="./userView.php" id="masSubMenuUserView">รายชื่อสมาชิก</a>
                    </li>
                    <li>
                        <a href="./masChkEvd.php">ตรวจหลักฐาน</a>
                    </li>
                </ul>
            </li>
            <?php
        } else {
            ?>
            <li>
                <a href="#unitSubmenu" data-toggle="collapse" aria-expanded="false"
                   class="dropdown-toggle">ผู้ขอรับการประเมิน</a>
                <ul class="collapse list-unstyled" id="unitSubmenu">
                    <li>
                        <a href="./userProfile.php">ข้อมูลผู้ขอรับการประเมิน</a>
                    </li>
                    <!--                    <li>-->
                    <!--                        <a href="#">ข้อมูลการรับราชการ</a>-->
                    <!--                    </li>-->
                    <li>
                        <a href="./userEvidence.php">ข้อมูลเกี่ยวกับการปฏิบัติงานที่ขอรับการประเมิน</a>
                    </li>
                </ul>
            </li>
            <?php
        }
        ?>
        <?php
        }
        ?>
    </ul>
</nav>