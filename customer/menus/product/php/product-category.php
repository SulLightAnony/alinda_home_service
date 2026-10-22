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
            <a href="product.php?search=<?= $_GET['search'] ?>" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Jasa Layanan
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <?php 
            $id = $_GET['ID'];

            if(isset($_GET['back'])){
                $parentID = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Tags FROM tbl_admin_product WHERE ID = '$id' LIMIT 1"))['Tags'];
                preg_match('/\((\d+)\)/', $parentID, $match);
                $id = $match[1];
            }

            $product = mysqli_query($conn, "SELECT * FROM tbl_admin_product WHERE Tags = 'ParentID($id)' ORDER BY Name ASC");

            while($row = mysqli_fetch_assoc($product)){?>
                <div class="wide-block pt-2 pb-2">
                    <span class="developer-original-transactions">
                        <img src="<?= $row['Image'] ?>">
                        <div description>
                            <span title><?= $row['Name'] ?></span>
                            <span detail><?= $row['Description']?></span>
                            <span pricetitle>Harga</span>
                            <span price><?= $row['Price'] ?></span>
                        </div>
                    </span>
                    
                    <span>
                        <a href="product-detail.php?ID=<?= $row['ID'] ?>&search=<?= $_GET['search'] ?>" class='btn btn-block btn-primary'>Pilih</a>
                    </span>
                </div>
        <?php } ?>
    </div>
<?php
        include "../../footer.php";  
    }
    else { header("location: ../../home/php/home.php"); }
?>