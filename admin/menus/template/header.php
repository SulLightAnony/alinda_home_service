<?php date_default_timezone_set('Asia/Jakarta'); ?>

<!-- HEADER DESKTOP-->
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <div></div>

                <div class="header-button">
                    <div style="position: absolute; left:20px;">
                        <?= isset($_GET['TransactionProduct']) ? "Produk : " . $_GET['TransactionProduct'] : "" ?>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="../../../images/icon/avatar-01.jpg">
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#"><?= $_SESSION['Username'] ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="account-dropdown__footer">
                                    <a href="../../Logout.php">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<abbr title="Waktu mundur hingga refresh otomatis"><div style="position: fixed; bottom: 0px; right: 0px; width: 200px; height: 30px; background:white; display:flex; justify-content: center; align-items:center; font-size:13px; border:2px solid rgb(0, 162, 236); border-top-left-radius:7px; z-index:1000;" id="Countdown">Auto Refresh : 05:00</span></div></abbr>
<!-- HEADER DESKTOP-->