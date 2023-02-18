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
                        <h1 class="entry-title">Giỏ hàng</h1>
                        
                        
                    </div>
                    <hr/>
                </div>
				<div class="checkout-right">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th style="background-color: #59AB6E!important">Tên sản phẩm</th>
								<th style="background-color: #59AB6E!important">Sản phẩm</th>
								<th style="background-color: #59AB6E!important">Thương hiệu</th>
								<th style="background-color: #59AB6E!important">Danh mục</th>
								<th style="background-color: #59AB6E!important">Kích cỡ</th>
								<th style="background-color: #59AB6E!important">Số lượng</th>
								<th style="background-color: #59AB6E!important">Giá</th>
								<th style="background-color: #59AB6E!important">Xóa bỏ</th>
							</tr>
						</thead>

						<tbody>
                            <?php
                                $total=0;
                                if(isset($_SESSION["cart"])) {
                                    $i=0;
                                    foreach($_SESSION["cart"] as $key=>$value) {
                                        $i+1;
                                        //tim san pham detail   
                            ?>
                                <tr class="rem1">
                                    <td class="invert"><?php echo $value["name"]; ?></td>
                                    <td class="invert-image"><img width="50px" src="./uploads/<?php echo $value["image"]; ?>"></td>
                                    <td class="invert"><?php echo $value["brand_name"]; ?></td>
                                    <td class="invert"><?php echo $value["cat_name"]; ?></td>
                                    <td id="size_cart" class="invert"><?php echo $value["size"]; ?></td>
                                    <td class="invert">
                                        <input type="text" id="<?php echo $key; ?>"  class="input_update_cart form-control input-number text-center" value="<?php echo $value["quanlity"]; ?>" min="1">
                                    </td>
                                    <td class="invert"><?php echo number_format($value["price"]*$value["quanlity"],0,",","."); $total += $value["price"]*$value["quanlity"]; ?> vnđ</td>
                                    <td class="invert">
                                        <div class="rem">
                                            <div class="close1"><a href="delete_item_cart.php?cart_id=<?php echo $key; ?>" class="btn" style="text-decoration: none; color: black;" ><i class="fas fa-trash-alt"></i></a></div>
                                        </div>

                                    </td>
                                </tr>
                            <?php } } ?>
						</tbody>
					</table>
				</div>
                <hr/>
				<div class="row">
					<div class="col-md-4">
						<h3 style="text-align:right;">Tổng tiền: <?php echo number_format($total,0,",",".") ?> vnđ</h3>
					</div>
                    <div class="col-md-7" style="text-align:right;">
                    <a href="index.php?page=checkout" class="btn btn-success" style="height:50px;width:300px;color: white"><h4>Thanh toán</h4></a>
                        <!-- <button class="btn btn-success" style="height:50px;width:300px;"><a style="text-decoration: none; color: white;" href="index.php?page=checkout" ><h4>Thanh toán</h4></a></button> -->
					</div>
				</div>
                <hr/>
			</div>
		</div>
<!-- //top products -->
</div>
</section>