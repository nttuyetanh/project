<?php
    // echo "update cart";
    // die();
    ob_start();
    session_start();


    if(isset($_GET['cart_id'])){
        $cart_id = $_GET['cart_id'];
        if(isset($_SESSION['cart'])){
            unset($_SESSION['cart'][$cart_id]);
        }
    }
    header('Location: index.php?page=cart');
?>