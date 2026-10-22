<?php 
    include "../../header.php"; 

    $from = isset($_GET['from']) ? $_GET['from'] : "";
    if($from == "home"){$from = "form-skill.php?from=home";}
    else if($from == "profile"){$from = "profile.php";}
    else{$from = "form-skill.php";}
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="<?= $from ?>" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Panduan konfirmasi skill</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2">
                <span style="font-weight: bold; font-size:17px;">Panduan<br></span>
                1. Pilih skill yang kamu kuasai di menu skill<br>
                2. Pergi ke pusat Alinda Home Service untuk membuktikan dan mengkonfirmasikan skill yang kamu miliki kepada admin<br>
                3. Setelah admin mengkonfirmasi skill, kamu akan bisa mulai menerima pesanan yang sesuai dengan skill yang kamu milikki
                <br><br>
                - Silahkan hubungi Customer Service jika ada pertanyaan lebih lanjut<br>
                - Silahkan hubungi Customer Service untuk mengetahui apa saja yang harus dipersiapkan untuk mengkonfirmasi skill<br><br>

                <a href="form-skill-help-video.php?from=help" class='btn btn-block btn-primary'>Tonton video tutorial</a>
            </div>

            <div class="wide-block pt-2 pb-2">
                <?php 
                    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM tbl_center_address"));
                ?> 
                <span style="font-weight: bold; font-size:17px;">Pusat Alinda Home Service<br></span>
                <span style="font-weight: bold; font-size:16px;">Provinsi<br></span>
                <?= $data['Province'] ?> <br>
                <span style="font-weight: bold; font-size:16px;">Kota / Kabupaten<br></span>
                <?= $data['District'] ?> <br>
                <span style="font-weight: bold; font-size:16px;">Kecamatan<br></span>
                <?= $data['Subdistrict'] ?> <br>
                <span style="font-weight: bold; font-size:16px;">Alamat<br></span>
                <?= $data['Address'] ?> <br>
                <span style="font-weight: bold; font-size:16px;">Google Map<br></span>
                <a href="<?= $data['GoogleMap'] ?>" target="_blank">Menuju Google Map</a>
            </div>
            <div class="wide-block pt-2 pb-2">
                <a href="../../customer-service/php/customer-service.php?link=<?= $_SERVER['REQUEST_URI'] ?>" class='btn btn-block btn-primary'>Hubungi Customer Service</a>
            </div>
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
</body>
</html>