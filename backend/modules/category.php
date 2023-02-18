<div class="col-md-5">
    <div class="x_panel">
        <div class="x_title">
            <h2>Thêm mới danh mục</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <?php
                $err = [];
                //Thêm category
                if(isset($_POST["addNew"])) {
                    $catName = $_POST["cat_name"];
                    $status = isset($_POST["status"])?1:0;
                    $date_create = date("Y-m-d H:i:s");

                    if(empty($catName)) {
                        $err['cat_name'] = 'Bạn chưa nhập tên danh mục';
                    }

                    if(empty($err)) {
                        $table = "tbl_category";
                        $_POST["status"]=$status;
                        $_POST["date_create"]=$date_create;

                        $data = $_POST;
                        addNew($table,$data);
                    }
                }elseif(isset($_POST['editCat'])){
                    $cat_id = $_POST['cat_id'];
                    $cat_name = $_POST['cat_name'];
                    $status = isset($_POST['status'])?1:0;
                    $date_update = date('Y-m-d H:i:s');
                    $query_update_cat = "UPDATE tbl_category SET cat_name='$cat_name',status='$status',date_create='$date_update' WHERE cat_id='$cat_id'";
                    $result_update_cat = $conn->query($query_update_cat);
                    header('location: index.php?page=category');
                }

                //Kiểm tra tham số id trên URL trường hợp edit
                //Lấy ra user_edit
                $cat_name="";
                $status=false;
                if(isset($_GET["id"]) && isset($_GET["edit"])) {
                    $sqlEdit = "SELECT * FROM tbl_category WHERE cat_id=".$_GET["id"];
                    $resultEdit = $conn->query($sqlEdit);
                    $rowEdit = $resultEdit->fetch();
                    $cat_name = $rowEdit[1];
                    $status = ($rowEdit[2])?true:false;
                }

                //Kiểm tra tham số id trên URL trường hợp delete
                if(isset($_GET["id"]) && isset($_GET["del"])) {
                    $sqlDelete = "DELETE FROM tbl_category WHERE cat_id=".$_GET["id"];
                    $conn->exec($sqlDelete) or die("Lỗi xóa bản ghi");
                    header("location: index.php?page=category");
                }
            ?>
            <form class="form-label-left input_mask" method="post">
                <div class="form-group row">
                    <label class="col-form-label col-md-3 col-sm-3 ">Tên danh mục</label>
                    <div class="col-md-9 col-sm-9 ">
                        <input type="text" class="form-control" value="<?php echo $cat_name; ?>" name="cat_name" id="cat_name" placeholder="Nhập tên danh mục">
                    </div>
                    <div style="color: red">
                        <span><?php echo(isset($err['cat_name']))?$err['cat_name']:'' ?></span>
                    </div>

                </div>
                
                <div class="form-group row">
                    <label class="col-md-3 col-sm-3  control-label">Trạng thái</label>

                    <div class="col-md-9 col-sm-9 ">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" <?php echo ($status)?"checked":"" ?> name="status" id="status"> Ẩn/Hiển thị
                            </label>
                        </div>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group row">
                    <div class="col-md-9 col-sm-9  offset-md-3">
                        <a type="button" class="btn btn-primary text-white">Cancel</a>
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <?php 
                            if(isset($rowEdit)){ ?>
                                    <input type="hidden" name="date_create" value="<?php echo $rowEdit['date_create']; ?>">
                                    <input type="hidden" name="cat_id" value="<?php echo $rowEdit['cat_id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="editCat">Update</button>
                            <?php }else{ ?>
                                <button type="submit" class="btn btn-success" name="addNew">Submit</button>
                           <?php  } ?>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="col-md-7">
    <div class="x_panel">
        <div class="x_title">
        <h2>Bảng danh mục</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên danh mục</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <?php
                //Câu lệnh select lấy dữ liệu
                $sqlSelect = "SELECT * FROM tbl_category";

                //Thực thi truy vấn
                $result = $conn->query($sqlSelect) or die("Lỗi truy vấn lấy dữ liệu");
                if($result->rowCount() > 0) {
                    $i=0;
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $i++;
            ?>
                <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo $row["cat_name"]; ?></td>
                    <td><?php echo ($row["status"])?"Hiển thị":"Ẩn";?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($row["date_create"])); ?></td>
                    <td>
                        <a class="btn btn-warning btn-sm" href="index.php?page=category&id=<?php echo $row["cat_id"]; ?>&edit=1">
                            <i class="fa fa-pencil-square-o"></i></a>
                        <!-- <a href="index.php?page=category&id=<?php echo $row["cat_id"]; ?>&del=1" onclick="return confirm('Bạn chắc chắn muốn xóa bản ghi này?');">
                        <i class="fa fa-trash-o"></i> Xóa</a> -->
                        <button class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#btn_delete_blog<?php echo $row['cat_id'] ?>"><i class="fa fa-trash-o"></i></button>

                        <div class="modal fade" id="btn_delete_blog<?php echo $row['cat_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Xóa danh mục </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Bạn chắc chắn muốn xóa danh mục này?</h6>
                                    </div>
                                    <div class="modal-footer">
                                        
                                            
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <a href="index.php?page=category&id=<?php echo $row["cat_id"]; ?>&del=1" class="btn btn-danger">Delete</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } }?>
            </tbody>
        </table>

        </div>
    </div>
</div>