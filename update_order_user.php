<?php
    ob_start();
    session_start();
    // unset($_SESSION['cart']);
    include("connection.php");
    include("common.php");
   
    // unset($_SESSION['cart']);
    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];
        $query_update_order = "UPDATE tbl_order SET status = '3' WHERE order_id = '$order_id'";
        $conn->query($query_update_order);

        echo $order_id;
    }
?>