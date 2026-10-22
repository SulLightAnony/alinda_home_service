<?php 
    include "../../header.php"; 
    if (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] != "-"){header("location: home.php");}
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="Home.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Data produk</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2" style="display: flex; justify-content: center;">
                <a href="form-product-add.php"><button class="btn btn-primary">Tambah produk</button></a>
            </div>

            <div class="wide-block pt-2 pb-2">
                <div class="developer-original-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Detail Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $email = $_SESSION['Email'];
                                $num = 0;
                                $products = mysqli_query($conn, "SELECT * FROM tbl_customers_product WHERE CustomerEmail = '$email'");
                                while($row = mysqli_fetch_assoc($products)){
                                    $num++;
                            ?>
                            <tr>
                                <td><?= $row['ProductName'] ?></td>
                                <td><?= $row['ProductDetail'] ?></td>
                                <td><span><a href="form-product-delete.php?ID=<?= $row['ID'] ?>"><button class='button-hapus'>Hapus</button></span></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if($num>0){ ?>
                <div class="wide-block pt-2 pb-2">
                    <a href="form-product-done.php?Email=<?= $_SESSION['Email'] ?>" style="display: block; width: 100%;"><button class="btn btn-primary" style="width: 100%;">Selesai!</button></a>
                </div>
            <?php } ?>
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
    </script>
</body>
</html>