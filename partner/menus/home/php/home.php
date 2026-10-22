<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['AddressPartner']) && $_SESSION['AddressPartner'] != "-") &&
        (isset($_SESSION['ProvincePartner']) && $_SESSION['ProvincePartner'] != "-") &&
        (isset($_SESSION['DistrictPartner']) && $_SESSION['DistrictPartner'] != "-") &&
        (isset($_SESSION['SubdistrictPartner']) && $_SESSION['SubdistrictPartner'] != "-") &&
        (isset($_SESSION['SkillStatusPartner']) && $_SESSION['SkillStatusPartner'] == "Existed")){

            
        $partnerEmail = $_SESSION['EmailPartner'];
        $partnerSkillStatus = mysqli_fetch_array(mysqli_query($conn, "SELECT PartnerEmail FROM tbl_partners_skill WHERE PartnerEmail = '$partnerEmail' AND Status = 'Sudah dikonfirmasi'"));
        $partnerSkillStatus = $partnerSkillStatus ? true : false;
?>

<!-- TODO : Buat menu transaksi, detail transaksi, dan history transaksi  -->
    <div class="developer-original-dot-status" <?= $_SESSION['StatusPartner'] == "Sedang dapat melayani" ? "active" : "" ?>></div>
    <div class="developer-original-refresh-button">
        &#8635;
        <span>Halaman ini akan refresh secara otomatis setiap 5 menit</span>
    </div>

    <div class="developer-original-skill-warning <?= $partnerSkillStatus == true ? 'hidden' : '' ?>">
        !
    </div>

    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Alinda Home Service
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <?php 
            $orderTotal = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(PartnerEmail) AS 'TransactionValueTotal' FROM tbl_transaction WHERE PartnerEmail = '$partnerEmail' AND Status = 'Selesai'"));
            $orderTotal = $orderTotal ? $orderTotal['TransactionValueTotal'] : "0";

            $orderToday = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(PartnerEmail) AS 'TransactionValueToday' FROM tbl_transaction WHERE PartnerEmail = '$partnerEmail' AND Status = 'Selesai' AND Date = '" . date("Y-m-d") . "'"));
            $orderToday = $orderToday ? $orderToday['TransactionValueToday'] : "0";

            $cashTotalValue = 0;
            $cashTotal = mysqli_query($conn, "SELECT PartnerPrice FROM tbl_transaction WHERE PartnerEmail = '$partnerEmail' AND Status = 'Selesai' AND StatusPayment = 'Sudah dibayar'");
            while ($data = mysqli_fetch_assoc($cashTotal))
            {
                $cashTotalValue += intval(str_replace(".", "", str_replace("Rp", "", $data['PartnerPrice'])));
            }

            $cashTodayValue = 0;
            $cashToday = mysqli_query($conn, "SELECT PartnerPrice FROM tbl_transaction WHERE PartnerEmail = '$partnerEmail' AND Status = 'Selesai' AND StatusPayment = 'Sudah dibayar' AND Date = '" . date("Y-m-d") . "'");
            while ($data = mysqli_fetch_assoc($cashToday))
            {
                $cashTodayValue += intval(str_replace(".", "", str_replace("Rp", "", $data['PartnerPrice'])));
            }

            $statusActivate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT PartnerEmail FROM tbl_transaction WHERE PartnerEmail = '$partnerEmail' AND (Status = 'Berjalan' OR Status = 'Menunggu konfirmasi mitra' OR Status = 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru' OR Status = 'Menunggu konfirmasi pembayaran')"));
        ?>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" style="padding:15px;">
            <?php
                $database = mysqli_query($conn, "SELECT * FROM tbl_admin_advertising");
                $rowCount = 0;
                while($row = mysqli_fetch_assoc($database)){ $rowCount++; ?>
                    <div class="carousel-item <?= $rowCount == 1 ? 'active' : ''?>">
                        <img class="d-block" style="width:100%; max-height: 250px; max-width:500px;" src="<?= $row['Image'] ?>" alt="<?= $row['Title'] ?>">
                    </div>
                    <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="developer-original-body">
            <div>
                <div>
                    <div>Pesanan dan penghasilan hari ini</div>
                    <div>
                        <div>Pesanan<br><span><?= $orderToday ?></span></div>
                        <div>Penghasilan<br><span><?= "Rp" . number_format("$cashTodayValue", 0, ",", ".") ?></span></div>
                    </div>
                </div>
                <div>
                    <div>
                        <div>Total pesanan</div>
                        <div>
                            <div><?= $orderTotal ?></div>
                        </div>
                    </div>
                    <div>
                        <div>Total penghasilan</div>
                        <div>
                            <div><?= "Rp" . number_format("$cashTotalValue", 0, ",", ".") ?></div>    
                        </div>
                    </div>
                </div>
            </div>

            <a href="../../history/php/history.php">Lihat histori transaksi &raquo;</a>
            <a href="<?= $partnerSkillStatus == true && !$statusActivate ? 'activate-status.php' : '#' ?>" <?= $_SESSION['StatusPartner'] == "Sedang dapat melayani" ? "active" : "" ?> id="<?= $partnerSkillStatus == false ? 'ActivateStatusButton' : 'False' ?>"><?= $_SESSION['StatusPartner'] == "Sedang dapat melayani" ? "Matikan status pelayanan" : "Aktifkan status pelayanan" ?></a>
            
            <?php if($statusActivate){ ?>
                <div OrderRunning><p><b>Informasi<br></b>Ketika kamu memiliki pesanan masuk, kamu tidak dapat mengaktifkan status pelayanan. Status pelayanan akan otomatis aktif kembali ketika kamu telah menyelesaikan atau membatalkan pesanan</p></div>
            <?php } ?>

            <?php 
                $data = mysqli_fetch_assoc(mysqli_query(
                    $conn, 
                    "SELECT * FROM tbl_transaction 
                    WHERE PartnerEmail = '$partnerEmail'
                    AND (
                        (
                            ProductName != 'Suruh Apa Saja' 
                            AND Status IN ('Menunggu konfirmasi mitra', 'Berjalan', 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru')
                        )
                        OR (
                            ProductName = 'Suruh Apa Saja' 
                            AND Status IN ('Menunggu konfirmasi mitra', 'Menunggu konfirmasi pembayaran', 'Berjalan', 'Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru')
                        )
                    )"
                ));
                
                if($data)
                { ?>
                    <div class="section full mt-2" style="margin-bottom: 10px; border-bottom:1px solid rgba(0,0,0,0.4); padding-bottom: 10px;">
                        <span style="display:block; color:rgba(0,0,0,0.7); width: 100%; text-align: center; margin-bottom:10px; font-weight:bold; border-bottom:1px solid rgba(0,0,0,0.4);">Pesanan masuk</span>
                        <div class="wide-block pt-2 pb-2">
                            <span class="developer-original-transactions">
                                <img src="<?= $data['ProductImage'] ?>">
                                <div description>
                                    <span title><?= $data['ProductName'] ?></span>
                                    <span date><?= $data['CustomerOrderTimestamp'] ?></span>
                                    <span addresstitle>Detail / catatan</span>
                                    <span address><?= $data['ProductDetail']?></span>
                                    <span pricetitle>Harga Mitra</span>
                                    <span price><?= $data['PartnerPrice'] ?></span>
                                    <span addresstitle>Lokasi</span>
                                    <span address><?= $data['CustomerProvince'] . ", " . $data['CustomerDistrict'] . ", " . $data['CustomerSubdistrict'] . ", " . $data['CustomerAddress'] ?></span>
                                    <span statustitle>Status</span>
                                    <span style="color:<?= $statusColor ?>;" status><?= $data['Status'] ?></span>
                                </div>
                            </span>
                            
                            <span>
                                <a href="../../transaction/php/transaction-detail.php?ID=<?= $data['ID'] ?>"><button class='btn btn-block btn-primary'>Lihat detail</button></a>
                            </span>
                        </div>
                    </div>

                    <audio controls autoplay style="display: none;">
                        <source src="../../../../database/partner/music/notification/Notification.mp3" type="audio/mpeg">
                    </audio>
                <?php } else { ?>

            <a href="../../transaction/php/transaction.php" OrderInformation>
                Pesanan akan muncul di sini ketika kamu mendapatkannya
            </a>

            <?php } ?>
            
            <div class="developer-original-table">
                <table>
                    <thead>
                        <tr>
                            <th colspan="3">Skill yang sudah dikonfirmasi</th>
                        </tr>
                        <tr>
                            <th>Nama Skill</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $email = $_SESSION['EmailPartner'];
                            $num = 0;
                            $products = mysqli_query($conn, "SELECT * FROM tbl_partners_skill WHERE PartnerEmail = '$email' AND Status = 'Sudah dikonfirmasi' LIMIT 5");
                            
                            while($row = mysqli_fetch_assoc($products)){
                                $num++;
                        ?>
                        <tr>
                            <td><?= $row['SkillName'] ?></td>
                            <td><?= $row['Status'] ?></td>
                        </tr>
                        <?php } ?>
                        <?= $num == 0 ? "<tr><td colspan='3'><a href='../../profile/php/form-skill.php?from=home'>Kamu belum memiliki skill yang sudah dikonfirmasi! Segera konfirmasi skill kamu untuk mulai mendapatkan pesanan! Klik text ini untuk pergi ke halaman skill</a></td></tr>" : "" ?>
                    </tbody>
                </table>
            </div>

            <a href="../../profile/php/form-skill.php?from=home" ToSkillPage>Menuju ke halaman skill &raquo;</a>
        </div>
    </div>

    <div class="developer-original-blackbarrier <?= $partnerSkillStatus == true ? 'hidden' : '' ?>"></div>

    <div class="developer-original-modal-confirm hidden">
        <p>
            <?php if($partnerSkillStatus == false){ ?>
                Kamu harus memiliki minimal 1 skill yang sudah dikonfirmasi terlebih dahulu untuk mulai menerima pesanan
                <br><a href="../../profile/php/form-skill-help.php" style="font-size: 13px;">Lihat panduan konfirmasi skill</a>
            <?php } else if($statusActivate == true){ ?>
                Tidak bisa mengaktifkan status pelayanan ketika sedang memiliki pesanan yang aktif atau berjalan
            <?php } ?>
        </p>
        <button>Oke</button>
    </div>

    <div class="developer-original-modal-skill-warning <?= $partnerSkillStatus == true ? 'hidden' : '' ?>">
        <p>Kamu belum memiliki satupun skill yang sudah dikonfirmasi! Hal ini akan membuatmu tidak bisa mendapatkan pesanan! Segera konfirmasi skill untuk mulai menerima pesanan</p>
        <div>
            <button>Tutup</button>
            <a href="../../profile/php/form-skill-help.php"><button>Panduan</button></a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", ()=>{
            const activateStatusButton = document.querySelector("#ActivateStatusButton");
            const blackbarrier = document.querySelector(".developer-original-blackbarrier");
            const modalConfirm = document.querySelector(".developer-original-modal-confirm");
            const skillWarning = document.querySelector(".developer-original-skill-warning");
            const modalSkillWarning = document.querySelector(".developer-original-modal-skill-warning");
            
            if(activateStatusButton)
            {
                activateStatusButton.addEventListener("click", ()=>{
                    blackbarrier.classList.remove("hidden");
                    modalConfirm.classList.remove("hidden");
                });

                modalConfirm.children[1].addEventListener("click", ()=>{
                    blackbarrier.classList.add("hidden");
                    modalConfirm.classList.add("hidden");
                });

                blackbarrier.addEventListener("click", ()=>{
                    blackbarrier.classList.add("hidden");
                    modalConfirm.classList.add("hidden");
                    modalSkillWarning.classList.add("hidden");
                });
            }

            skillWarning.addEventListener("click", ()=>{
                blackbarrier.classList.remove("hidden");
                modalSkillWarning.classList.remove("hidden");
            });

            modalSkillWarning.children[1].children[0].addEventListener("click", ()=>{
                blackbarrier.classList.add("hidden");
                modalSkillWarning.classList.add("hidden");
            });

            setTimeout(()=>window.location.href="refresh.php",300000);
        });
    </script>
<?php
        include "../../footer.php";  
    }

    else if (   (isset($_SESSION['AddressPartner']) && $_SESSION['AddressPartner'] != "-") &&
                (isset($_SESSION['ProvincePartner']) && $_SESSION['ProvincePartner'] != "-") &&
                (isset($_SESSION['DistrictPartner']) && $_SESSION['DistrictPartner'] != "-") &&
                (isset($_SESSION['SubdistrictPartner']) && $_SESSION['SubdistrictPartner'] != "-") &&
                (isset($_SESSION['SkillStatusPartner']) && $_SESSION['SkillStatusPartner'] != "Existed")){ ?>

    <div style="position:absolute; left:50%; top:50%; transform: translate(-50%, -50%); display:flex; flex-direction:column; align-items:center;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100px" height="100px" viewBox="0 0 17 17" version="1.1" style="margin-bottom: 10px;">    
            <title>981</title>    
            <defs></defs>
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <path d="M15.381,5.06 L9.468,5.06 L12.207,1.27 L11.195,1.047 L8.303,5.06 L8.295,5.06 L5.403,1.047 L4.389,1.27 L7.128,5.06 L0.656,5.06 C0.328,5.06 0.063,5.315 0.063,5.631 L0.063,16.416 C0.063,16.733 0.328,16.988 0.656,16.988 L15.379,16.988 C15.708,16.988 15.973,16.733 15.973,16.416 L15.973,5.631 C15.975,5.314 15.71,5.06 15.381,5.06 L15.381,5.06 Z M13,14.67 C13,14.876 12.848,15.042 12.658,15.042 L2.263,15.042 C2.075,15.042 1.922,14.876 1.922,14.67 L1.922,7.304 C1.922,7.1 2.074,6.932 2.263,6.932 L12.658,6.932 C12.847,6.932 13,7.1 13,7.304 L13,14.67 L13,14.67 Z M15,15.042 L14,15.042 L14,14 L15,14 L15,15.042 L15,15.042 Z" fill="#006aff" class="si-glyph-fill"></path>
            </g>
        </svg>

        <p style="display:block; width: 100%; text-align:center;">Mohon untuk mengisi daftar skill atau kemampuan yang kamu bisa!</p>
        <a href="form-skill.php" style="width:100%;"><button class="btn btn-primary" style="width:100%;">Isi Data</button></a>
    </div>

<?php } else { ?>  
    <div style="position:absolute; left:50%; top:50%; transform: translate(-50%, -50%); display:flex; flex-direction:column; align-items:center;">
        <svg width="100px" height="100px" viewBox="0 0 16 16" style="margin-bottom: 10px;">
            <path fill="#006aff" d="M15 2v2h-9v-2h9zM16 1h-11v4h11v-4z"></path>
            <path fill="#006aff" d="M0 1h4v4h-4v-4z"></path>
            <path fill="#006aff" d="M15 7v2h-9v-2h9zM16 6h-11v4h11v-4z"></path>
            <path fill="#006aff" d="M0 6h4v4h-4v-4z"></path>
            <path fill="#006aff" d="M15 12v2h-9v-2h9zM16 11h-11v4h11v-4z"></path>
            <path fill="#006aff" d="M0 11h4v4h-4v-4z"></path>
        </svg>
        <p style="display:block; width: 100%; text-align:center;">Isi data kamu untuk mulai menggunakan aplikasi</p>
        <a href="form.php" style="width:100%;"><button class="btn btn-primary" style="width:100%;">Isi Data</button></a>
    </div>
<?php
    }
?>