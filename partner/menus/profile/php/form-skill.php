<?php 
    include "../../header.php"; 
    $from = isset($_GET['from']) ? "../../home/php/" . $_GET['from'] . ".php" : "profile.php";
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="<?= $from ?>" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Data skill</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2" style="display: flex; justify-content: center;">
                <a href="form-skill-add.php<?= $from == "../../home/php/home.php" ? "?from=home" : "" ?>"><button class="btn btn-primary">Tambah skill</button></a>
            </div>

            <div class="wide-block pt-2 pb-2">
                <div class="developer-original-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Skill</th>
                                <th>Status</th>
                                <th>Tanggal konfirmasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $email = $_SESSION['EmailPartner'];
                                $num = 0;
                                $products = mysqli_query($conn, "SELECT * FROM tbl_partners_skill WHERE PartnerEmail = '$email'");
                                while($row = mysqli_fetch_assoc($products)){
                                    $num++;
                            ?>
                            <tr>
                                <td><?= $row['SkillName'] ?></td>
                                <td><?= $row['Status'] ?></td>
                                <td><?= $row['DateApproved'] != '' ? $row['DateApproved'] : "Belum dikonfirmasi" ?></td>
                                <?php if($row['DateApproved'] == "") { ?>
                                    <td><span><a href="form-skill-delete.php?ID=<?= $row['ID'] ?><?= $from == "../../home/php/home.php" ? "&from=home" : "" ?>"><button class='button-hapus'>Hapus</button></span></a></td>
                                <?php } else { ?>
                                    <td><span><button class='button-edit'></button></span></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div style="font-size: 14px;">
                    <span style="font-weight: bold; font-size: 15px;">Informasi penting :<br></span>
                    - Geser tabel secara horizontal (kanan/kiri) untuk melihat data lainnya<br>
                    - Skill yang didaftarkan harus dikonfirmasi terlebih dahulu oleh perusahaan secara langsung<br>
                    - Status skill harus sudah dikonfirmasi agar kamu bisa mendapatkan pesanan yang sesuai dengan skill tersebut<br>
                    - Jika skill belum ada yang dikonfirmasi, maka kamu tidak akan mendapatkan pesanan<br>
                    - Lihat panduan <a href="form-skill-help.php<?= $from == "../../home/php/home.php" ? "?from=home" : "" ?>" style="font-weight:bold; font-size:15px;">cara konfirmasi skill</a><br>
                    - Hubungi customer service jika kamu memiliki kendala atau kebingungan<br>
                    - Skill yang sudah dikonfirmasi tidak bisa dihapus<br> 
                    - Hubungi customer service / admin jika ingin menghapus skill yang sudah dikonfirmasi<br>
                    - Jika ingin menambahkan skill yang sudah ada untuk dikonfirmasi lagi, silahkan hubungi customer service / admin<br>
                </div>
            </div>

            <?php if($num>0){ ?>
                <div class="wide-block pt-2 pb-2">
                    <a href="form-skill-done.php?Email=<?= $_SESSION['EmailPartner'] ?>" style="display: block; width: 100%;"><button class="btn btn-primary" style="width: 100%;">Selesai!</button></a>
                </div>
            <?php } ?>
        </div>

        <div class="developer-original-blackbarrier hidden"></div>

        <div class="developer-original-modal-delete hidden">
        <p>Yakin ingin menghapus skill ini?</p>
        <div>
            <button>Tidak</button>
            <a><button>Iya</button></a>
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
    
    <script>
        document.addEventListener("DOMContentLoaded", ()=>{
            const blackbarrier = document.querySelector(".developer-original-blackbarrier");
            const modalDelete = document.querySelector(".developer-original-modal-delete");

            document.querySelectorAll(".button-hapus").forEach((e)=>{
                if(e){
                    e.addEventListener("click", (h)=>{
                        h.preventDefault();
                        blackbarrier.classList.remove("hidden");
                        modalDelete.classList.remove("hidden");
                        modalDelete.children[1].children[1].setAttribute("href", e.parentElement.getAttribute("href"));
                    });
                }  
            });

            modalDelete.children[1].children[0].addEventListener("click", ()=>{
                blackbarrier.classList.add("hidden");
                modalDelete.classList.add("hidden");
            });

            blackbarrier.addEventListener("click", ()=>{
                blackbarrier.classList.add("hidden");
                modalDelete.classList.add("hidden");
            });
        });
    </script>
</body>
</html>