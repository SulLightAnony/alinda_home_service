<?php include "../../header.php"; ?>

    <!-- App Capsule -->
    <link rel="stylesheet" href="../css/style.css">
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="transaction.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Detail transaksi</div>
            <div class="right"></div>
        </div>

        <?php
            $statuscolor = 'black';
            $id = $_GET['ID'];
            $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE ID = '$id'");
            $data = mysqli_fetch_assoc($transactions);
            
            $googleMap = mysqli_fetch_assoc(mysqli_query($conn, "SELECT GoogleMap FROM tbl_customers WHERE Email = '" . $data['CustomerEmail'] . "'"))['GoogleMap'];
        ?>
        <div class="wide-block pt-2 pb-2">
            <span class="developer-original-transactions detail">
                <img src="<?= $data['ProductImage'] ?>">
                <div description>
                    <span detailtitle>Judul transaksi</span>
                    <span title><?= $data['ProductName'] ?></span>

                    <span detailtitle>Kode transaksi</span>
                    <span detail><?= $data['Code'] ?></span>

                    <span detailtitle>Tanggal transaksi</span>
                    <span detail><?= $data['CustomerOrderTimestamp'] ?></span>

                    <span detailtitle>Harga Mitra</span>
                    <span detail><?= $data['PartnerPrice'] == "" ? "Rp0" : $data['PartnerPrice'] ?></span>

                    <span detailtitle>Nama pemesan</span>
                    <span detail><?= $data['CustomerUsername'] ?></span>
    
                    <span detailtitle>Lokasi</span>
                    <span detail><?= $data['CustomerProvince'] . ", " . $data['CustomerDistrict'] . ", " . $data['CustomerSubdistrict'] . ", " . $data['CustomerAddress'] ?></span>
                    <span detail><a href="<?= $googleMap != "" ? $googleMap : "https://www.google.com/maps/search/" . urlencode($data['CustomerProvince']) . "+" . urlencode($data['CustomerDistrict']) . "+" . urlencode($data['CustomerSubdistrict']) . "+" . urlencode($data['CustomerAddress']) ?>" target="_blank">Google Map >></a></span>

                    <span detailtitle>Detail / catatan</span>
                    <span detail><?= $data['ProductDetail'] ?></span>

                    <span detailtitle>Status</span>
                    <span style="color:rgba(0,0,0,0.7);" detail><?= $data['Status'] ?></span>
                    
                    <span detailtitle>Tanggal transaksi</span>
                    <span detail><?= $data['CustomerOrderTimestamp'] ?></span>

                    <?php if($data['Status'] == 'Selesai'){ ?>
                        <span detailtitle>Status Pembayaran</span>
                        <span style="color:<?= $data['StatusPayment'] == 'Belum dibayar' ? 'rgb(237, 43, 43)' : 'rgb(0, 119, 255)' ?>; font-weight:bold;" detail><?= $data['StatusPayment'] ?></span>

                        <span detailtitle>Informasi</span>
                        <span detail>Kamu perlu menunggu beberapa saat hingga Admin mengkonfirmasi penyelesaian pesanan dan membayarmu</span>
                    <?php } ?>
                </div>
            </span>
        </div>

        <?php if($data['Status'] == 'Berjalan'){ ?>
            <div class="wide-block pt-2 pb-2">
                <a href="transaction-chat-room.php?id=<?= $data['ID'] ?>&chatroom=<?= $data['Code'] ?>" class='btn btn-block btn-primary'>Chat dengan Customer</a>
            </div>
        <?php } ?>

        <div class="wide-block pt-2 pb-2">
            <?php if($data['Status'] == "Menunggu konfirmasi mitra"){ ?>
                <a href="transaction-reject.php?ID=<?= $_GET['ID'] ?>&detail" class='btn btn-block btn-danger'>TOLAK pesanan ðŸ‘Ž</a>
                <a href="transaction-accept.php?ID=<?= $_GET['ID'] ?>" class='btn btn-block btn-primary'>Terima pesanan ðŸ‘Œ</a>
            <?php } else if($data['Status'] == 'Berjalan'){ ?>
                <a href="transaction-cancel.php?ID=<?= $_GET['ID'] ?>&detail" class='btn btn-block btn-danger'>BATALKAN pesanan</a>
                <a href="transaction-finish.php?ID=<?= $_GET['ID'] ?>&detail" class='btn btn-block btn-primary'>Akhiri pesanan</a>
            <?php } else if($data['Status'] == 'Selesai'){ ?>
                <a href="../../customer-service/php/customer-service.php?link=<?= $_SERVER['REQUEST_URI'] ?>" class='btn btn-block btn-primary'>Hubungi Customer Service</a>
           <?php } else if($data['Status'] == 'Menunggu konfirmasi pembayaran'){ ?>
                <a href="transaction-cancel.php?ID=<?= $_GET['ID'] ?>&detail" class='btn btn-block btn-danger'>BATALKAN pesanan</a>
            <?php } ?>
        </div>
    </div>

    <div class="developer-original-blackbarrier hidden"></div>

    <?php if(($data['Status'] == 'Mitra sedang dalam perjalanan menuju lokasi' || $data['Status'] == 'Selesai') || (($data['Status'] == 'Transaksi dibatalkan' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.') && $data['StatusCanceledFrom'] == 'Mitra')){ ?>
        <div class="developer-original-modal-image-01 hidden" 01>
            <img src="<?= $data['PartnerImage'] ?>">
        </div>
    <?php } ?>
    
    <div class="developer-original-modal-image-02 hidden" 02>
        <img src="<?= $data['CustomerImageProve'] ?>">
    </div>

    <script>
        const showImagePartnerButton = document.getElementById("ShowImagePartnerButton");
        const showCustomerImageProveButton = document.getElementById("ShowCustomerImageProveButton");
        const modalImage01 = document.querySelector(".developer-original-modal-image-01");
        const modalImage02 = document.querySelector(".developer-original-modal-image-02");
        const blackbarrier = document.querySelector(".developer-original-blackbarrier");

        if(showImagePartnerButton){
            showImagePartnerButton.addEventListener("click", ()=>{
                modalImage01.classList.remove("hidden");
                blackbarrier.classList.remove("hidden");
            });
        }

        blackbarrier.addEventListener("click", ()=>{
            if(modalImage01){ modalImage01.classList.add("hidden"); }
            modalImage02.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        });

        document.addEventListener("DOMContentLoaded", ()=>setTimeout(()=>window.location.reload(),300000));
    </script>

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
</body>
</html>