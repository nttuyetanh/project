
<style>
    p.overflow {
        width: 500px;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 25px;
        -webkit-line-clamp: 3;
        height: 75px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }
</style>


<!-- Open Content -->
<section class="bg-light">
    <div class="container pb-5">
        <?php
            if(isset($_GET["id"])) {
                $id = $_GET["id"];
                $sqlDetailPro = "SELECT p.*, b.brand_name FROM tbl_product AS p INNER JOIN tbl_brand AS b ON b.brand_id = b.brand_id WHERE pro_id = $id";
                $resultDetailPro = $conn->query($sqlDetailPro);
                $rowDetailPro = $resultDetailPro->fetch();
                
        ?>
            <div class="row">
                
                <div class="col-lg-6 mt-5">
                    <div class="card mb-3">
                        <img src="./uploads/<?php echo $rowDetailPro[4]; ?>" class="image_primary card-img img-fluid" alt="<?php echo $rowDetailPro[1] ?>">
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <ul class="product_detail_list" style="width:500px;">
                                <?php 
                                    $pro_id = $rowDetailPro['pro_id'];
                                    $query_select_array_image = "SELECT * FROM tbl_images WHERE pro_id = '$pro_id'";
                                    $result_select_array_image = $conn->query($query_select_array_image);
                                    while($row = $result_select_array_image->fetch()){ ?>
                                        <img style="margin-left: 20px;" width="200px"  class="image_chilren" src="./uploads/<?php echo $row['image'] ?>" alt="">
                                <?php } ?>
                            
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5">
                    <div class="card">
 
                        <div class="card-body">
                            <form action="addCart.php" method="POST">
                            <h1 class="h2"><?php echo $rowDetailPro[1]; ?></h1>
                            <p class="h3 py-2"><?php echo number_format($rowDetailPro[5],0,",","."); ?> vnđ</p>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <h6>Thương hiệu:</h6>
                                    </li>
                                    <li class="list-inline-item">
                                        <?php 
                                        $brand_id = $rowDetailPro['brand_id'];
                                            $query_select_tbl_brand_by_brand_id = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id'";
                                            $result_select_tbl_brand_by_brand_id = $conn->query($query_select_tbl_brand_by_brand_id);
                                            $row_select_tbl_brand_by_brand_id = $result_select_tbl_brand_by_brand_id->fetch();
                                        ?>
                                        <input type="hidden" name="brand_name" value="<?php echo $row_select_tbl_brand_by_brand_id['brand_name']; ?>">
                                        <p class="text-muted"><strong><?php echo $row_select_tbl_brand_by_brand_id['brand_name']; ?></strong></p>
                                    </li>
                                </ul>
                            </p>   
                            </p>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <h6>Danh mục: </h6>
                                    </li>
                                    <li class="list-inline-item">
                                        <?php 
                                        $cat_id = $rowDetailPro['cat_id'];
                                            $query_select_tbl_category_by_cat_id = "SELECT * FROM tbl_category WHERE cat_id = '$cat_id'";
                                            $result_select_tbl_category_by_cat_id = $conn->query($query_select_tbl_category_by_cat_id);
                                            $row_select_tbl_category_by_cat_id = $result_select_tbl_category_by_cat_id->fetch();
                                        ?>
                                        <input type="hidden" name="cat_name" value="<?php echo $row_select_tbl_category_by_cat_id['cat_name']; ?>">
                                        <p class="text-muted"><strong><?php echo $row_select_tbl_category_by_cat_id['cat_name']; ?></strong></p>
                                    </li>
                                </ul>
                            </p>                                
                            <h6>Mô tả:</h6>
                            <p class="overflow"><?php echo $rowDetailPro[6]; ?></p>

                            
                                <input type="hidden" name="product-title" value="Activewear">
                                
                                <div class="row">
                                    <div class="col-2">
                                        <h6>Kích cỡ :</h6>
                                    </div>
                                    <div class="col-6">
                                        <select name="size" class="form-select">
                                        <?php
                                            if($rowDetailPro['cat_id']==1 || $rowDetailPro['cat_id']==3){ //nguoi lon
                                                for($i = 36;$i<=42;$i=$i+0.5){ ?>
                                                    <option value=<?php echo $i; ?>><?php echo $i ?></option>
                                            <?php  }
                                            }else{ // tre em
                                                for($i=28;$i<=35;$i++){ ?>
                                                    <option value=<?php echo $i;?>><?php echo $i ?></option>
                                            <?php  }
                                            }
                                        ?>
                                    </div>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col mt-5" style="margin-left: 40px; margin-right: 40px; margin-bottom: 20px;">
                                        <div class=input-group mb-4>
                                            <span class="input-group-btn" onclick="minus()">
                                                <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                                    <i class="far fa-minus-square" style="font-size: 30px; color: seagreen;"></i>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity" name="quantity" class="form-control input-number text-center" value="1" min="1">
                                            <span class="input-group-btn ml-1" onclick="plus()">
                                                <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                                    <i class="far fa-plus-square" style="font-size: 30px; color: seagreen;"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row pb-3">
                                        <div class="col d-grid">
                                            <input type="hidden" name="pro_id" value="<?php echo $rowDetailPro['pro_id']; ?>">
                                            <button type="submit" class="btn btn-success btn-lg">Thêm vào giỏ hàng</button>       
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </br>
            </br>
            <div class="row">
                <div class="col-sm-6">
                    <h3 style="color: #59ab6e;">Mô tả</h3>
                    <div style="color:black;">
                        <?php echo $rowDetailPro[6]; ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php
                        if($rowDetailPro[2] == 2) {
                    ?>
                        <img src="images/sizegiaybe.png">
                    <?php } ?>
                    <?php
                        if($rowDetailPro[2] == 1) {
                    ?>
                        <img src="images/sizegiaynguoilon.png">
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

</section>
<!-- Close Content -->

<!-- Start Slider Script -->
<script src="assets/js/slick.min.js"></script>
<script>
    $('#carousel-related-product').slick({
        infinite: true,
        arrows: false,
        slidesToShow: 4,
        slidesToScroll: 3,
        dots: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            }
        ]
    });
</script>
<!-- End Slider Script -->