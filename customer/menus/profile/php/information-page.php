<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>

    <!-- App Capsule -->
    <link rel="stylesheet" href="../css/style.css">
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="profile.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Informasi</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2">
            <?php
                $customerServices = mysqli_query($conn, "SELECT * FROM tbl_admin_customer_information");
                while($row = mysqli_fetch_assoc($customerServices)){
            ?>
            <div class="wide-block pt-2 pb-2">
                <iframe width="100%" height="220" src="<?= $row['EmbedLink'] ?>" loading="lazy" allowfullscreen></iframe>
                <a href="<?= $row['Link'] ?>" target="_blank" style="font-size: 17px; font-weight:bold; color:rgba(0,0,0,0.7);"><?= $row['Title'] ?><br><br></a>
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