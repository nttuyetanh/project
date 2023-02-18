<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <form action="index.php?page=search" method="POST">
            <input type="text" name="keyword" />
            <input type="submit" class="btn btn-success" name="btn_seach" value="Tìm kiếm">
        </form>
    </div>  
    <div class="col-md-4">
    </div>
    <div class="col-md-9">
        <ul class="list-inline shop-top-menu pb-3 pt-1">
            <li class="list-inline-item">
                <a class="h3 text-dark text-decoration-none mr-3" href="index.php?page=shop">Tất cả</a>
            </li>

            <?php
                $sqlSelect = "SELECT * FROM tbl_category WHERE `status`=1";
                $resultCat = $conn->query($sqlSelect) or die("Lỗi truy vấn dữ liệu");
                if($resultCat->rowCount() > 0) {
                    while($rowCat = $resultCat->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <li class="list-inline-item">
                    <a class="h3 text-dark text-decoration-none" href="index.php?page=category&cat_id=<?php echo $rowCat["cat_id"] ?>"><?php echo $rowCat["cat_name"] ?></a>
                </li>
            <?php } } ?>
        </ul>
    </div>

    <div class="col-md-3">
        <div class="d-flex">
            <select class="form-control" id="sort-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="">-- Sắp xếp --</option>
                <option value="index.php?page=shop&sort=desc">Giá từ thấp đến cao <i class="fa fa-sort-amount-desc" aria-hidden="true"></option>
                <option value="index.php?page=shop&sort=asc">Giá từ cao đến thấp </option>
            </select>
        </div>
    </div>
</div>

