<?php include "../../header.php"; ?>

    <!-- App Capsule -->
    <link rel="stylesheet" href="../css/style.css">
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="<?= isset($_GET['detail']) ? "transaction-detail.php?ID=". $_GET['ID'] : "transaction.php" ?>" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Batalkan transaksi</div>
            <div class="right"></div>
        </div>

        <?php
            $id = $_GET['ID'];
            $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE ID = '$id'");
            $data = mysqli_fetch_assoc($transactions);

            if($data['Status'] == "Menunggu konfirmasi pembayaran"){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Menunggu konfirmasi mitra"){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Transaksi ditolak"){ $statusColor = "rgb(243, 51, 51);"; }
            else if($data['Status'] == "Transaksi dibatalkan oleh customer"){ $statusColor = "rgb(243, 51, 51);"; }
            else if($data['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru"){ $statusColor = "rgb(223, 171, 0);"; }
            else if($data['Status'] == "Selesai"){ $statusColor = "rgb(0, 119, 255);"; }
            else if($data['Status'] == "Mitra sedang dalam perjalanan menuju lokasi"){ $statusColor = "rgba(0, 0, 0, 0.7);"; }
        ?>
        <div class="wide-block pt-2 pb-2">
            <span class="developer-original-transactions detail">
                <img src="<?= $data['ProductImage'] ?>">
                <div description>
                    <span title><?= $data['ProductName'] ?></span>
                    <span date><?= $data['CustomerOrderTimestamp'] ?></span>
                    <span pricetitle>Harga</span>
                    <span price><?= $data['ProductPrice'] ?></span>
                    <span addresstitle>Lokasi</span>
                    <span address><?= $data['CustomerProvince'] . ", " . $data['CustomerDistrict'] . ", " . $data['CustomerSubdistrict'] . ", " . $data['CustomerAddress'] ?></span>
                    <span statustitle>Status</span>
                    <span style="color:<?= $statusColor ?>;" status><?= $data['Status'] ?></span>
                </div>
            </span>
        </div>

        <div class="wide-block pt-2 pb-2">
            <form class="needs-validation" action="transaction-cancel-action.php" method="post" novalidate>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="StatusCanceledReason">Alasan secara spesifik*</label>
                        <textarea class="form-control" id="StatusCanceledReason" name="StatusCanceledReason" placeholder="Tuliskan alasan kamu membatalkan transaksi ini di sini" style="font-size: 13px;"></textarea>
                        <div class="developer-original-input-warning hidden">Mohon untuk mengisi alasan dengan minimal 20 karakter</div>
                        <input type="hidden" name="ID" value="<?= $id ?>">
                    </div>
                </div>

                <div class="mt-2">
                    <button class='btn btn-block btn-danger' id="SubmitButton">Batalkan transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const submitButton = document.getElementById("SubmitButton");
        const statusCanceledReason = document.getElementById("StatusCanceledReason");

        submitButton.addEventListener("click", (e)=>{
            if(statusCanceledReason.value.length < 20)
            {
                e.preventDefault();
                statusCanceledReason.nextElementSibling.classList.remove("hidden");

                setTimeout(()=>{statusCanceledReason.nextElementSibling.classList.add("hidden")},3000), { once : true};
            }
        });

        statusCanceledReason.addEventListener("input", ()=>{
            if(statusCanceledReason.value.length >= 20)
            {
                statusCanceledReason.nextElementSibling.classList.add("hidden");
            }
        });
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