<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['AddressPartner']) && $_SESSION['AddressPartner'] != "-") &&
        (isset($_SESSION['ProvincePartner']) && $_SESSION['ProvincePartner'] != "-") &&
        (isset($_SESSION['DistrictPartner']) && $_SESSION['DistrictPartner'] != "-") &&
        (isset($_SESSION['SubdistrictPartner']) && $_SESSION['SubdistrictPartner'] != "-") &&
        (isset($_SESSION['SkillStatusPartner']) && $_SESSION['SkillStatusPartner'] == "Existed")){
?>

<!-- TODO : Buat menu skill, menu home -->
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
                    <a href="#"><img src="<?= $_SESSION['ImagePartner'] ?>" alt="avatar" class="imaged rounded" style="width: 64px; height: 64px;" id="ProfilePictureAccount"></a>
                </div>
                <div class="in">
                    <h3 class="name"><?= $_SESSION['UsernamePartner'] ?></h3>
                    <h5 class="subtext"><?= $_SESSION['EmailPartner'] ?></h5>
                </div>
                <div style="position: absolute; right:15px;"><a href="#"><img src="../media/IDCard.png" style="width: 25px; height: 25px;" id="ImageCard"></a></div>
            </div>
        </div>

        <div class="section mt-1 mb-2">
            <div class="profile-info">
                <div class=" bio">
                    <?= $_SESSION['ProvincePartner'] . ", " . $_SESSION['DistrictPartner'] . ", " . $_SESSION['SubdistrictPartner'] . ", " . $_SESSION['AddressPartner'] ?>
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
                    <a href="form-skill.php" class="item">
                        <div class="in">
                            <div>
                                Skill yang dikuasai
                                <div class="text-muted">Tambah atau Hapus skill</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <a href="form-skill-help.php?from=profile" class="item">
                        <div class="in">
                            <div>
                                Panduan konfirmasi skill
                                <div class="text-muted">Halaman lengkap mengenai panduan konfirmasi skill yang dimiliki</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <a href="form-skill-help-video.php?from=profile" class="item">
                        <div class="in">
                            <div>
                                Video panduan konfirmasi skill
                                <div class="text-muted">Tonton video YouTube mengenai tutorial mengonfirmasi skill yang kamu miliki</div>
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