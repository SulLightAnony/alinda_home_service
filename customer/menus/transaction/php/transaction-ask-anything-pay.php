<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>
    <!-- TODO : Kanjut pesan jasa -->
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="transaction-detail.php?ID=<?= $_GET['id'] ?>" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Bayar
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <?php 
            $account = mysqli_query($conn, "SELECT * FROM tbl_admin_account LIMIT 1");
            $data = mysqli_fetch_assoc($account);

            $transaction = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE ID = '" . $_GET['id'] . "'");
            $data2 = mysqli_fetch_assoc($transaction);
        ?>

        <!-- * carousel -->
        <div class="section full">
            <div class="wide-block pt-2 pb-2 product-detail-header">
                <h1 class="title">Nama produk</h1>
                <div class="detail-footer">
                     <?= $data2['ProductName'] ?>
                </div>
            </div>
        </div>

        <div class="section full">
            <div class="wide-block pt-2 pb-2">
                <span>Jumlah yang harus dibayar</span>
                <div style="display:flex; justify-content:center; gap:10px; margin-top: 10px; width: 100%;">
                    <h2 style="color: rgb(0, 119, 255);"><?= $data2['ProductPrice'] ?></h2>
                </div>
            </div>
            <div class="wide-block pt-2 pb-2">
                <div style="display:flex; gap:10px;">
                    <img src="<?= $data['Image'] ?>" style="width:30px; height:30px;">
                    <h3 style="margin-top:5px;"><?= '(' . $data['Code'] . ') ' . $data['Bank'] ?></h3>
                </div>
                <span>Transfer ke rekening</span>
                <div style="display:flex; justify-content:center; gap:10px; margin-top: 10px; width: 100%;">
                    <h2 style="color: rgb(0, 119, 255);"><?= $data['AccountNumber'] ?></h2>
                    <svg style="margin-top:2px; cursor:pointer;" id="CopyText" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 3H14.6C16.8402 3 17.9603 3 18.816 3.43597C19.5686 3.81947 20.1805 4.43139 20.564 5.18404C21 6.03969 21 7.15979 21 9.4V16.5M6.2 21H14.3C15.4201 21 15.9802 21 16.408 20.782C16.7843 20.5903 17.0903 20.2843 17.282 19.908C17.5 19.4802 17.5 18.9201 17.5 17.8V9.7C17.5 8.57989 17.5 8.01984 17.282 7.59202C17.0903 7.21569 16.7843 6.90973 16.408 6.71799C15.9802 6.5 15.4201 6.5 14.3 6.5H6.2C5.0799 6.5 4.51984 6.5 4.09202 6.71799C3.71569 6.90973 3.40973 7.21569 3.21799 7.59202C3 8.01984 3 8.57989 3 9.7V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.0799 21 6.2 21Z" stroke="rgba(0, 0, 0, 0.7)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="section full">
            <div class="wide-block pt-2 pb-2">
                <h3>Informasi</h3>
                <span style="font-size:14px;">- Jumlah yang dibayarkan harus sesuai dengan harga yang tertera, tidak kurang tidak lebih</span>
                <br>
                <span style="font-size:14px;">- Setelah mengirim bukti, admin akan mengkonfirmasi kecocokan harga dan kebenaran pembayaran</span>
            </div>
        </div>

        <div class="section full mt-2">
            <form action="transaction-ask-anything-pay-action.php?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                <div class="wide-block pt-2 pb-2">
                    <button class="btn btn-block btn-primary" id="UploadFileButton">Upload bukti transfer</button>
                    <input type="file" name="Image" accept="image/*" style="display: none;">
                </div>
                <div class="wide-block pt-2 pb-2">
                    <input type="submit" class="btn btn-block btn-primary" value="Konfirmasi" id="ConfirmButton" disabled>
                </div>
            </form>
        </div>
    </div>

    <div style="display:flex; justify-content:center; align-items:center; border-radius:3px; position:fixed; width: 90px; height:30px; bottom:70px; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.7); color:white; opacity:0%; pointer-events: none; transition: 0.3s;" id="TextCopied">
        <span>Text disalin</span>
    </div>

    <script>
        const textCopied = document.getElementById("TextCopied");
        const uploadFileButton = document.getElementById("UploadFileButton");
        const confirmButton = document.getElementById("ConfirmButton");
        const fileInput = uploadFileButton.nextElementSibling;

        document.getElementById("CopyText").addEventListener("click", () => {
            navigator.clipboard.writeText("<?= $data['AccountNumber'] ?>");
            textCopied.style.opacity = "100%";

            setTimeout(() => {
                textCopied.style.opacity = "0%";
            }, 2000);
        });

        uploadFileButton.addEventListener("click", (e) => {
            e.preventDefault();
            fileInput.click();

            fileInput.addEventListener("input", () => {
                const file = fileInput.files[0];

                if (!file) {
                    confirmButton.setAttribute("disabled", "");
                    return;
                }

                const validTypes = ["image/jpeg", "image/png", "image/jpg", "image/JPEG", "image/PNG", "image/JPG"];
                if (!validTypes.includes(file.type)) {
                    alert("File yang Kamu pilih bukan gambar yang valid. Silakan pilih file JPEG, PNG, atau JPG.");
                    fileInput.value = "";
                    confirmButton.setAttribute("disabled", "");
                } else {
                    confirmButton.removeAttribute("disabled");
                }
            }, { once: true });
        });
    </script>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>