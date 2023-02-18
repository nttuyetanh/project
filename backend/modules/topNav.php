    <!-- top navigation -->
    <div class="top_nav">
        <div class="nav_menu">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/user.png" alt="">
                    <?php
                        if(isset($_SESSION["login"])) {
                            echo $_SESSION["login"][1];
                        }
                    ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="index.php?page=logout"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a>
                </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                    <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green"></span>
                </li>
            </ul>
            </nav>
        </div>
    </div>
    <!-- /top navigation -->