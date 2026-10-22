<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>

<!-- TODO : Buat Search untuk halaman ini -->
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Produk
        </div>
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
                        <input type="text" class="form-control" placeholder="Cari produk..." name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
                        <input type="hidden" class="form-control" name="status" value="<?= isset($_GET['status']) ? $_GET['status'] : "" ?>">
                        <i class="input-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </i>
                    </div>
                </form>
            </div>
            <?php
                $status = null; 
                if(isset($_GET['status']))
                {
                    if($_GET['status'] == 'cleaning'){ $status = 'Cleaning'; }
                    else if($_GET['status'] == 'repairing'){ $status = 'Repairing'; }
                }
                else
                {
                    echo isset($_GET['search']) && $_GET['search'] != ""  ? "" : "<script>window.location.href='product.php?status=cleaning';</script>";
                }
            ?>
                
            <div class="wide-block pt-2 pb-2" style="display: flex; justify-content: center; gap:5px;">
                <?php 
                    if((isset($_GET["status"]) && $_GET["status"] == "repairing") && (isset($_GET['search']) && $_GET['search'] != "")){ echo "<a href='product.php?status=cleaning&search=" . $_GET['search'] . "'>"; }
                    else if((isset($_GET["status"]) && $_GET["status"] == "repairing")){ echo "<a href='product.php?status=cleaning'>"; }
                ?>
                    <button class="btn <?= isset($_GET["status"]) && $_GET['status'] == 'cleaning' ? 'btn-primary' : '' ?> border-1 border-primary">Cleaning</button><?= isset($_GET["status"]) && $_GET["status"] == "repairing" ? "</a>" : "" ?>
                <?php
                    if((isset($_GET["status"]) && $_GET["status"] == "cleaning") && (isset($_GET['search']) && $_GET['search'] != "")){ echo "<a href='product.php?status=repairing&search=" . $_GET['search'] . "'>"; }
                    else if((isset($_GET["status"]) && $_GET["status"] == "cleaning")){ echo "<a href='product.php?status=repairing'>"; }
                ?>
                <button class="btn <?= isset($_GET["status"]) && $_GET['status'] == 'repairing' ? 'btn-primary' : '' ?> border-1 border-primary">Repairing</button><?= isset($_GET["status"]) && $_GET["status"] == "cleaning" ? "</a>" : "" ?>
            </div>
        </div>

        <style>
            .categories {
                padding: 16px;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 10px;
                text-align: center;
            }

            .category-item {
                padding: 10px;
                border-radius: 6px;
                background-color: #f9f9f9;
            }
        </style>
        
        <div class="categories">
            <?php
                $syntax = isset($_GET['search']) ? "WHERE (Name LIKE '%" . $_GET['search'] . "%') AND (Status = '" . $status . "' OR Status = 'Cleaning/Repairing')" : "WHERE (Status = '" . $status . "' OR Status = 'Cleaning/Repairing')";
                $products = mysqli_query($conn, "SELECT * FROM tbl_admin_product " . $syntax . "ORDER BY Name ASC");
                while($row = mysqli_fetch_assoc($products)){
            ?>
            <a href="product-detail.php?ID=<?= $row['ID'] ?>&status=<?= isset($_GET['status']) ? $_GET['status'] : "" ?>&search=<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
                <div class="category-item">
                    <div class="category-icon"></div>
                    <img src="<?= $row['Image'] ?>" class="card-img-top" style="width: 90px; height: 72px;" alt="image" loading="lazy">
                    <div style="font-size:13px; color:grey;"><?= $row['Name'] ?></div>
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>