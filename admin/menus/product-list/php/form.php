<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Product Data</title>

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
                $ImageURL = "../../../../database/admin/image/product/";
                $table = "tbl_admin_product";

                $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
                $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
                $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
                $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
                $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $add = htmlspecialchars($_POST['Add']);
                $id = isset($_GET['id']) ? $_GET['id'] : null;

                // Configuration --------------------------
                $status = htmlspecialchars($_POST['Status']);
                $name = htmlspecialchars($_POST['Name']);
                $description = htmlspecialchars($_POST['Description']);
                $pricePartner = "Rp" . htmlspecialchars($_POST['PricePartner']);
                $priceAdmin = "Rp" . htmlspecialchars($_POST['PriceAdmin']);
                $price = "Rp" . number_format((int) str_replace('.', '', $_POST['PricePartner']) + (int) str_replace('.', '', $_POST['PriceAdmin']), 0, ',', '.');
                $tags = htmlspecialchars($_POST['Parent']) != "null" ? "ParentID(" . htmlspecialchars($_POST['Parent']) . ")" : htmlspecialchars($_POST['Tags']);
                $lastEditor = $_SESSION['Username'];
                $image = null;
                $background = null;

                echo $price;
                
                // Hapus block If ini jika tidak memiliki gambar -------------------------------------
                if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
                    $targetDir = $ImageURL;
                    $fileName = basename($_FILES["Image"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                    $allowedTypes = ['jpg', 'jpeg', 'png'];
                    if (!in_array($imageFileType, $allowedTypes)) {
                        die("Format gambar tidak valid. Hanya JPG, JPEG, dan PNG diperbolehkan.");
                    }

                    if (move_uploaded_file($_FILES["Image"]["tmp_name"], $targetFilePath)) {
                        $image = $targetFilePath;
                    } else {
                        die("Gagal mengunggah gambar.");
                    }
                } else {
                    if(isset($_GET['editing']))
                    {
                        // Perhatikan kode di bawah ini. Kode ini adalah untuk tetap mempertahankan gambar ketika edit meski user tidak memilih gambar lagi. Sebelumnya, jika user tidak memilih gambar ketika edit, maka gambar yang lama akan hilang.
                        if(str_contains($_POST['ImageEdit'], "/")){ $image = $_POST['ImageEdit']; }
                        else { $image = "../../../../database/admin/image/product/Default.png"; }
                    }
                    else{ $image = "../../../../database/admin/image/product/Default.png"; }
                }

                if (isset($_FILES['Background']) && $_FILES['Background']['error'] == 0) {
                    $targetDir = $ImageURL;
                    $fileName = basename($_FILES["Background"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                    $allowedTypes = ['jpg', 'jpeg', 'png'];
                    if (!in_array($imageFileType, $allowedTypes)) {
                        die("Format gambar tidak valid. Hanya JPG, JPEG, dan PNG diperbolehkan.");
                    }

                    if (move_uploaded_file($_FILES["Background"]["tmp_name"], $targetFilePath)) {
                        $background = $targetFilePath;
                    } else {
                        die("Gagal mengunggah gambar.");
                    }
                } else {
                    if(isset($_GET['editing']))
                    {
                        // Perhatikan kode di bawah ini. Kode ini adalah untuk tetap mempertahankan gambar ketika edit meski user tidak memilih gambar lagi. Sebelumnya, jika user tidak memilih gambar ketika edit, maka gambar yang lama akan hilang.
                        if(str_contains($_POST['BackgroundEdit'], "/")){ $background = $_POST['BackgroundEdit']; }
                        else { $background = "../../../../database/admin/image/product/Background-Default.jpg"; }
                    }
                    else{ $background = "../../../../database/admin/image/product/Background-Default.jpg"; }
                }
                // End If

                if($add == "Add")
                {
                    $query = "INSERT INTO $table (
                    Status,
                    Name,
                    Description,
                    PricePartner,
                    PriceAdmin,
                    Price,
                    Tags,
                    LastEditor,
                    Image,
                    Background)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssssssssss", $status, $name, $description, $pricePartner, $priceAdmin, $price, $tags, $lastEditor, $image, $background);

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
                    Status = ?,
                    Name = ?,
                    Description = ?,
                    PricePartner = ?,
                    PriceAdmin = ?,
                    Price = ?,
                    Tags = ?,
                    LastEditor = ?,
                    Image = ?,
                    Background = ? 
                    WHERE ID = ?";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssssssssssi", $status, $name, $description, $pricePartner, $priceAdmin, $price, $tags, $lastEditor, $image, $background, $id);

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
                $dataStatus = null;
                $dataName = null;
                $dataDescription = null;
                $dataPricePartner = null;
                $dataPriceAdmin = null;
                $dataTags = null;
                $dataLastEditor = null;
                $dataImage = null;
                $dataBackground = null;

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
                    $dataStatus = $datas['Status']; 
                    $dataName = $datas['Name'];
                    $dataDescription = $datas['Description'];
                    $dataPricePartner = str_replace("Rp", "", $datas['PricePartner']);
                    $dataPriceAdmin = str_replace("Rp", "", $datas['PriceAdmin']);
                    $dataTags = $datas['Tags'];
                    $dataLastEditor = $datas['LastEditor'];
                    $dataImage = $datas['Image'];
                    $dataBackground = $datas['Background'];
                    $dataTotalPrice = str_replace("Rp", "", $datas['Price']);
                    $dataParent = str_contains($dataTags, "ParentID(") ? str_replace(["ParentID(", ")"], "", $dataTags) : null;
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
                            <span>Status</span>
                            <span>Parent</span>
                            <span>Name</span>
                            <span>Description</span>
                            <span>Price Partner</span>
                            <span>Price Admin</span>
                            <span>Tags</span>
                            <?= $title == 'Edit' ? '<span>LastEditor</span>' : '' ?>
                            <span>Image</span>
                            <span>Background</span>
                        </div>
                        <div>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <?= $title == 'Edit' ? '<span>:</span>' : '' ?>
                            <span>:</span>
                            <span>:</span>
                        </div>
                        <div>
                            <input type="hidden" name="Add" value="<?= $title == 'Edit' ? '' : 'Add' ?>" required>
                            <select name="Status" id="StatusSelect">
                                <!-- Configure your select value -->
                                <option value="<?= $selectvalue = 'Main' ?>" <?= $title == 'Edit' && $dataStatus == $selectvalue ? 'selected' : '' ?>><?= $selectvalue ?></option>
                                <option value="<?= $selectvalue = 'Secondary' ?>" <?= $title == 'Edit' && $dataStatus == $selectvalue ? 'selected' : '' ?>><?= $selectvalue ?></option>
                            </select>
                            <select name="Parent" id="ParentSelect" <?= $title == 'Edit' && $dataStatus == 'Secondary' ? '' : 'disabled' ?>>
                                <!-- Configure your select value -->
                                 <option value="null" selected disabled>Pilih kategori utama</option>
                                 <?php 
                                    $parents = mysqli_query($conn, "SELECT ID, Name FROM tbl_admin_product WHERE Status = 'Main'");
                                    while($row = mysqli_fetch_assoc($parents)){
                                 ?>
                                    <option value="<?= $row['ID'] ?>" <?= $title == 'Edit' && $dataParent == $row['ID'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                <?php } ?>
                            </select>
                            <input type="text" placeholder="Name" name="Name" value="<?= $title == 'Edit' ? $dataName : '' ?>" required>
                            <input type="text" placeholder="Description" name="Description" value="<?= $title == 'Edit' ? $dataDescription : '' ?>" required>
                            <span class="money"><span>RP</span><input type="text" placeholder="PricePartner" name="PricePartner" value="<?= $title == 'Edit' ? $dataPricePartner : '' ?>" required></span>
                            <span class="money"><span>RP</span><input type="text" placeholder="PriceAdmin" name="PriceAdmin" value="<?= $title == 'Edit' ? $dataPriceAdmin : '' ?>" required></span>
                            <input type="text" placeholder="Berikan kata kunci prediksi yang akan sering dicari oleh customer" name="Tags" value="<?= $title == 'Edit' ? $dataTags : '' ?>" <?= $title == 'Edit' && $dataStatus == 'Secondary' ? 'readonly': '' ?> id="TagsInput">
                            <input type="<?= $title == 'Edit' ? 'text' : 'hidden' ?>" placeholder="LastEditor" name="LastEditor" value="<?= $title == 'Edit' ? $dataLastEditor : '' ?>" readonly>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm" name="Image">
                                <input type="file" name="Image">
                                <input type="button" value="Show Image" class="ShowImageForm" name="Image" required>
                                <input type="hidden" name="ImageEdit" value="<?= $title == 'Edit' ? $dataImage : '' ?>">
                            </span>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Two" name="Background">
                                <input type="file" name="Background">
                                <input type="button" value="Show Image" class="ShowImageForm Two" name="Background" required>
                                <input type="hidden" name="BackgroundEdit" value="<?= $title == 'Edit' ? $dataBackground : '' ?>">
                            </span>
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
                <img src="<?= $title == 'Edit' ? $dataImage : '' ?>">
                </div>

                <div class="developer-original-modal-image-02 hidden">
                <img src="<?= $title == 'Edit' ? $dataBackground : '' ?>">
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