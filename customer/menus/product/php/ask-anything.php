<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>

    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="product.php" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Suruh Apa Saja
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2">
                <form class="needs-validation" action="ask-anything-action.php" method="post" novalidate>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Description">Deskripsi Perintah</label>
                            <textarea class="form-control" name="Description" id="Description" placeholder="Tulis deskripsi perintah di sini ... 'Bersihkan kamar 4x4 meter'" required></textarea>
                            <div class="invalid-feedback">Mohon untuk mengisi deskripsi perintah</div>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Sub-Description">Jumlah atau Ukuran</label>
                            <textarea class="form-control" name="Sub-Description" id="Sub-Description" placeholder="Tulis jumlah atau ukuran di sini ... '2 kamar 4x4 meter'" required></textarea>
                            <div class="invalid-feedback">Mohon untuk mengisi jumlah atau ukuran</div>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Price">Harga Pengajuan (Rp)</label>
                            <input type="text" class="form-control" name="Price" id="Price" placeholder="Tulis harga pengajuan di sini ... '100.000'" required>
                            <div class="invalid-feedback">Mohon untuk mengisi harga pengajuan</div>
                        </div>
                    </div>

                    
                    <div class="wide-block pt-2 pb-2">
                        Harga yang diajukan akan ditambah sebanyak Rp15.000 sebagai biaya layanan dan biaya transportasi.
                    </div>

                    <div class="mt-2">
                        <input class="btn btn-primary btn-block" type="submit" id="OrderButton" value="Ajukan Permintaan">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="developer-original-blackbarrier hidden" id="Blackbarrier-02"></div>

    <div class="developer-original-modal-delete hidden" id="OrderConfirm">
        <p>Konfirmasi pesan jasa?</p>
        <div>
            <button class="negative">Tidak</button>
            <button class="positive">Iya</button>
        </div>
    </div>

    <script src="../js/script.js"></script>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>