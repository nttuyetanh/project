<style>
    td.overflow {
    width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 25px;
    -webkit-line-clamp: 4;
    height: 120px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    }
</style>
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Thêm mới sản phẩm</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <?php
                //Xử lý upload file
                $path ="uploads";
                $fileName="";
                if(isset($_FILES["image"])) {
                    if(isset($_FILES["image"]["name"])) {
                        if($_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png" || $_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/webp" || $_FILES["image"]["type"] == "image/gif") {
                            if($_FILES["image"]["size"] <= 24000000) {
                                if($_FILES["image"]["error"]==0) {
                                    //di chuyển file vào thư mục uploads
                                    move_uploaded_file($_FILES["image"]["tmp_name"],"../".$path."/".$_FILES["image"]["name"]);
                                    $fileName = $_FILES["image"]["name"];
                                } else {
                                    echo "Lỗi file";
                                }
                            } else {
                                echo "File quá lớn";
                            }
                        } else {
                            echo "File không phải là ảnh";
                        }
                    } else {
                        echo "Bạn chưa chọn file";
                    }
                }
                
                if(isset($_FILES["images"])) {
                    if(isset($_FILES["images"]["name"])) {
                        $files = $_FILES["images"];
                        $filesName = $files["name"];
                        //di chuyển file vào thư mục uploads
                        foreach($filesName as $key => $value) {
                            $filesName = basename($_FILES["images"]["name"][$key]);
                            $targetFilePath = "../".$path."/".$filesName;
                            move_uploaded_file($_FILES["images"]["tmp_name"][$key],$targetFilePath);
                        }
                    } else {
                        echo "Bạn chưa chọn file";
                    }
                }
                
                if(isset($_POST["addNew"])) {
                    $pro_name = $_POST["pro_name"];
                    $cat_id = $_POST["cat_id"] ;
                    $brand_id = $_POST["brand_id"] ;
                    $image = $fileName;
                    $images = $filesName;
                    $price = $_POST["price"] ;
                    $description = $_POST["description"] ;
                    $status = isset($_POST["status"])?1:0;
                    $date_create = date("Y-m-d H:i:s");
                
                    $err = [];
                    if(empty($pro_name)) {
                        $err['pro_name'] = 'Bạn chưa nhập tên sản phẩm';
                    }
                
                    if(empty($image)) {
                        $err['image'] = 'Bạn chưa chọn ảnh đại diện';
                    }
                
                    if(empty($images)) {
                        $err['images'] = 'Bạn chưa chọn ảnh mô tả';
                    }
                
                    if(empty($price)) {
                        $err['price'] = 'Bạn chưa nhập giá';
                    }
                
                    if(empty($description)) {
                        $err['description'] = 'Bạn chưa nhập mô tả';
                    }
                
                    if(empty($err)) {
                        $table = "tbl_product";
                        $_POST["status"]=$status;
                        $_POST["date_create"]=$date_create;
                        $_POST["image"]=$fileName;
                        $data = $_POST;
                        addNew($table,$data);
            
                        $pro_id = $conn->lastInsertId();
            
                        foreach($files["name"] as $key => $value) {
                            $sqlInsertFiles = "INSERT INTO tbl_images(pro_id, image) VALUES('$pro_id','$value')";
                            $conn->exec($sqlInsertFiles);
                        }
                    }
                }
                
                //Kiểm tra tham số id trên URL trường hợp edit
                $pro_name = "";
                $cat_id = "";
                $brand_id = "";
                $image = "";
                $price = "";
                $description = "";
                $status = false;
                if(isset($_GET["id"]) && isset($_GET["edit"])) {
                    $sqlEdit = "SELECT * FROM tbl_product WHERE pro_id=".$_GET["id"];
                    $resultEdit = $conn->query($sqlEdit);
                    $rowEdit = $resultEdit->fetch();
                    $pro_name = $rowEdit[1];
                    $cat_id = $rowEdit[2];
                    $brand_id = $rowEdit[3];
                    $image = $rowEdit[4];
                    $price = $rowEdit[5];
                    $description = $rowEdit[6];
                    $status = ($rowEdit[7])?true:false;
                    
                }
                
                //Kiểm tra tham số id trên URL trường hợp delete
                if(isset($_GET["id"]) && isset($_GET["del"])) {
                    $sqlDelete = "DELETE FROM tbl_product WHERE pro_id=".$_GET["id"];
                    $conn->exec($sqlDelete) or die("Lỗi xóa bản ghi");
                    header("location: index.php?page=product");
                }
                ?>
            <form action="<?php echo isset($rowEdit)?"./modules/updatePro.php":"" ?>" class="form-label-left input_mask" method="post" enctype="multipart/form-data">
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Tên sản phẩm</h6>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"  value="<?php echo $pro_name; ?>" id="pro_name" name="pro_name" placeholder="Nhập tên sản phẩm">
                            <div style="color: red">
                                <span><?php echo(isset($err['pro_name']))?$err['pro_name']:'' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Danh mục</h6>
                        </label>
                        <div class="col-sm-8">
                            <?php
                                $sqlSelectCat="SELECT * FROM tbl_category WHERE status=1";
                                $resultCat = $conn->query($sqlSelectCat) or die("Lỗi truy vấn lấy dữ liệu");
                                ?>
                            <select class="form-control" id="cat_id" name="cat_id">
                                <option>-- Chọn Danh Mục --</option>
                                <?php
                                    if($resultCat->rowCount() > 0) {
                                        while($rowCat = $resultCat->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                <option <?php echo (isset($rowEdit) && $rowEdit['cat_id']==$rowCat['cat_id'])?"selected":"" ?> value="<?php echo $rowCat["cat_id"] ?>"><?php echo $rowCat["cat_name"] ?></option>
                                <?php } } ?>
                            </select>
                            <div style="color: red">
                                <span><?php echo(isset($err['cat_id']))?$err['cat_id']:'' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Thương hiệu</h6>
                        </label>
                        <div class="col-sm-8">
                            <?php
                                $sqlSelectBrand="SELECT * FROM tbl_brand WHERE status=1";
                                $resultBrand = $conn->query($sqlSelectBrand) or die("Lỗi truy vấn lấy dữ liệu");
                                ?>
                            <select class="form-control" id="brand_id" name="brand_id">
                                <option value="">-- Chọn Thương Hiệu --</option>
                                <?php
                                    if($resultBrand->rowCount() > 0) {
                                        while($rowBrand = $resultBrand->fetch()) {
                                    ?>
                                <option <?php echo (isset($rowEdit) && $rowEdit['brand_id']==$rowBrand["brand_id"])?"selected":"" ?>  value="<?php echo $rowBrand["brand_id"] ?>"><?php echo $rowBrand["brand_name"] ?></option>
                                <?php } } ?>
                            </select>
                            <div style="color: red">
                                <span><?php echo(isset($err['brand_id']))?$err['brand_id']:'' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Giá bán</h6>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"  value="<?php echo $price; ?>" id="price" name="price" placeholder="Nhập giá bán">
                            <div style="color: red">
                                <span><?php echo(isset($err['price']))?$err['price']:'' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Ảnh đại diện</h6>
                        </label>
                        <div class="col-sm-8">
                            <input type ="file" value="<?php echo $image; ?>" id="image" name="image">
                            <div style="color: red">
                                <span><?php echo(isset($err['image']))?$err['image']:'' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Ảnh mô tả</h6>
                        </label>
                        <div class="col-sm-8">
                            <input type ="file" id="images[]" name="images[]" multiple/>
                            <div style="color: red">
                                <span><?php echo(isset($err['images']))?$err['images']:'' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">
                            <h6>Trạng thái</h6>
                        </label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" value="1" <?php echo ($status)?"checked":"" ?> name="status" id="status"> Ẩn/Hiển thị
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 x_content">
                    <h6>Nhập mô tả</h6>
                    <textarea class="resizable_textarea form-control" id="description" name="description"><?php echo $description; ?></textarea>
                    <div style="color: red">
                        <span><?php echo(isset($err['description']))?$err['description']:'' ?></span>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group row">
                    <div class="col-md-9 col-sm-9 offset-md-3">
                        <button type="button" class="btn btn-primary">Cancel</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <?php
                            if(isset($rowEdit)){ ?>
                        <input type="hidden" name="pro_id" value="<?php echo $rowEdit['pro_id'] ?>"> 
                        <button type="submit" class="btn btn-danger" name="editPro">Update</button>
                        <?php }else{ ?>
                        <button type="submit" class="btn btn-success" name="addNew">Submit</button>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Danh sách sản phẩm</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class=" col-md-12 table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Thương hiệu</th>
                        <th>Giá</th>
                        <th>Hình ảnh đại diện</th>
                        <th>Mô tả</th>
                        <th>Ngày nhập</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Câu lệnh select lấy dữ liệu
                        $sqlSelect = "SELECT * FROM tbl_product";
                        
                        //Thực thi truy vấn
                        $result = $conn->query($sqlSelect) or die("Lỗi truy vấn lấy dữ liệu");
                        if($result->rowCount() > 0) {
                            $i=0;
                            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $cat_id = $row["cat_id"];
                                $sqlSelect_cat = "SELECT * FROM tbl_category WHERE cat_id='$cat_id'";
                                $result_cat = $conn->query($sqlSelect_cat) or die("Lỗi truy vấn lấy dữ liệu");
                                $row_cat = $result_cat->fetch(PDO::FETCH_ASSOC);
                        
                                $brand_id = $row["brand_id"];
                                $sqlSelect_brand = "SELECT * FROM tbl_brand WHERE brand_id='$brand_id'";
                                $result_brand = $conn->query($sqlSelect_brand) or die("Lỗi truy vấn lấy dữ liệu");
                                $row_brand = $result_brand->fetch(PDO::FETCH_ASSOC);
                        
                                $i++;
                        ?>
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $row["pro_name"]; ?></td>
                        <td><?php echo $row_cat["cat_name"]; ?></td>
                        <td><?php echo ($row["status"])?"Hiển thị":"Ẩn";?></td>
                        <td><?php echo $row_brand["brand_name"]; ?></td>
                        <td><?php echo number_format( $row["price"]); ?>đ</td>
                        <td><img width="50" src="../uploads/<?php echo $row["image"]; ?>"></td>
                        <td class="overflow"><?php echo $row["description"]; ?></td>
                        <td><?php echo date("d-m-Y H:i:s",strtotime($row["date_create"])); ?></td>
                        <td>
                            <a href="index.php?page=product&id=<?php echo $row["pro_id"]; ?>&edit=1">
                            <i class="fa fa-pencil-square-o"></i> Sửa / </a>
                            <a href="index.php?page=product&id=<?php echo $row["pro_id"]; ?>&del=1" onclick="return confirm('Bạn chắc chắn muốn xóa bản ghi này?');">
                            <i class="fa fa-trash-o"></i> Xóa</a>
                        </td>
                    </tr>
                    <?php  }}?>
                </tbody>
            </table>
        </div>
    </div>
</div>