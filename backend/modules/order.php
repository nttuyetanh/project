<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Danh sách đơn hàng</h2>
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
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Thông tin đơn hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Thời gian đặt hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Câu lệnh select lấy dữ liệu
                        $sqlSelect = "SELECT * FROM tbl_order";
                        
                        //Thực thi truy vấn
                        $result = $conn->query($sqlSelect) or die("Lỗi truy vấn lấy dữ liệu");
                        if($result->rowCount() > 0) {
                            $i=0;
                            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $i++;
                        ?>
                    <tr>
                        <td><?php echo $row["order_id"]; ?></td>
                        <td><?php echo $row["full_name"]; ?></td>
                        <td>
                        <?php 
                            $order_id = $row['order_id'];
                            $query_order_detail = "SELECT * FROM tbl_order_detail WHERE order_id='$order_id' ";
                            $result_order_detail = $conn->query($query_order_detail);
                            if($result_order_detail->rowCount()>0){
                                $total = 0;
                                while($row_order_detail = $result_order_detail->fetch()){ 
                                        $total += $row_order_detail['pro_price'] * $row_order_detail['pro_quantity']; 
                                        ?>
                                
                            <span>
                                <span><?php $row_order_detail['pro_name'] ?></span>
                            </span><br>

                            <span>
                                <img height="50" width="50" src="../uploads/<?php echo $row_order_detail['pro_image'] ?>" alt="">
                                <span class="float-right text-secondary"><?php echo $row_order_detail['pro_price'] ?>vnđ x <?php echo $row_order_detail['pro_quantity'] ?></span>
                            <br>
                            <?php }}?>
                            
                                    <h5 class="font-weight-bold mt-3" style="font-size: 16px;">Thanh toán <span class="float-right "><?php echo number_format($total) ?>vnđ</span></h5>
                                </span>
                            </span>
                        </td>
                        <td><?php echo $row["phone"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        <?php 
                            if($row['status']==1){
                                $string_status = "Xác nhận";
                                $span_class = "btn btn-sm btn-primary btn_confirm_order";
                            }elseif($row['status']==2){
                                $string_status = "Đang giao hàng";
                                $span_class = "";
                            }else{
                                $string_status = "Đã giao hàng";
                                $span_class = "";
                            }
                        ?>
                        <td><span id="<?php echo $row['order_id'] ?>" class="btn_confirm_order_<?php echo $row['order_id']; ?> <?php echo $span_class ?>"><?php echo $string_status; ?></span></td>
                        <td><?php echo date("d-m-Y H:i:s",strtotime($row["date_create"])); ?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>