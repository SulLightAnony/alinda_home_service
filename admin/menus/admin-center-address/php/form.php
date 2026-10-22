<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Admin Center Address</title>

    <!-- Styles -->
    <?php include "../../template/styles.php"; ?>

    <link rel="stylesheet" href="../css/pagination.css">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- Sidebar -->
        <?php include "../../template/navbar.php"; ?>

        <div class="page-container">
            <!-- Header -->
            <?php include "../../template/header.php"; ?>

            <!-- Content-->
            <div class="main-content">
            <?php
                // Configuration --------------------------
                $ThisURL = "form.php";
                $RedirectURL = "index.php";
                $ImageURL = "../../../../database/admin/image/bank/";
                $table = "tbl_center_address";

                $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
                $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
                $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
                $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
                $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $add = htmlspecialchars($_POST['Add']);
                $id = isset($_GET['id']) ? $_GET['id'] : null;

                // Configuration --------------------------
                $province = htmlspecialchars($_POST['Province']);
                $district = htmlspecialchars($_POST['District']);
                $subdistrict = htmlspecialchars($_POST['Subdistrict']);
                $address = htmlspecialchars($_POST['Address']);
                $googleMap = htmlspecialchars($_POST['GoogleMap']);

                if($add == "Add")
                {
                    $query = "INSERT INTO $table (
                    Province,
                    District,
                    Subdistrict,
                    Address,
                    GoogleMap)
                    VALUES (?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssss", $province, $district, $subdistrict, $address, $googleMap);

                    if ($stmt->execute()) {
                        echo "<script>window.location.href = '" . $RedirectURL . "';</script>";
                        exit();
                    } else {
                        echo "Gagal menambahkan user: " . $conn->error;
                    }

                    $stmt->close();
                    $conn->close();
                }

                else if(isset($_GET['editing']))
                {
                    $query = "UPDATE $table SET
                    Province = ?,
                    District = ?,
                    Subdistrict = ?,
                    Address = ?,
                    GoogleMap = ? 
                    WHERE ID = ?";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssssi", $province, $district, $subdistrict, $address, $googleMap, $id); 

                    if ($stmt->execute()) {
                        echo "<script>window.location.href = '" . $RedirectURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . "';</script>";
                        exit();
                    } else {
                        echo "Gagal mengedit user: " . $stmt->error;
                    } 

                    $stmt->close();
                    $conn->close();
                }
                }
                else {
                $title = null;

                // Configure your Datas here ---------------------------
                $dataProvince = null;
                $dataDistrict = null;
                $dataSubdistrict = null;
                $dataAddress = null;
                $dataGoogleMap = null;

                if(isset($_GET['add']))
                {
                    $title = "Add";
                }
                else if(isset($_GET['edit'])&&isset($_GET['id']))
                {
                    $title = "Edit";
                    $id = $_GET['id'];

                    $database = mysqli_query($conn, "SELECT * FROM $table WHERE ID = '$id'");
                    $datas = $database->fetch_assoc();

                    // Configure your Datas here ---------------------------
                    $dataProvince = $datas['Province'];
                    $dataDistrict = $datas['District'];
                    $dataSubdistrict = $datas['Subdistrict'];
                    $dataAddress = $datas['Address'];
                    $dataGoogleMap = $datas['GoogleMap'];
                }
                else if(isset($_GET['delete']) && isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $query = mysqli_query($conn, "DELETE FROM $table WHERE ID = '$id'");
                    echo "<script>window.location.href = '" . $RedirectURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . "';</script>";
                }
                ?>
                <div class="developer-original-form-add">
                <h1><?= $title ?> Data</h1><br>
                <form action="<?= $title == 'Edit' ? $ThisURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . "&editing&id=" . $id : $ThisURL ?>" method="post" enctype="multipart/form-data">
                    <div class="content">
                        <div>
                            <span>Provinsi</span>
                            <span>Kota / Kabupaten</span>
                            <span>Kecamatan</span>
                            <span>Address</span>
                            <span>Google Map</span>
                        </div>
                        <div>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                        </div>
                        <div>
                            <input type="hidden" name="Add" value="<?= $title == 'Edit' ? '' : 'Add' ?>" required>
                            <input type="text" placeholder="Province" name="Province" value="<?= $title == 'Edit' ? $dataProvince : '' ?>" required>
                            <input type="text" placeholder="District" name="District" value="<?= $title == 'Edit' ? $dataDistrict : '' ?>" required>
                            <input type="text" placeholder="Subdistrict" name="Subdistrict" value="<?= $title == 'Edit' ? $dataSubdistrict : '' ?>" required>
                            <input type="text" placeholder="Address" name="Address" value="<?= $title == 'Edit' ? $dataAddress : '' ?>" required>
                            <input type="text" placeholder="Masukkan link google map di sini" name="GoogleMap" value="<?= $title == 'Edit' ? $dataGoogleMap : '' ?>" required>
                        </div>
                    </div>

                    <div class="decision">
                        <div>
                            <a href="<?= $RedirectURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch ?>">Kembali</a>     
                            <input type="submit" value="<?= $title ?>"></input>
                        </div>
                    </div>
                </form>
                </div>

                <div class="developer-original-blackbarrier hidden"></div>

                <div class="developer-original-modal-confirm hidden">
                <p>Pastikan format gambar adalah JPG, JPEG, atau PNG</p>
                <button>Oke</button>
                </div>

                <div class="developer-original-modal-confirm-02 hidden">
                <p>Harap untuk memilih gambar terlebih dahulu.</p>
                <button>Oke</button>
                </div>

                <div class="developer-original-modal-image hidden">
                <img src="<?= $title == 'Edit' ? $dataAddress : '' ?>">
                </div>

                <div class="developer-original-modal-no-image hidden">
                <p>Data tidak memiliki gambar</p>
                <button>Oke😢</button>
                </div>
                <?php } ?>   
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <?php include "../../template/javascipts.php"; ?>
    <script src = "../javascript/pagination.js"></script>
</body>

</html>