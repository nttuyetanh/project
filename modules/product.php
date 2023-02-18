<div class="container py-5">  
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?php
                include ("navCategory.php");

                if(isset($_GET["id"])) {
                    $cat_id = $_GET["id"];
                    $sqlCat = "SELECT * FROM tbl_category WHERE cat_id = $cat_id";
                    $resultCat = $conn->query($sqlCat);

                    if($resultCat->rowCount() > 0) {
                        $rowCat = $resultCat->fetch(PDO::FETCH_NUM);
                        echo $rowCat[1];
                    }

                }
            ?>
            <div class="row">
                <?php
                    if(isset($_GET["id"])) {
                        $cat_id = $_GET["id"];
                        $sqlPro = "SELECT * FROM tbl_product WHERE `status`=1 AND cat_id = $cat_id";
                        $resultProHome = $conn->query($sqlPro) or die("Lỗi truy vấn lấy dữ liệu");
                        if($resultProHome->rowCount() > 0) {
                            while($rowProHome = $resultProHome->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="col-md-3">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0" style="height: 250px;">
                                <a href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>">
                                    <img src="<?php echo $rowProHome["image"] ?>" class="card-img-top" alt="<?php echo $rowProHome["pro_name"] ?>">
                                </a>
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" style="height: 150px;">
                                <a href="index.php?page=detail&id=<?php echo $rowProHome["pro_id"] ?>" class="h2p text-decoration-none text-dark"><?php echo $rowProHome["pro_name"] ?></a>
                                <p class="text mb-0" style="color: green;"><?php echo number_format($rowProHome["price"],0,",",".") ?> vnđ</p>
                            </div>
                        </div>
                    </div>
                <?php } } } ?>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
</div>