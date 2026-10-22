<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>

<!-- TODO : Buat menu akun, edit password, edit produk, edit data pribadi dipisah -->
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Profile
        </div>
        
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        
        <div class="header-large-title">
            <!-- <h4 class="title">Wellcome</h4>
            <h4 class="subtitle">Welcome to Alinda</h4> -->
        </div>

        <div class="section mt-2">
            <div class="profile-head">
                <div class="avatar">
                    <a href="#"><img src="<?= $_SESSION['Image'] ?>" alt="avatar" class="imaged rounded" style="width: 64px; height: 64px;" id="ProfilePictureAccount"></a>
                </div>
                <div class="in">
                    <h3 class="name"><?= $_SESSION['Username'] ?></h3>
                    <h5 class="subtext"><?= $_SESSION['Email'] ?></h5>
                </div>
            </div>
        </div>

        <div class="section mt-1 mb-2">
            <div class="profile-info">
                <div class=" bio">
                    <?= $_SESSION['Province'] . ", " . $_SESSION['District'] . ", " . $_SESSION['Subdistrict'] . ", " . $_SESSION['Address'] ?>
                </div>
            </div>
        </div>

        <div class="section full">
            <ul class="listview image-listview flush transparent pt-1">
                <li style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <a href="form-edit.php" class="item">
                        <div class="in">
                            <div>
                                Edit data pribadi
                                <div class="text-muted">Username, Foto Profil, Lokasi, dll</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <a href="form-password.php" class="item">
                        <div class="in">
                            <div>
                                Ubah password
                                <div class="text-muted">Mengubah password akun</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <a href="form-product.php" class="item">
                        <div class="in">
                            <div>
                                Produk yang dimiliki
                                <div class="text-muted">Tambah atau Hapus produk</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <a href="information-page.php" class="item">
                        <div class="in">
                            <div>
                                Halaman Informasi
                                <div class="text-muted">Lihat berbagai macam informasi melalui video</div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>