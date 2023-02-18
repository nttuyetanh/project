<?php
    // echo "update cart";
    // die();
    ob_start();
    session_start();
    
    $cart_id = $_POST['cart_id'];
    $new_quanlity = (int)$_POST['quanlity'];
    
    $cart = $_SESSION['cart'];
    if($new_quanlity<=0){
        unset($cart[$cart_id]);
    }else{
        $cart[$cart_id] = array(
            'id_pro'=> $cart[$cart_id]['id_pro'],
            'name'=>$cart[$cart_id]['name'],
            'price'=>$cart[$cart_id]['price'],
            'image'=>$cart[$cart_id]['image'],
            'cat_name'  => $cart[$cart_id]['cat_name'],
            'brand_name' => $cart[$cart_id]['brand_name'],
            'quanlity'=>$new_quanlity,
            'size'      =>$cart[$cart_id]['size']
        );
    }

    $total = 0;
    
    foreach($cart as $cart_item){
        $total = $total+$cart_item['quanlity'];
    }
    echo $total;

    $_SESSION['cart'] = $cart;
    

    // echo json_encode($_SESSION['cart']);
    // die();
   
    // header('location: index.php?page=cart');

?>