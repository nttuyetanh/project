<?php
    unset($_SESSION['user_login']);
    unset($_SESSION['cart']);
    session_destroy();
    header("location: login/login.php");
?>