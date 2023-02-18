<?php
    ob_start();
    session_start();
    include("connection.php");
    if(isset($_POST["pro_id"]) && isset($_POST["quantity"])) {
        $id = $_POST["pro_id"];
        $num = (int)$_POST["quantity"];
        $size =  $_POST['size'];
        $cat_name = $_POST['cat_name'];
        $brand_name = $_POST['brand_name'];
        $sqlDetailPro = "SELECT * FROM tbl_product WHERE pro_id = $id";
        $resultDetailPro = $conn->query($sqlDetailPro);
        $rowDetailPro = $resultDetailPro->fetch();
        $id_cart = time();
        
       
        if(!isset($_SESSION["cart"])) { //session cart chua ton tai
            $cart = array(
                $id_cart => array(
                    'id_pro'=> $id,
                    'name'=>$rowDetailPro['pro_name'],
                    'price'=>$rowDetailPro['price'],
                    'image'=>$rowDetailPro['image'],
                    'cat_name'  => $cat_name,
                    'brand_name' => $brand_name,
                    'quanlity'=>$num,
                    'size'      => $size
                )
            );
           
            // echo json_encode($_SESSION['cart']);
        } else { //da co session cart
            $cart = $_SESSION["cart"];

            $kiem_tra_cung_pro_cung_size = 0;
            foreach($cart as $key => $cart_item){
                if($cart_item['id_pro']==$id && $cart_item['size']==$size){//trung product_id trung size
                    $kiem_tra_cung_pro_cung_size = 1;
                    $cart[$key] = array(
                        'id_pro'=> $id,
                        'name'=>$rowDetailPro['pro_name'],
                        'price'=>$rowDetailPro['price'],
                        'image'=>$rowDetailPro['image'],
                        'cat_name'  => $cat_name,
                        'brand_name' => $brand_name,
                        'quanlity'=>(int)$num+$cart_item['quanlity'],
                        'size'      => $size
                    );
                    
                } 
            }
            if($kiem_tra_cung_pro_cung_size == 0){ // khong trung id khong trung size => them cart moi
                $cart[$id_cart] = array(
                    'id_pro'=> $id,
                    'name'=>$rowDetailPro['pro_name'],
                    'price'=>$rowDetailPro['price'],
                    'image'=>$rowDetailPro['image'],
                    'cat_name'  => $cat_name,
                    'brand_name' => $brand_name,
                    'quanlity'=>$num,
                    'size'      => $size
                );
            }

           
            
        }
        $_SESSION["cart"] = $cart;
        // echo json_encode($_SESSION['cart']);
        // die();
        header('location: index.php?page=detail&id='.$id);

        // $_SESSION["cart"] = $cart;
       
        // $numberProduct =0;
        // foreach($_SESSION["cart"] as $key=>$value) {
        //     $numberProduct +=$value["quanlity"];
        // }
        // echo $numberProduct;
        

    }
?>