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
            <div class="pageTitle">BATALKAN pesanan</div>
            <div class="right"></div>
        </div>

        <?php
            $id = $_GET['ID'];
            $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE ID = '$id'");
            $data = mysqli_fetch_assoc($transactions);
        ?>
        <div class="wide-block pt-2 pb-2">
            <span class="developer-original-transactions detail">
                <img src="<?= $data['ProductImage'] ?>">
                <div description>
                    <span title><?= $data['ProductName'] ?></span>
                    <span date><?= $data['CustomerOrderTimestamp'] ?></span>
                    <span pricetitle>Harga Mitra</span>
                    <span price><?= $data['PartnerPrice'] == "" ? "Rp0" : $data['PartnerPrice'] ?></span>
                    <span detailtitle>Nama pemesan</span>
                    <span detail><?= $data['CustomerUsername'] ?></span>
                    <span addresstitle>Lokasi</span>
                    <span address><?= $data['CustomerProvince'] . ", " . $data['CustomerDistrict'] . ", " . $data['CustomerSubdistrict'] . ", " . $data['CustomerAddress'] ?></span>
                    <span statustitle>Status</span>
                    <span style="color:rgba(0,0,0,0.7);" status><?= $data['Status'] ?></span>
                </div>
            </span>
        </div>

        <div class="wide-block pt-2 pb-2">
            <form action="transaction-cancel-action.php" method="post" enctype="multipart/form-data">
                <div class="form-group boxed">
                    <div class="input-wrapper">
                            <input type="hidden" name="ID" value="<?= $id ?>">
                            <label class="label" for="StatusCanceledReason">Alasan secara spesifik*</label>
                            <textarea class="form-control" id="StatusCanceledReason" name="StatusCanceledReason" placeholder="Tuliskan alasan kamu membatalkan pesanan ini di sini" style="font-size: 13px;"></textarea>
                            <br>
                            <label class="label" for="ButtonFileTrigger">Bukti alasan (Jika ada)</label>
                            <input type="button" id="ButtonFileTrigger" value="Pilih foto" class="btn btn-primary btn-block">
                            <input type="file" style="display: none;" id="ButtonFile" name="StatusCanceledImageProve" accept="image/*">
                    </div>
                </div>

                <div class="mt-2">
                    <button class='btn btn-block btn-danger' id="SubmitButton">BATALKAN pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="developer-original-blackbarrier hidden"></div>

    <div class="developer-original-modal-warning hidden">
        <p>Kamu YAKIN ingin MEMBATALKAN pesanan ini?!</p>
        <div>
            <button>Ga jadi deh 😅</button>
            <button>IYAH</button>
        </div>
    </div>

    <script>
        const submitButton = document.querySelector("#SubmitButton");
        const blackbarrier = document.querySelector(".developer-original-blackbarrier");
        const modalWarning = document.querySelector(".developer-original-modal-warning");
        const buttonFileTrigger = document.querySelector("#ButtonFileTrigger");
        const buttonFile = document.querySelector("#ButtonFile");

        let modalWarningStatus = false;

        submitButton.addEventListener("click", (e)=>{
            if(modalWarningStatus == false)
            {
                modalWarningStatus = true;
                e.preventDefault();
                blackbarrier.classList.remove("hidden");
                modalWarning.classList.remove("hidden");
            }
        });

        modalWarning.children[1].children[0].addEventListener("click", ()=>{
            blackbarrier.classList.add("hidden");
            modalWarning.classList.add("hidden");
            modalWarningStatus = false;
        });

        modalWarning.children[1].children[1].addEventListener("click", ()=>{
            submitButton.click();
        });

        blackbarrier.addEventListener("click", ()=>{
            blackbarrier.classList.add("hidden");
            modalWarning.classList.add("hidden");
            modalWarningStatus = false;
        });

        buttonFileTrigger.addEventListener("click", ()=>buttonFile.click());
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