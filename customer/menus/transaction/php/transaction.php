<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>

    <link rel="stylesheet" href="../css/style.css">
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Transaksi
        </div>
        <a href="../../customer-service/php/customer-service.php?link=<?= $_SERVER['REQUEST_URI'] ?>"><img src="../media/image/Headset.png" style="position:absolute; right:20px; top:13px; width: 30px;"></a>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        
        <div class="header-large-title">
            <!-- <h4 class="title">Wellcome</h4>
            <h4 class="subtitle">Welcome to Alinda</h4> -->
        </div>

        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" class="form-control" placeholder="Cari transaksi..." name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
                        <i class="input-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </i>
                    </div>
                </form>
            </div>
        </div>

        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <span>
                    <b>Informasi :</b>
                    <br>
                    - Harap untuk refresh halaman secara berkala untuk mengetahui jika ada perubahan status pada transaksi
                    <br>
                    - Halaman akan otomatis refresh setiap 5 menit
                </span>
            </div>
        </div>


        <div class="section full mt-2">
            <?php
                $statusColor = "black";
                if(isset($_GET['search']) && $_GET['search'] != ""){
                    $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE CustomerEmail = '" . $_SESSION['Email'] . "' AND ProductName LIKE '%" . $_GET['search'] . "%' ORDER BY CustomerOrderTimestamp DESC");
                }
                else {
                    $transactions = mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE CustomerEmail = '" . $_SESSION['Email'] . "' ORDER BY CustomerOrderTimestamp DESC");
                }
                while($row = mysqli_fetch_assoc($transactions)){
                    if($row['Status'] == "Menunggu konfirmasi pembayaran"){ $statusColor = "rgb(223, 171, 0);"; }
                    else if($row['Status'] == "Menunggu konfirmasi mitra"){ $statusColor = "rgb(223, 171, 0);"; }
                    else if($row['Status'] == "Menunggu konfirmasi mitra."){ $statusColor = "rgb(223, 171, 0);"; }
                    else if($row['Status'] == "Transaksi ditolak"){ $statusColor = "rgb(243, 51, 51);"; }
                    else if($row['Status'] == "Transaksi dibatalkan oleh customer"){ $statusColor = "rgb(243, 51, 51);"; }
                    else if($row['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru"){ $statusColor = "rgb(223, 171, 0);"; }
                    else if($row['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru."){ $statusColor = "rgb(223, 171, 0);"; }
                    else if($row['Status'] == "Selesai"){ $statusColor = "rgb(0, 119, 255);"; }
                    else if($row['Status'] == "Berjalan"){ $statusColor = "rgba(0, 0, 0, 0.7);"; }
                    else if($row['Status'] == "Transaksi gagal"){ $statusColor = "rgb(243, 51, 51);"; }
            ?>
            <div class="wide-block pt-2 pb-2">
                <span class="developer-original-transactions">
                    <img src="<?= $row['ProductImage'] ?>">
                    <div description>
                        <span title><?= $row['ProductName'] ?></span>
                        <span date><?= $row['CustomerOrderTimestamp'] ?></span>
                        <span addresstitle>Detail / catatan</span>
                        <span address><?= $row['ProductDetail']?></span>
                        <span pricetitle>Harga</span>
                        <span price><?= $row['ProductPrice'] ?></span>
                        <span addresstitle>Lokasi</span>
                        <span address><?= $row['CustomerProvince'] . ", " . $row['CustomerDistrict'] . ", " . $row['CustomerSubdistrict'] . ", " . $row['CustomerAddress'] ?></span>
                        <span statustitle>Status</span>
                        <span style="color:<?= $statusColor ?>;" status><?= $row['Status'] ?></span>
                    </div>
                </span>
                
                <span>
                    <?php
                        if($row['Status'] == "Transaksi ditolak"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Transaksi dibatalkan oleh customer"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru."){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Berjalan"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Selesai"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Transaksi gagal"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                        else if($row['Status'] == "Menunggu konfirmasi pembayaran" && $row['ProductName'] == "Suruh Apa Saja"){ echo "<a href='transaction-detail.php?ID=" . $row['ID'] . "'><button class='btn btn-block btn-primary'>Lihat detail</button></a>"; }
                    ?>
                </span>
            </div>
            <?php } ?>
        </div>
    </div>

    <button class="developer-original-refresh">&#8635;</button>
    <script>
        document.querySelector(".developer-original-refresh").addEventListener("click", ()=>{
            document.querySelector(".developer-original-refresh").classList.add("rotated");
            setTimeout(()=>window.location.href = "transaction.php",300);
        });

        document.addEventListener("DOMContentLoaded", ()=>setTimeout(()=>window.location.reload(),300000));
    </script>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>