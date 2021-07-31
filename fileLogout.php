<?php
session_start();

/*if (empty($_SESSION['unitAbbrv'])) {
    */?><!--
    <script>
        alert('คุณไม่ได้อยู่ในระบบ');
        window.location.href = './unitLogin.php';
    </script>
    --><?php
/*} else {*/
// remove all session variables
    session_unset();

// destroy the session
    session_destroy();
    ?>
    <script>
        alert('ออกจากระบบ');
        window.location.href = './index0.php';
    </script>
    <?php
/*}*/