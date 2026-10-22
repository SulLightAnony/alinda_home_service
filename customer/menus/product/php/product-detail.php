<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
           
        $id = $_GET['ID'];
        $product = mysqli_query($conn, "SELECT * FROM tbl_admin_product WHERE ID = '$id'");
        $data = mysqli_fetch_assoc($product);
?>

    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="product-category.php?ID=<?= $_GET['ID'] ?>&search=<?= $_GET['search'] ?>&back" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Detail
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="header-large-title">
            <!-- <h4 class="title">Wellcome</h4>
            <h4 class="subtitle">Welcome to Alinda</h4> -->
        </div>

        <div class="item">
            <img src="<?= $data['Background'] ?>" alt="alt" class="imaged w-100 square">
        </div>

        <!-- * carousel -->
        <div class="section full">
            <div class="wide-block pt-2 pb-2 product-detail-header">
                <h1 class="title"><?= $data['Name'] ?></h1>
                <div class="detail-footer">
                    <!-- price -->
                    <div class="price">
                        <div class="current-price"><?= $data['Price'] ?></div>
                    </div>
                    <!-- * price -->
                </div>
            </div>
        </div>

        <div class="section full mt-2">
            <div class="section-title">Deskripsi</div>
            <div class="wide-block pt-2 pb-2"><?= $data['Description'] ?></div>
        </div>

        <!-- Review -->
        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <button class="btn btn-primary btn-block" id="OrderButton">Pesan jasa</button>
            </div>
        </div>
    </div>

    <div class="developer-original-blackbarrier hidden" id="Blackbarrier-02"></div>

    <div class="developer-original-modal-delete hidden" id="OrderConfirm">
        <p>Konfirmasi pesan jasa?</p>
        <div>
            <button class="negative">Tidak</button>
            <a href="product-order.php<?= "?ID=" . $_GET['ID'] . "&search=" . $_GET['search'] ?>"><button class="positive">Iya</button></a>
        </div>
    </div>

    <script>
        const orderButton = document.getElementById("OrderButton");
        const orderConfirm = document.getElementById("OrderConfirm");
        const blackbarrier02 = document.getElementById("Blackbarrier-02");

        orderButton.addEventListener("click", ()=>{
            orderConfirm.classList.remove("hidden");
            blackbarrier02.classList.remove("hidden");
        });

        blackbarrier02.addEventListener("click", ()=>{
            orderConfirm.classList.add("hidden");
            blackbarrier02.classList.add("hidden");
        });

        orderConfirm.children[1].children[0].addEventListener("click", ()=>{
            orderConfirm.classList.add("hidden");
            blackbarrier02.classList.add("hidden");
        });
    </script>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>