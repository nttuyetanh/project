<section class="bg-light">
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <?php
                include("modules/navCategory.php");
            ?>
            <h6>Shop / Tất cả</h6>
            <h6>
            <?php
                if(isset($_GET['sort'])){
                    if($_GET['sort']=="desc"){
                        echo "Kết quả sắp xếp từ thấp đến cao theo giá";
                    }else{
                        echo "Kết quả sắp xếp từ cao đến thấp theo giá";
                    }
                }
            ?>
            </h6>
            <div class="row">
                <?php
                    $product = $conn->query("SELECT * FROM tbl_product WHERE `status`=1");
                    $total = $product->rowCount();
                    $limit = 12;
                    $quantity_trang = ceil($total/$limit);
                    
                    //pagination 
                    //xu li url
        
                    // url chua trang
                    $trang_index = 1;
                    if(isset($_GET['trang'])){ // co chua trang
                        $trang_index =  $_GET['trang']; 
                        $start_in = ($trang_index-1)*$limit;
                    }else{ //url khong chua 
                        $start_in = 0;
                    }
                    // echo $trang_index;
                    // die();
                    if(isset($_GET['sort'])){
                        if($_GET['sort']=='asc'){
                            $sqlPro = "SELECT * FROM tbl_product WHERE `status`=1 ORDER BY price DESC LIMIT $start_in,$limit";
                        }else{
                            $sqlPro = "SELECT * FROM tbl_product WHERE `status`=1 ORDER BY price ASC LIMIT $start_in,$limit";
                        }
                    }else{
                        $sqlPro = "SELECT * FROM tbl_product WHERE `status`=1 LIMIT $start_in,$limit";
                    }
                    $resultProHome = $conn->query($sqlPro) or die("Lỗi truy vấn lấy dữ liệu");
                    if($resultProHome->rowCount() > 0) {
                        while($rowProHome = $resultProHome->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="col-md-3">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0" style="height: 250px">
                                <a href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>">
                                    <img src="./uploads/<?php echo $rowProHome["image"] ?>" class="card-img-top" alt="<?php echo $rowProHome["pro_name"] ?>">
                                </a>
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" style="height: 150px">
                                <a href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>" class="h2p text-decoration-none text-dark"><?php echo $rowProHome["pro_name"] ?></a>
                                <p class="text mb-0" style="color:green;"><?php echo number_format($rowProHome["price"],0,",",".") ?> vnđ</p>
                            </div>
                        </div>
                    </div>
                <?php } } ?>
            </div>
        </div>
        <div class="row">
            <ul class="pagination pagination-lg justify-content-center">
                <?php 
                    for($i=1;$i<=$quantity_trang;$i++){ ?>
                        <li><a href="index.php?page=shop&trang=<?php echo $i ?>" <?php if($trang_index==$i){ ?> style="background-color: #fff; color: #000;" <?php } ?> class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" ><?php echo $i ?></a></li>
                <?php }  ?>
            </ul>
        </div>
    </div>
</div>
<section>