<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['AddressPartner']) && $_SESSION['AddressPartner'] != "-") &&
        (isset($_SESSION['ProvincePartner']) && $_SESSION['ProvincePartner'] != "-") &&
        (isset($_SESSION['DistrictPartner']) && $_SESSION['DistrictPartner'] != "-") &&
        (isset($_SESSION['SubdistrictPartner']) && $_SESSION['SubdistrictPartner'] != "-") &&
        (isset($_SESSION['SkillStatusPartner']) && $_SESSION['SkillStatusPartner'] == "Existed")){
?>

    <!-- App Capsule -->
    <link rel="stylesheet" href="../css/style.css">
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <?php
                    $menu = "home";
                    if (strpos($_GET['link'], "menus/home/php") !== false) { $menu = "home";}
                    else if (strpos($_GET['link'], "menus/transaction/php") !== false) { $menu = "transaction";}
                    else if (strpos($_GET['link'], "menus/history/php") !== false) { $menu = "history";}
                    else if (strpos($_GET['link'], "menus/profile/php") !== false) { $menu = "profile";}
                ?>
                <a href="../../<?= $menu ?>/php/<?= $menu ?>.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Chat Customer Service</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2">
            <?php
                $customerServices = mysqli_query($conn, "SELECT * FROM tbl_admin_customer_service");
                while($row = mysqli_fetch_assoc($customerServices)){
            ?>
            <div class="wide-block pt-2 pb-2">
                <a href="https://wa.me/<?= $row['PhoneNumber'] ?>" target="_blank">
                    <span class="developer-original-transactions">
                        <img src="<?= $row['Image'] ?>">
                        <div description>
                            <span title><?= $row['Name'] ?></span>
                            <span address><?= $row['PhoneNumber'] ?></span>
                        </div>
                    </span>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="../../../assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="../../../assets/js/lib/popper.min.js"></script>
    <script src="../../../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="../../../assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="../../../assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <!-- Base Js File -->
    <script src="../../../assets/js/base.js"></script>
<?php
    }
    else { header("location: ../../home/php/home.php"); }
?>