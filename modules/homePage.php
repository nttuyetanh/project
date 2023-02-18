<style>
    .pink{
    background-color: #FFB5C5;
    }

    .green{
    background-color: #A2CD5A;
    }

    .teal {
        background-color: #DDC488;
    }

    a h2 {
    color: white;
    }

    a:hover {
    text-decoration: none!important;
    }

    .first .pink, .first .pic, .first .green{
    padding-right: 0px !important;
    padding-left: 0px!important;
    }

    .green a, .pink a, .teal a{
        padding: 6%;
    }

    .message{
        background-color: #222828;
        color: #fcfdff;
        padding: 10%;
    }

    .message a{
        color:black!important;
        background-color: white;
    }

    .message a{
        text-decoration: none!important;

    }
    .message button {
    background-color: white;
    padding: 1%;
    border-radius: 9%;
    }

    .what_to_do h2{
    padding: 2%;
    color: black;
    }
    .what_to_do i{
        font-size: 40px;
    }
    .what_to_do div {
        padding: 3%;
        color: #222828;
    }

    .what_to_do button,.four button{
    background-color: transparent;
    border-radius: 6px;
    padding: 3%;
    }

    .what_to_do button a{
    color:  #222828;
    font-variant: all-petite-caps;
    }

</style>

<div id="about" class="about-area area-padding" style="margin-top: 30px;">
    <div class="container">
    <div class="row">
        <!-- single-well start-->
        <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="well-left">
            <div class="single-well">
                <img width="500px" src="images/bia6.jpg" alt="">
            </div>
        </div>
        </div>
        <!-- single-well end-->
        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 70px;">
        <div class="well-middle">
            <div class="single-well">
            <p>
                Panacea cam kết đem đến khách hàng Việt Nam những trải nghiệm tốt nhất về sản phẩm của mình
            </p>
            <ul style="list-style: none;">
                <li>
                <i class="fas fa-check-square" style="color: #59ab6e;"></i> Giá cả hợp lý
                </li>
                <li>
                <i class="fas fa-check-square" style="color: #59ab6e;"></i> Dịch vụ vận chuyển nhanh
                </li>
                <li>
                <i class="fas fa-check-square" style="color: #59ab6e;"></i> Cam kết chính hãng
                </li>
                <li>
                <i class="fas fa-check-square" style="color: #59ab6e;"></i> Hỗ trợ tư vấn nhiệt tình
                </li>
            </ul>
            </div>
        </div>
        </div>
        <!-- End col-->
    </div>
    </div>
</div>

<!-- ======= About Section ======= -->
<div id="about" class="about-area area-padding" style="margin-top: 50px;">
    <div class="first">
        <div class="container">
            <div class="row">
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 pink">
                        <h2 style="margin-top: 100px; margin-left: 130px; color: white;">Tự Tin</h2>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 pic">
                        <img style="width:100%;"src="images/bia.jpg">
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 green">
                        <a>
                            <h2 style="margin-top: 80px; margin-left: 120px; color: white;">Cá Tính</h2>
                        </a>
                    </div>
            </div>
            <div class="row">
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 pic">
                            <img style="width:100%;"src="images/bia5.jpg">
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 teal">
                        <h2 style="margin-top: 100px; margin-left: 100px; color: white;">Khác Biệt</h2>
                    </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 pic">
                            <img style="width:100%;"src="images/bia7.jpg">
                    </div>
            </div>
        </div>
    </div>
</div>


<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h2 class="h1">Bán chạy nhất</h2>
            </div>
        </div>
        <div class="row">
            <?php
                $sqlPro = "SELECT * FROM tbl_product WHERE `status`=1 LIMIT 4";
                $resultProHome = $conn->query($sqlPro) or die("Lỗi truy vấn lấy dữ liệu");
                if($resultProHome->rowCount() > 0) {
                    while($rowProHome = $resultProHome->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="col-md-3">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0" style="height: 250px">
                                <a href="index.php?trang=detail&id=<?php echo $rowProHome["pro_id"] ?>">
                                    <img src="./uploads/<?php echo $rowProHome["image"] ?>" class="card-img-top" alt="<?php echo $rowProHome["pro_name"] ?>">
                                </a>
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" style="height: 150px">
                                <a href="index.php?trang=detail&id=<?php echo $rowProHome["pro_id"] ?>" class="h2p text-decoration-none text-dark"><?php echo $rowProHome["pro_name"] ?></a>
                                <p class="text mb-0" style="color:green;"><?php echo number_format($rowProHome["price"],0,",",".") ?> vnđ</p>
                            </div>
                        </div>
                    </div>
            <?php } } ?>
        </div>
    </div>
</section>