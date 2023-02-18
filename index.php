<?php
    ob_start();
    session_start();
    include("connection.php");
    include("common.php");

?>


<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="apple-touch-icon" href="assets/img/apple-icon.png">
<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/templatemo.css">
<link rel="stylesheet" href="assets/css/custom.css">

<!-- Load fonts style after rendering the layout styles -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
<link rel="stylesheet" href="assets/css/fontawesome.min.css">
<style>
        
.product_detail_list{
    list-style: none;
    padding-left: 0px;
    float: left;
    justify-content: space-between;
    margin-top: 20px;
    overflow: hidden;
    height: 98px;
    display: flex;
}

.product_detail_list li{
    display: inline-block;
    width: 85px;
    box-shadow: 0 0px 10px rgba(0,0,0,0.2);
}

.product_detail_list img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.text_link{
            font-size: 14px;
            font-weight: 700;
            transition: color 0.3s linear;
            color: #333;
            text-decoration: none !important;
        }

        .text_link:hover{
            color: #b19361;
        }

        .hover_login:hover .box_login{
        display: block;

        }

        .hover_login:hover .box_login{
            background-color: red;
        }

        .box_login{
            position: absolute;
            width: 100px;
            top: 140%;
            left:-100px;
            padding: 4px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            /* display: none; */
            transition: all 0.3s linear;
            z-index: 10000;
        }

        .box_login::after{
            content: "";
            display: block;
            position: absolute;
            height: 50px;
            width: 20px;
        /*     background-color: red; */
            top: -30px;
            width: 100%;
        }

        .cover_img_user{
        width: 200px;
        height: 200px;
        border-radius: 50%;
        
        }

        .cover_img_user img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        }

        .cover_img_avatar{
            height: 30px;
            width: 30px;
        }

        .cover_img_avatar img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

</style>
<body>
    <?php
        include("modules/header.php");
    ?>

    <div role="main">
        <div class="row">
            <?php
                if(isset($_GET["page"])) {
                    $page = $_GET["page"];
                    $file = "modules/".$page.".php";
                    include($file);
                }
                else {
                    include("modules/home.php");
                }
            ?>
        </div>
    </div>
    
    <?php
        include("modules/footer.php");
    ?>
    
</body>

    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/web.js"></script>

    <script>
        $(document).ready(function(){
            $('.input_update_cart').blur(function(){
                const quanlity = $(this).val();
                const cart_id = $(this).attr('id');
                $.post({
                    url:"update_cart.php",
                    data: {cart_id:cart_id,quanlity:quanlity},
                    success:function(data){
                        $('#numcart').html(data);
                    }
                })
            });

            $('.image_chilren').click(function(){
                $new_src_image = $(this).attr('src');
                $('.image_primary').attr('src',$new_src_image);
            });

            $('.btn_confirm_order_user').click(function(){
                const order_id = $(this).attr('id');
                $.get({
                    url:"update_order_user.php",
                    data: {order_id:order_id},
                    success: function(data){
                        $('.btn_confirm_order_user'+data).removeClass('btn btn-sm btn-primary btn_confirm_order_user');
                        $('.btn_confirm_order_user'+data).html('Đã nhận hàng');
                    }
                })
            });

        });

    </script>

</html>