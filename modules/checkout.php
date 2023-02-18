<?php 
   
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require('./vendor/autoload.php');
    require './vendor/phpmailer/phpmailer/src/Exception.php';
    require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require './vendor/phpmailer/phpmailer/src/SMTP.php';
    require './vendor/phpmailer/phpmailer/src/OAuth.php';
    require './vendor/phpmailer/phpmailer/src/POP3.php';
    function payment_vnpay($total){
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/Composer1_pdf/index.php?url=Cart/checkout";
        $vnp_TmnCode = "URHY337Q";//Mã website tại VNPAY 
        $vnp_HashSecret = "ZWJHOFQYTBYRPFLFZXIPCGSYPKINECAE"; //Chuỗi bí mật

        $vnp_TxnRef = rand(00,9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan demo';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo
    }
    function send_mail($email_user){
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8'; 
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'phammy773734@gmail.com';                     //SMTP username
                $mail->Password   = 'jqbwnmwkhfndmoxt';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('phammy773734@gmail.com', 'Mailer');
                $mail->addAddress($email_user, 'Joe User');     //Add a recipient
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Xác nhận đơn hàng';
                $mail->Body    = '<h1>Chúc mừng bạn đã đặt hàng thành công <a href="http://localhost/project/index.php?page=history_order">Kiểm tra lịch sử mua hàng</a></h1>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
    }


    if(!isset($_SESSION['user_login'])){
        header('location: login/login.php');
    }
?>
<style>
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

 
 <!--Main layout-->
<main class="mt-5 pt-4">
    <div class="container wow fadeIn">
        <h1 class="entry-title">Đặt hàng</h1>
        <?php
            $user_id = $_SESSION['user_login']['user_id'];
            $query_select_user = "SELECT * FROM user WHERE user_id = '$user_id'";
            $result_select_user =  $conn->query($query_select_user);
            $row_select_user = $result_select_user->fetch();
            $user = $_SESSION["user_login"];
            if(isset($_POST["redirect"])) {
                $dateTime = date("Y-m-d H:i:s");
                $user_id = $row_select_user['user_id'];
                $full_name = $_POST["full_name"];
                $address = $_POST["address"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $status = 1;
                $date_create = $dateTime;

                $sqlInsertOrder = "INSERT INTO tbl_order (user_id, full_name, address, email, phone, status, date_create) VALUES('$user_id','$full_name','$address','$email','$phone','$status','$date_create')";
                
                $conn->exec($sqlInsertOrder) or die("Lỗi câu lệnh thêm mới ");
                $order_id = $conn->lastInsertId(); //lấy ra ID vừa insert

                $err=[];
                if(empty($full_name)) {
                    $err['full_name'] = 'Bạn chưa nhập họ tên';
                }
                if(empty($address)) {
                    $err['address'] = 'Bạn chưa nhập địa chỉ';
                }
                if(empty($email)) {
                    $err['email'] = 'Bạn chưa nhập email';
                }
                if(empty($phone)) {
                    $err['phone'] = 'Bạn chưa nhập số điện thoại';
                }

                if(empty($err)) {
                    if(isset($_SESSION["cart"])) {
                        $total =0;
                        foreach($_SESSION["cart"] as $key=>$value) {
                            $total += (int)$value['price']*$value['quanlity'];
                            $pro_id = $value['id_pro'];
                            $pro_name = $value['name'];
                            $pro_image = $value['image'];
                            $pro_brand = $value['brand_name'];
                            $pro_cat = $value['cat_name'];
                            $pro_price = $value['price'];
                            $pro_quantity = $value['quanlity'];
                            $created_at = date('Y-m-d H:i:s');
                            $sqlInsertOrderDetail = "INSERT INTO tbl_order_detail VALUES('','$order_id', '$user_id', '$pro_id', '$pro_name','$pro_image', '$pro_brand','$pro_cat','$pro_price','$pro_quantity','$created_at')";
                            $conn->exec($sqlInsertOrderDetail) or die("Lỗi câu lệnh thêm mới");
                        }
                        if($_POST['method_payment']=='vnpay'){
                            payment_vnpay($total);
                        }
                        send_mail($email);
                        unset($_SESSION['cart']);
                        header('location: index.php');
                    }
                }
            }
        ?>
            <form method="post" class="colorlib-form">
                <div class="row">
                    <div class="col-md-6 md-6">
                        <div class="card">
                            <form class="card-body">
                                <div class="col-md-12 mb-2">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="margin-left: 15px;  margin-top: 15px;"><b>Họ tên:</b></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" value="<?php echo $row_select_user['user_name'] ?>" style=" margin-top: 15px;" id="full_name" name="full_name" placeholder="Nhập họ tên">
                                            <div style="color: red">
                                                <span><?php echo(isset($err['full_name']))?$err['full_name']:'' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="margin-left: 15px;"><b>Email:</b></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="email" value="<?php echo $row_select_user['email'] ?>" name="email" placeholder="Nhập Email">
                                            <div style="color: red">
                                                <span><?php echo(isset($err['email']))?$err['email']:'' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="margin-left: 15px;"><b>Số điện thoại:</b></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="phone" name="phone" value="<?php echo $row_select_user['mobile'] ?>" placeholder="Nhập số điện thoại">
                                            <div style="color: red">
                                                <span><?php echo(isset($err['phone']))?$err['phone']:'' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="margin-left: 15px; margin-bottom: 15px;"><b>Địa chỉ:</b></label>
                                        <div class="col-sm-6">
                                            <textarea class="resizable_textarea form-control" id="address" name="address" ></textarea>
                                            <div style="color: red">
                                                <span><?php echo(isset($err['address']))?$err['address']:'' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" style="margin-left: 15px; margin-bottom: 15px;"><b>Phương thức thanh toán:</b></label>
                                        <div class="col-sm-6">
                                            <select name="method_payment" class="form-select">
                                                <option value="nhanhang">Thanh toán khi nhận hàng</option>
                                                <option value="vnpay">Thanh toán bằng ví VNPay</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-12" style="text-align: center; margin-bottom: 15px;">
                                    <button class="btn btn-danger btn-lg btn-block" type="submit"><a style="color: white; text-decoration: none;" href="index.php">Trở về trang chủ</a></button>
                                    <button class="btn btn-success btn-lg btn-block" type="submit" name="redirect">Đặt hàng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Đơn hàng của bạn</span>
                            <span class="badge badge-secondary badge-pill">3</span>
                        </h4>

                        <ul class="list-group mb-3 z-depth-1">
                            <?php
                                if(isset($_SESSION["cart"])) {
                                    $subtotal = 0;
                                    $ordertotal = 0;
                                    $ship = 35000;
                                    foreach($_SESSION["cart"] as $key=>$value) {
                                        $subtotal += $value["price"] * $value["quanlity"];
                                        $ordertotal = $ship + $subtotal;
                                    }
                                }

                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Tổng tiền sản phẩm</h6>
                                </div>
                                <span class="text-muted"><?php echo number_format($subtotal,0,",",".") ?> vnđ</span>
                            </li>
                            <?php
                                foreach($_SESSION["cart"] as $key=>$value) {
                            ?>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <p><?php echo $value["name"] ?> x <?php echo $value["quanlity"]; ?></p>
                                    </div>
                                    <span class="text-muted"><?php echo number_format($value["price"] * $value["quanlity"],0,",",".") ?> vnđ</span>
                                </li>
                            <?php } ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Phí vận chuyển</h6>
                                </div>
                                <span class="text-muted"><?php echo number_format($ship,0,",",".") ?> vnđ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><h5 class="my-0">Tổng thanh toán</h5></span>
                                <strong><?php echo number_format($ordertotal,0,",",".") ?> vnđ</strong>
                            </li>
                        </ul>

                        <form class="card p-2">
                            <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập mã khuyến mãi" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-secondary btn-md waves-effect m-0" type="button">Chọn</button>
                            </div>
                            </div>
                        </form>

                        <script type="text/javascript">
                            $.validator.setDefaults({
                                submitHandler: function () { alert("submitted!"); }
                            });
                            $(document).ready(function() {
                                $("#signupForm").validate({
                                    rules: {
                                        full_name: "required",
                                        email: { required: true, email: true},
                                        phone: "required",
                                        address: "required",
                                        payment: "required"
                                    },
                                    messages: {
                                        full_name: "Bạn chưa nhập vào họ tên của bạn",
                                        email: "Hộp thư điện tử không hợp lệ",
                                        phone: "Bạn chưa nhập số điện thoại",
                                        address: "Bạn chưa nhập địa chỉ",
                                        payment: "Bạn chưa chọn phương thức thanh toán"
                                    },
                                    errorElement: "div",
                                    errorPlacement: function (error, element) {
                                        error.addClass("invalid-feedback");
                                        if(element.prop("type") === "checkbox") {
                                            error.insertAfter(element.siblings("label"));
                                        } else {
                                            error.insertAfter(element);
                                        }
                                    },
                                    highlight: function (element, errorClass, validClass) {
                                        $(element).addClass( "is-invalid" ).removeClass("is-valid");
                                    },
                                    unhighlight: function (element, errorClass,validClass) {
                                        $(element).addClass( "is-valid" ).removeClass("is-invalid");
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
            </form>
    </div>
</main>
  <!--Main layout-->