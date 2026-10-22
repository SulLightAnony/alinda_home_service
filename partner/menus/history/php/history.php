 <?php 
    include '../../header.php';
    
    if( (isset($_SESSION['AddressPartner']) && $_SESSION['AddressPartner'] != "-") &&
        (isset($_SESSION['ProvincePartner']) && $_SESSION['ProvincePartner'] != "-") &&
        (isset($_SESSION['DistrictPartner']) && $_SESSION['DistrictPartner'] != "-") &&
        (isset($_SESSION['SubdistrictPartner']) && $_SESSION['SubdistrictPartner'] != "-") &&
        (isset($_SESSION['SkillStatusPartner']) && $_SESSION['SkillStatusPartner'] == "Existed")){
?>

    <!-- TODO: Membuat detail transaksi berjalan, batalkan transaksi berjalan, selesaikan transaksi -->

    <link rel="stylesheet" href="../css/style.css">
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Transaksi
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-2">
            <?php
                $statusColor = "black";
                $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE PartnerEmail = '" . $_SESSION['EmailPartner'] . "' AND Status = 'Selesai' AND StatusPayment = 'Sudah dibayar' ORDER BY CustomerOrderTimestamp DESC LIMIT 10");
                // $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction ORDER BY CustomerOrderTimestamp DESC LIMIT 100");
                while($row = mysqli_fetch_assoc($transactions)){
            ?>
            <div class="wide-block pt-2 pb-2 developer-original-transaction-data" id="DataID-<?= $row['ID'] ?>">
                <span class="developer-original-transactions">
                    <div description>
                        <span title>Nama Pemesan</span>
                        <span address><?= $row['CustomerUsername'] ?></span>
                        <span title><?= $row['ProductName'] ?></span>
                        <span date><?= $row['CustomerOrderTimestamp'] ?></span>
                        <span addresstitle>Lokasi</span>
                        <span address><?= $row['CustomerProvince'] . ", " . $row['CustomerDistrict'] . ", " . $row['CustomerSubdistrict'] . ", " . $row['CustomerAddress'] ?></span>
                        <a href="history-detail.php?ID=<?= $row['ID'] ?>" style="rgb(0, 119, 255); font-size:12px;">Detail pesanan &raquo;</a>
                    </div>
                </span>
            </div>
            <?php } ?>
        </div>
    </div>

    <button class="developer-original-refresh">&uarr;</button>
    <script>
        document.querySelectorAll(".developer-original-transaction-data").forEach((e)=>{
            if(e.getAttribute("id") == window.location.hash.slice(1))
            {
                e.style.background='rgba(71,200,242,0.3)';

                setTimeout(()=>{
                    e.style.background='white';
                }, 100);
            }
        });

        document.querySelector(".developer-original-refresh").addEventListener("click", ()=>{
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>