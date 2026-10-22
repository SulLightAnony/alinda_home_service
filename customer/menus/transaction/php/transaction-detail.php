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

            if($data['Status'] == "Menunggu konfirmasi pembayaran"){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Menunggu konfirmasi mitra"){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Menunggu konfirmasi mitra."){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Transaksi ditolak"){ $statusColor = "rgb(243, 51, 51);"; }
            else if($data['Status'] == "Transaksi dibatalkan oleh customer"){ $statusColor = "rgb(243, 51, 51);"; }
            else if($data['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru"){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru."){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Selesai"){ $statusColor = "rgb(0, 119, 255);"; }
            else if($data['Status'] == "Berjalan"){ $statusColor = "rgba(0, 0, 0, 0.7);"; }
            else if($data['Status'] == "Transaksi gagal"){ $statusColor = "rgb(243, 51, 51);"; }
        ?>
        <div class="wide-block pt-2 pb-2">
            <span class="developer-original-transactions detail">
                <img src="<?= $data['ProductImage'] ?>">
                <div description>
                    <span detailtitle>Judul transaksi</span>
                    <span detail><?= $data['ProductName'] ?></span>

                    <span detailtitle>Kode transaksi</span>
                    <span detail><?= $data['Code'] ?></span>

                    <span detailtitle>Bukti pembayaran</span>
                    <button class="btn btn-primary" id="ShowCustomerImageProveButton">Lihat foto</button>

                    <span detailtitle>Tanggal transaksi</span>
                    <span detail><?= $data['CustomerOrderTimestamp'] ?></span>

                    <span detailtitle>Harga</span>
                    <span detail><?= $data['ProductPrice'] ?></span>

                    <span detailtitle>Lokasi</span>
                    <span detail><?= $data['CustomerProvince'] . ", " . $data['CustomerDistrict'] . ", " . $data['CustomerSubdistrict'] . ", " . $data['CustomerAddress'] ?></span>

                    <span detailtitle>Detail / catatan</span>
                    <span detail><?= $data['ProductDetail'] ?></span>

                    <span detailtitle>Status</span>
                    <span style="color:<?= $statusColor ?>;" detail><?= $data['Status'] ?></span>

                    <span detailtitle>Tanggal transaksi</span>
                    <span detail><?= $data['CustomerOrderTimestamp'] ?></span>

                    <?php if($data['Status'] == 'Transaksi ditolak' || $data['Status'] == 'Transaksi gagal'){ ?>
                        <span detailtitle>Alasan transaksi <?= $data['Status'] == 'Transaksi ditolak' ? 'ditolak' : 'gagal' ?></span>
                        <span detail><?= $data['StatusRejectedReason'] ?></span>
                    <?php } ?>

                    <?php if($data['Status'] == 'Transaksi dibatalkan'){ ?>
                        <span detailtitle>Pelaku transaksi dibatalkan</span>
                        <span detail><?= $data['StatusCanceledFrom'] ?></span>

                        <span detailtitle>Alasan transaksi dibatalkan</span>
                        <span detail><?= $data['StatusCanceledReason'] ?></span>

                        <span detailtitle>Waktu transaksi dibatalkan</span>
                        <span detail><?= $data['StatusCanceledTimestamp'] ?></span>
                    <?php } ?>

                    <?php if(($data['Status'] == 'Berjalan' || $data['Status'] == 'Selesai') || (($data['Status'] == 'Transaksi dibatalkan' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.') && $data['StatusCanceledFrom'] == 'Mitra')){ ?>
                        <?php if($data['Status'] == 'Transaksi dibatalkan' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.'){ ?>
                            <br> <span detailtitle>( Kerincian mitra yang membatalkan )</span>
                        <?php } ?>

                        <span detailtitle>Nama Mitra</span>
                        <span detail><?= $data['PartnerUsername'] ?></span>

                        <span detailtitle>Alamat Mitra</span>
                        <span detail><?= $data['PartnerProvince'] . ", " . $data['PartnerDistrict'] . ", " . $data['PartnerSubdistrict'] . ", " . $data['PartnerAddress'] ?></span>

                        <span detailtitle>Foto Mitra</span>
                        <button class="btn btn-primary" id="ShowImagePartnerButton">Lihat foto</button>

                        <?php if($data['Status'] == 'Berjalan' || $data['Status'] == 'Selesai'){ ?>
                            <span detailtitle>Pesanan diterima Mitra</span>
                            <span detail><?= $data['PartnerAgreedTimestamp'] ?></span>
                        <?php } ?>
                            
                        <?php
                            if($data['Status'] == 'Transaksi dibatalkan' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.'){
                                $partnerCanceledReason = $data['PartnerCanceledReason'];
                                if (str_contains($data['PartnerCanceledReason'], "|") != false) {
                                    $partnerCanceledReason = explode("|", $data['PartnerCanceledReason']);
                                    $partnerCanceledReason = array_pop($partnerCanceledReason);
                                }

                                $partnerCanceledTimestamp = $data['PartnerCanceledTimestamp'];
                                if (str_contains($data['PartnerCanceledTimestamp'], "|")) {
                                    $partnerCanceledTimestamp = explode("|", $data['PartnerCanceledTimestamp']);
                                    $partnerCanceledTimestamp = array_pop($partnerCanceledTimestamp);
                                }
                        ?>
                            <span detailtitle>Alasan dibatalkan Mitra</span>
                            <span detail><?= $partnerCanceledReason ?></span>

                            <span detailtitle>Pesanan dibatalkan Mitra</span>
                            <span detail><?= $partnerCanceledTimestamp ?></span>
                        <?php } ?>

                        <?php if($data['Status'] == 'Selesai'){ ?>
                            <span detailtitle>Pesanan diakhiri Mitra</span>
                            <span detail><?= $data['PartnerFinishedTimestamp'] ?></span>
                        <?php } ?>
                    <?php } ?>
                </div>
            </span>
        </div>

        <?php if($data['Status'] == 'Berjalan'){ ?>
            <div class="wide-block pt-2 pb-2">
                <a href="transaction-chat-room.php?id=<?= $data['ID'] ?>&chatroom=<?= $data['Code'] ?>" class='btn btn-block btn-primary'>Chat dengan Mitra</a>
            </div>
        <?php } ?>

        <?php if($data['Status'] == 'Berjalan' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru'){ ?>
            <div class="wide-block pt-2 pb-2">
                <a href="transaction-cancel.php?ID=<?= $_GET['ID'] ?>&detail" class='btn btn-block btn-danger'>Batalkan transaksi</a>
            </div>
        <?php } ?>

        <?php if($data['Status'] == 'Menunggu konfirmasi pembayaran' && $data['CustomerImageProve'] == ""){ ?>
            <div class="wide-block pt-2 pb-2">
                <a href="transaction-ask-anything-pay.php?id=<?= $data['ID'] ?>" class='btn btn-block btn-primary'>Bayar sekarang</a>
            </div>
        <?php } else if($data['Status'] == 'Menunggu konfirmasi pembayaran' && $data['CustomerImageProve'] != ""){ ?>
            <div class="wide-block pt-2 pb-2">
                <a href="#" class='btn btn-block btn-primary' style="height:70px; font-size: 14px;">Kamu sudah mengirim bukti pembayaran. Menunggu konfirmasi pembayaran dari Admin</a>
            </div>
        <?php } ?>
    </div>

    <div class="developer-original-blackbarrier hidden"></div>

    <?php if(($data['Status'] == 'Berjalan' || $data['Status'] == 'Selesai') || (($data['Status'] == 'Transaksi dibatalkan' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru' || $data['Status'] == 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru.') && $data['StatusCanceledFrom'] == 'Mitra')){ ?>
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

        showCustomerImageProveButton.addEventListener("click", ()=>{
            modalImage02.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        });

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