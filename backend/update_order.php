<?php
    ob_start();
    session_start();
    if(!$_SESSION["admin_login"]) {
      header("location:login.php");
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    include ("../connection.php");
    include ("../common.php");


    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];
        $query_update_order = "UPDATE tbl_order SET status = '2' WHERE order_id = '$order_id'";
        $conn->query($query_update_order);

        echo $order_id;
    }
?>