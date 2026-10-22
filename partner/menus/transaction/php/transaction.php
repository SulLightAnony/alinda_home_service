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
        <a href="../../customer-service/php/customer-service.php?link=<?= $_SERVER['REQUEST_URI'] ?>"><img src="../media/image/Headset.png" style="position:absolute; right:20px; top:13px; width: 30px;"></a>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        
        <div class="header-large-title">
            <!-- <h4 class="title">Wellcome</h4>
            <h4 class="subtitle">Welcome to Alinda</h4> -->
        </div>

        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <span>
                    <b>Informasi :</b>
                    <br>
                    - Harap untuk refresh halaman secara berkala untuk mengetahui jika ada perubahan status pada transaksi
                    <br>
                    - Halaman ini akan otomatis refresh setiap 2 menit
                    <br>
                    - Pesanan yang sudah selesai sempurna akan masuk ke halaman riwayat pesanan
                    <br>
                    - Pesanan akan otomatis hangus apabila belum diterima oleh mitra setelah 5 menit
                    <br>
                    - Halaman ini akan menampilkan pesanan yang diterima, sedang berjalan, dan status pembayaran belum dibayar
                </span>
            </div>
        </div>


        <div class="section full mt-2" id="TransactionPlace">
            <?php
                $statusColor = "black";
                $partnerEmail = $_SESSION['EmailPartner'];

                $transactions = mysqli_query($conn, "
                    SELECT * FROM tbl_transaction 
                    WHERE PartnerEmail = '$partnerEmail'
                    AND StatusPayment = 'Belum dibayar'
                    AND (
                        (
                            ProductName != 'Suruh Apa Saja' 
                            AND Status IN ('Menunggu konfirmasi mitra', 'Berjalan', 'Selesai', 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru')
                        )
                        OR (
                            ProductName = 'Suruh Apa Saja' 
                            AND Status IN ('Menunggu konfirmasi pembayaran', 'Berjalan', 'Selesai', 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru')
                        )
                    )
                    ORDER BY CustomerOrderTimestamp DESC
                ");

                while($row = mysqli_fetch_assoc($transactions)){
                ?>

            <div class="wide-block pt-2 pb-2">
                <span class="developer-original-transactions">
                    <img src="<?= $row['ProductImage'] ?>">
                    <div description>
                        <span title>Nama Pemesan</span>
                        <span address><?= $row['CustomerUsername'] ?></span>
                        <span title><?= $row['ProductName'] ?></span>
                        <span date><?= $row['CustomerOrderTimestamp'] ?></span>
                        <span addresstitle>Detail / catatan</span>
                        <span address><?= $row['ProductDetail']?></span>
                        <span pricetitle>Harga</span>
                        <span price><?= $row['PartnerPrice'] ?></span>
                        <span addresstitle>Lokasi</span>
                        <span address><?= $row['CustomerProvince'] . ", " . $row['CustomerDistrict'] . ", " . $row['CustomerSubdistrict'] . ", " . $row['CustomerAddress'] ?></span>
                        <span statustitle>Status</span>
                        <span style="color:rgba(0,0,0,0.7);" status><?= $row['Status'] ?></span>
                        <?php if($row['Status'] == 'Selesai'){ ?>
                            <span statustitle>Status Pembayaran</span>
                            <span style="color:<?= $row['StatusPayment'] == 'Belum dibayar' ? 'rgb(237, 43, 43)' : 'rgb(0, 119, 255)' ?>; font-weight:bold;" detail><?= $row['StatusPayment'] ?></span>
                        <?php } ?>
                    </div>
                </span>
                
                <span>
                    <a href="../../transaction/php/transaction-detail.php?ID=<?= $row['ID'] ?>"><button class='btn btn-block btn-primary'>Lihat detail</button></a>
                </span>
            </div>
            <?php } ?>
        </div>
    </div>

    <button class="developer-original-refresh">&#8635;</button>
    <script>
        document.querySelector(".developer-original-refresh").addEventListener("click", ()=>{
            document.querySelector(".developer-original-refresh").classList.add("rotated");
            setTimeout(()=>window.location.reload(),300);
        });

        document.addEventListener("DOMContentLoaded", ()=>setTimeout(()=>window.location.reload(),120000));
    </script>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>