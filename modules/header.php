<?php 
    $total_product_of_cart=0;
?>
<title>Panacea</title>

<!-- Start Top Nav -->
<nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:panacea@gmail.com">panacea@gmail.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
            </div>
            <div>
                <button type="submit">
                    <?php 
                        if(isset($_SESSION['user_login'])){ ?>
                             <a style="text-decoration: none; color: red;" href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                      <?php  }else{ ?>
                        <a style="text-decoration: none; color: red;" href="login/login.php"></i> Đăng nhập</a>
                    <?php } ?>
                </button>
            </div>
        </div>
    </div>
</nav>
<!-- Close Top Nav -->

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <div class=col-1>
            <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
                Panacea
            </a>
        </div>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=shop">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=about">Về chúng tôi</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=contact">Liên hệ</a>
                    </li>
                    <?php 
                        if(isset($_SESSION['user_login'])){ ?>
                             <li class="nav-item">
                                <a class="nav-link" href="index.php?page=history_order">Lịch sử mua hàng</a>
                            </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <?php
               
                    $numberPro = 0;
                    if(isset($_SESSION["cart"])) {
                        foreach($_SESSION["cart"] as $key=>$value) {
                            $numberPro += $value["quanlity"];
                        }
                       
                      
                       
                    }
                ?>
                <a class="nav-icon position-relative text-decoration-none" href="index.php?page=cart">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span id="numcart" class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"><?php echo  $numberPro ; ?></span>
                </a> 
                
                <a style="text-decoration: none; text: white;" class="user-profile" href="javascript:;" aria-haspopup="true" aria-expanded="false">
                    <img src="images/user.png" width= 20px alt="">
                    <?php
                        if(isset($_SESSION["login"])) {
                            echo $_SESSION["login"][1];
                        }
                    ?>
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Close Header -->