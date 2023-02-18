<?php
    ob_start();
    session_start();
    if(isset($_SESSION["login"])) {
        header("location:index.php");
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    include ("../connection.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Panacea</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
        <section class="login_content">
            <form method="post">
                <?php
                    if(isset($_POST["login"])) {
                        $user_name = trim($_POST["user_name"]);
                        $password = md5(trim($_POST["password"]));
                        $sqlLogin = "SELECT * FROM tbl_admin WHERE user_name='$user_name' and `password`='$password'";
                        // echo $sqlLogin;
                        // die();
                        $result = $conn->query($sqlLogin);
                        if($result->rowCount()>0) {
                            //Tạo session
                            $rowlogin = $result->fetch(PDO::FETCH_NUM);
                            $_SESSION["admin_login"] = $rowlogin;
                            header("location:index.php");
                        } else {
                            header("location:login.php");
                        }
                    }
                ?>
                <h1 style="color: #59ab6e !important;">Đăng Nhập</h1>
                <div>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Tên tài khoản" required="" />
                </div>
                <div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required="" />
                </div>
                <div>
                    <button type="submit" class="btn btn-success" name="login">Đăng Nhập</button>
                    <a class="reset_pass" href="#">Quên mật khẩu?</a>
                </div>

                <div class="clearfix"></div>

                <div class="separator">

                    <div class="clearfix"></div>
                    <br />

                    <div>
                    <h1 style="color: #59ab6e !important;"><i class="fa fa-product-hunt" style="color: #59ab6e !important;"></i> Panacea</h1>
                    <p>©2022 Panacea</p>
                    </div>
                </div>
            </form>
        </section>
        </div>
    </div>
    </div>
</body>
</html>
