<nav class="navbar navbar-expand-md bg-light navbar-light pr-md-5 sticky-top">

    <button type="button" id="sidebarCollapse" class="btn btn-outline-success">
        <i class="fas fa-align-left"></i>
    </button>

    <!-- Brand -->
    <a class="ml-1 navbar-brand d-block d-sm-none" href="#">กองวิทยฐานะทหาร
        <div>กองบัญชาการกองทัพไทย</div>
    </a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse justify-content-end pr-5" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./index0.php">หน้าหลัก</a>
            </li>

            <!--<li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>-->

            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="pr-5 nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    <?php
                    if (empty($_SESSION['userLogin']))
                        echo "เข้าสู่ระบบงาน";
                    else
                        //$userLogin = encrypt_decrypt($_SESSION['userLogin'],'decrypt');
                        echo "<strong><i class=\"far fa-user\"></i></strong>";
                    ?>

                </a>
                <div class="dropdown-menu">
                    <?php
                    if (!empty($_SESSION['userLogin'])) {
                        ?>
                        <a class="dropdown-item" href="fileChgPwd.php">เปลี่ยนรหัสผ่าน</a>
                        <a class="dropdown-item" href="./fileLogout.php">ออกจากระบบ</a>
                        <?php
                    } else {
                        ?>
                        <a href="userRegis.php" class="dropdown-item">ลงทะเบียน</a>
                        <a href="./userLogin.php" class="dropdown-item">เข้าสู่ระบบ</a>
                        <!--                    <a class="dropdown-item" href="./fileProfile.php">ข้อมูล</a>-->
                        <?php
                    }
                    ?>
                </div>
            </li>
        </ul>
    </div>
</nav>
