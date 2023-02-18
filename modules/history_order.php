<style>
    table, th, td{
    border:1px solid #868585;
    }
    table{
    border-collapse:collapse;
    width:100%;
    }
    th{
    text-align:center;
    padding:10px;
    background-color: #33CC66;
    }
    td{
    text-align:center;
    padding:10px;
    }
    tr:hover{
    background-color:#ddd;
    cursor:pointer;
    }
    h1.entry-title {
    font-family: 'DM Serif Display',Georgia,"Times New Roman",serif;
    line-height: 1.2em;
    font-size: 60px;
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    vertical-align: baseline;
    background: transparent;
    }
</style>
<!-- top Products -->
<section class="bg-light">
    <div class="container py-5">
    <div class="ads-grid_shop">
    <div class="shop_inner_inf">
        <div class="privacy about">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="entry-title">Lịch sử mua hàng</h1>
                </div>
                <hr/>
            </div>
            <div class="checkout-right">
                <style>
                    table, th, td{
                    border:1px solid #868585;
                    }
                    table{
                    border-collapse:collapse;
                    width:100%;
                    }
                    th{
                    text-align:center;
                    padding:10px;
                    background-color: #33CC66;
                    }
                    td{
                    text-align:center;
                    padding:10px;
                    }
                    tr:hover{
                    background-color:#ddd;
                    cursor:pointer;
                    }
                    h1.entry-title {
                    font-family: 'DM Serif Display',Georgia,"Times New Roman",serif;
                    line-height: 1.2em;
                    font-size: 60px;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    vertical-align: baseline;
                    background: transparent;
                    }
                </style>
                <!-- top Products -->
                <section class="bg-light">
                    <div class="container py-5">
                        <div class="ads-grid_shop">
                            <div class="shop_inner_inf">
                                <!-- <div class="privacy about"> -->
                                    <div class="row">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-center">Người nhận hàng</th>
                                                    <th class="text-center">Thông tin sản phẩm</th>
                                                    <th class="text-center">Địa chỉ giao hàng</th>
                                                    <th class="text-center">Ngày đặt hàng</th>
                                                    <th class="text-center">Tình trạng đơn hàng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if(isset($_SESSION['user_login'])){
                                                        $user_id = $_SESSION['user_login']['user_id'];
                                                        // $query_select_user = "SELECT * FROM user WHERE user_id = '$user_id'";
                                                        // $result_select_user = $conn->query($query_select_user);
                                                        // $row_select_user = $result_select_user->fetch(); //thong tin user

                                                        $query_order_by_user_id = "SELECT * FROM tbl_order WHERE user_id = '$user_id' ORDER BY date_create DESC";
                                                        $result_order_by_user_id = $conn->query($query_order_by_user_id);
                                                        if($result_order_by_user_id->rowCount()>0){
                                                            $i=0;
                                                            while($row_order = $result_order_by_user_id->fetch()){
                                                                $i++;
                                                          
                                                        
                                                       ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $row_order['full_name'] ?><br></td>
                                                    <td>
                                                        <?php 
                                                            $order_id = $row_order['order_id'];
                                                            $query_order_detail = "SELECT * FROM tbl_order_detail WHERE order_id='$order_id' ";
                                                            $result_order_detail = $conn->query($query_order_detail);
                                                            if($result_order_detail->rowCount()>0){
                                                                $total = 0;
                                                                while($row_order_detail = $result_order_detail->fetch()){ 
                                                                        $total += $row_order_detail['pro_price'] * $row_order_detail['pro_quantity'];
                                                                    ?>
                                                                    <span>
                                                                    <span><?php echo $row_order_detail['pro_name'] ?></span>
                                                                    </span><br>
                                                                    <span>
                                                                    <img height="50" width="50" src="./uploads/<?php echo $row_order_detail['pro_image'] ?>" alt="">
                                                                    <span class="float-right text-secondary"><?php echo $row_order_detail['pro_price'] ?>vnđ x <?php echo $row_order_detail['pro_quantity'] ?></span><br>
                                                        <?php }  } ?>
                                                        </span><br>
                                                       
                                                        <h5 class="font-weight-bold mt-3">Thanh toán <span class="float-right "><?php echo number_format($total + 35000) ?>vnđ</span></h5>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_order['address'] ?>
                                                    </td>
                                                    <td><?php echo $row_order['date_create'] ?></td>
                                                    <td class="text-center">
                                                    <?php 
                                                        if($row_order['status']==1){
                                                            $string_status = "Chờ nhận";
                                                            $span_class = "";
                                                        }elseif($row_order['status']==2){
                                                            $string_status = "Nhận hàng";
                                                            $span_class = "btn btn-sm btn-primary btn_confirm_order_user";
                                                        }else{
                                                            $string_status = "Đã nhận hàng";
                                                            $span_class = "";
                                                        }
                                                    ?>
                                                        <span id="<?php echo $row_order['order_id'] ?>" style="cursor:pointer" class="btn_confirm_order_user<?php echo $row_order['order_id'] ?> <?php echo $span_class ?>"><?php echo $string_status ?></span>
                                                    </td>
                                                </tr>
                                                <?php  }   } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <!-- //top products -->
                        </div>
                </section>
                </div>
                <hr/>
            </div>
        </div>
        <!-- //top products -->
    </div>
</section>