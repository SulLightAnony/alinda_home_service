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
        
        <div class="header-large-title">
            <!-- <h4 class="title">Wellcome</h4>
            <h4 class="subtitle">Welcome to Alinda</h4> -->
        </div>

        <div class="section full mt-3 mb-3">
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

            <div class="developer-original-section-title"><span></span><div><span>Pesanan populer</span></div></div>
            <div class="carousel-multiple owl-carousel owl-theme">
                <?php 
                    $transaction = mysqli_query($conn, "
                        WITH Ranked AS (
                            SELECT 
                                *,
                                ROW_NUMBER() OVER (PARTITION BY ProductName ORDER BY ID) AS rn,
                                COUNT(*) OVER (PARTITION BY ProductName) AS jumlah
                            FROM tbl_transaction
                            )
                            SELECT ProductName, ProductStatus, ProductImage, jumlah
                            FROM Ranked
                            WHERE rn = 1
                            ORDER BY jumlah DESC LIMIT 10"
                    );

                    while($row = mysqli_fetch_array($transaction)){
                        $productID = mysqli_query($conn, "SELECT ID FROM tbl_admin_product WHERE Name = '" . $row['ProductName'] . "'");
                        $productID = mysqli_fetch_assoc($productID);
                        if($productID){ $productID = $productID['ID']; }
                        else{ continue; }
                ?>
                    <a href="../../product/php/product-detail.php?ID=<?= $productID ?>&search=" >
                        <div class="item">
                            <div class="card" style="display: flex; flex-direction:column; justify-content:center; align-items:center; box-shadow: none; border-radius: 15px;">
                                <img src="<?= $row['ProductImage'] ?>" class="card-img-top" alt="image" style="width:100px; margin:10px;">
                                <div class="card-body pt-2" style="height:80px; overflow-y:hidden;" >
                                    <h4 class="mb-0"><?= $row['ProductName'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
        <style>
        .categories {
            padding: 16px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 10px;
            text-align: center;
        }

        .category-item {
            padding: 10px;
            border-radius: 6px;
            background-color: #f9f9f9;
        }
        </style>

        <div class="developer-original-section-title"><span></span><div><span>Pesan jasa</span></div></div>

        <div class="categories" style="background: white; height:170px; display:flex; align-items: center; justify-content: center;">
            <a href="../../product/php/product.php?status=cleaning" style="width: 50%;">
                <div class="category-item" style="height: 140px; display:flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 15px;">
                    <div class="category-icon"></div>
                    <img src="../../../../database/universal/image/Menu-Product.png" class="card-img-top" style="width: 60px; height: 60px;" alt="image">
                    <div>Product</div>
                </div>
            </a>
            <a href="../../product/php/ask-anything.php" style="width: 50%;">
                <div class="category-item" style="height: 140px; display:flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 15px;">
                    <div class="category-icon"></div>
                    <img src="../../../../database/admin/image/product/Repair.png" class="card-img-top" style="width: 60px; height: 60px;" alt="image">
                    <div>Suruh Apa Saja</div>
                </div>
            </a>
        </div>

        <div class="developer-original-section-title" style="transform: translateY(7px);"><span></span><div><span>Pesanan terakhir</span></div></div>
        <?php 
            $email = $_SESSION['Email'];
            $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_transaction WHERE CustomerEmail = '$email' ORDER BY CustomerOrderTimestamp DESC LIMIT 1"));
            
            if($data)
            { ?>
                <div class="section full mt-2" style="margin-bottom: 10px; border-bottom:1px solid rgba(0,0,0,0.4); padding-bottom: 10px;">
                    <div class="wide-block pt-2 pb-2">
                        <span class="developer-original-transactions">
                            <img src="<?= $data['ProductImage'] ?>">
                            <div description>
                                <span title><?= $data['ProductName'] ?></span>
                                <span date><?= $data['CustomerOrderTimestamp'] ?></span>
                                <span addresstitle>Detail / catatan</span>
                                <span address><?= $data['ProductDetail']?></span>
                                <span pricetitle>Harga</span>
                                <span price><?= $data['ProductPrice'] ?></span>
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
            <?php } else { ?>

        <a href="../../product/php/product.php" OrderInformation>
            Kamu belum pernah melakukan pemesanan. Mulailah memesan jasa!
        </a>

        <br><br><br><br>
        
        <?php } ?>
    </div>
<?php
        include "../../footer.php";  
    }

    else if (   (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
                (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
                (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
                (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
                (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] != "Existed")){ ?>
    <div style="position:absolute; left:50%; top:50%; transform: translate(-50%, -50%); display:flex; flex-direction:column; align-items:center;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100px" height="100px" viewBox="0 0 17 17" version="1.1" style="margin-bottom: 10px;">    
            <title>981</title>    
            <defs></defs>
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <path d="M15.381,5.06 L9.468,5.06 L12.207,1.27 L11.195,1.047 L8.303,5.06 L8.295,5.06 L5.403,1.047 L4.389,1.27 L7.128,5.06 L0.656,5.06 C0.328,5.06 0.063,5.315 0.063,5.631 L0.063,16.416 C0.063,16.733 0.328,16.988 0.656,16.988 L15.379,16.988 C15.708,16.988 15.973,16.733 15.973,16.416 L15.973,5.631 C15.975,5.314 15.71,5.06 15.381,5.06 L15.381,5.06 Z M13,14.67 C13,14.876 12.848,15.042 12.658,15.042 L2.263,15.042 C2.075,15.042 1.922,14.876 1.922,14.67 L1.922,7.304 C1.922,7.1 2.074,6.932 2.263,6.932 L12.658,6.932 C12.847,6.932 13,7.1 13,7.304 L13,14.67 L13,14.67 Z M15,15.042 L14,15.042 L14,14 L15,14 L15,15.042 L15,15.042 Z" fill="#006aff" class="si-glyph-fill"></path>
            </g>
        </svg>

        <p style="display:block; width: 100%; text-align:center;">Tersisa satu langkah lagi! Beritahu kami apa saja produk yang kamu miliki di rumahmu!</p>
        <a href="form-product.php" style="width:100%;"><button class="btn btn-primary" style="width:100%;">Isi Data</button></a>
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