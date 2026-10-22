<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="#">
                    <img src="../../../images/icon/logo.png" alt="CoolAdmin" />
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li>
                    <a href="../../dashboard/php/index.php">
                        <i class="fas fa-book"></i>Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#" style="font-size: 20px; font-weight: bold; color: black;">
            Alinda Home Service
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list" id="sidebarMenu">
            <!--<li class="active has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="index.html">Dashboard 1</a>
                        </li>
                    </ul>
                </li> -->
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-book"></i>Admin
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="../../admin-dashboard/php/index.php">Dashboard</a>
                        </li>
                        <li>
                            <a href="../../admin/php/index.php">Account List</a>
                        </li>
                        <li>
                            <a href="../../admin-account-number/php/index.php">Account Number</a>
                        </li>
                        <li>
                            <a href="../../admin-center-address/php/index.php">Center Address</a>
                        </li>
                        <li>
                            <a href="../../admin-customer-service/php/index.php">Customer Service</a>
                        </li>
                        <li>
                            <a href="../../admin-bug-and-suggestion/php/index.php?page=1&sort=Timestamp&by=DESC">Bug and Suggestion</a>
                        </li>
                        <li>
                            <a href="../../admin-advertising/php/index.php">Advertising</a>
                        </li>
                        <li>
                            <a href="../../admin-partner-tutorial/php/index.php">Partner Tutorial</a>
                        </li>
                        <li>
                            <a href="../../admin-customer-information/php/index.php">Customer Information</a>
                        </li>
                    </ul>
                </li>
                
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-book"></i>Partner
                        <?php if($notificationPartnerApproval == true){ ?>
                            <span class="developer-original-notification"><?= $notificationPartnerApprovalValue ?></span>
                        <?php } ?>
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="../../partner-list/php/index.php">Partner List</a>
                        </li>
                        <li>
                            <a href="../../partner-approval/php/index.php">
                                Partner Approval
                                <?php if($notificationPartnerApproval == true){ ?>
                                    <span class="developer-original-notification-child"><?= $notificationPartnerApprovalValue ?></span>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub">
                    <a class="js-arrow" href="../../customer-list/php/index.php">
                        <i class="fas fa-book"></i>Customer List
                    </a>
                </li>

                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-book"></i>
                        Transaction
                        <?php if($notificationTransactionValue > 0){ ?>
                            <span class="developer-original-notification"><?= $notificationTransactionValue ?></span>
                        <?php } ?>
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="../../transaction-list/php/index.php">Transaction List</a>
                        </li>
                        <li>
                            <a href="../../transaction-approval/php/index.php">
                                Transaction Approval
                                <?php if($notificationTransactionApproval == true){ ?>
                                    <span class="developer-original-notification-child"><?= $notificationTransactionApprovalValue ?></span>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../transaction-need-partner/php/index.php">
                                Transaction Need Partner
                                <?php if($notificationTransactionNeedPartner == true){ ?>
                                    <span class="developer-original-notification-child" style = "transform:translateY(-10px);"><?= $notificationTransactionNeedPartnerValue ?></span>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="../../transaction-partner-payment/php/index.php">
                                Transaction Partner Payment
                                <?php if($notificationTransactionPartnerPayment == true){ ?>
                                    <span class="developer-original-notification-child" style = "transform:translateY(-10px);"><?= $notificationTransactionPartnerPaymentValue ?></span>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub">
                    <a class="js-arrow" href="../../product-list/php/index.php">
                        <i class="fas fa-book"></i>Product List
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>