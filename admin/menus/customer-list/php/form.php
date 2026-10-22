<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Customer Data</title>

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
                $ImageURL = "../../../../database/customer/image/profile/";
                $table = "tbl_customers";

                $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
                $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
                $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
                $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
                $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $add = htmlspecialchars($_POST['Add']);
                $id = isset($_GET['id']) ? $_GET['id'] : null;

                // Configuration --------------------------
                $username = htmlspecialchars($_POST['Username']);
                $email = htmlspecialchars($_POST['Email']);
                $phoneNumber = htmlspecialchars($_POST['PhoneNumber']);
                $province = htmlspecialchars($_POST['Province']);
                $district = htmlspecialchars($_POST['District']);
                $subdistrict = htmlspecialchars($_POST['Subdistrict']);
                $address = htmlspecialchars($_POST['Address']);
                $image = null;

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
                        else { $image = "-"; }
                    }
                    else{ $image = "-"; }
                }
                // End If

                if($add == "Add")
                {
                    $password = password_hash(htmlspecialchars($_POST['Password']), PASSWORD_DEFAULT);

                    $query = "INSERT INTO $table (
                    Username,
                    Password,
                    Email,
                    PhoneNumber,
                    Province,
                    District,
                    Subdistrict,
                    Address,
                    Image)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssssssss", $username, $password, $email, $phoneNumber, $province, $district, $subdistrict, $address, $image);

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
                    $dataOldPassword = mysqli_query($conn, "SELECT Password FROM tbl_customers WHERE ID = '$id'");
                    $dataOldPassword = mysqli_fetch_assoc($dataOldPassword)['Password'];
                    $password = htmlspecialchars($_POST['Password']) == $dataOldPassword ? $dataOldPassword : password_hash(htmlspecialchars($_POST['Password']), PASSWORD_DEFAULT);

                    $query = "UPDATE $table SET
                    Username = ?,
                    Password = ?,
                    Email = ?,
                    PhoneNumber = ?,
                    Province = ?,
                    District = ?,
                    Subdistrict = ?,
                    Address = ?,
                    Image = ? 
                    WHERE ID = ?";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssssssssi", $username, $password, $email, $phoneNumber, $province, $district, $subdistrict, $address, $image, $id); 

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
                $dataUsername = null;
                $dataPassword = null;
                $dataEmail = null;
                $dataPhoneNumber = null;
                $dataProvince = null;
                $dataDistrict = null;
                $dataSubdistrict = null;
                $dataAddress = null;
                $dataImage = null;

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
                    $dataUsername = $datas['Username']; 
                    $dataPassword = $datas['Password'];
                    $dataEmail = $datas['Email'];
                    $dataPhoneNumber = $datas['PhoneNumber'];
                    $dataProvince = $datas['Province'];
                    $dataDistrict = $datas['District'];
                    $dataSubdistrict = $datas['Subdistrict'];
                    $dataAddress = $datas['Address'];
                    $dataImage = $datas['Image'];
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
                            <span>Foto Profil</span>
                            <span>Username</span>
                            <span>Password</span>
                            <span>Email</span>
                            <span>Phone Number</span>
                            <span>Provinsi</span>
                            <span>Kota/Kabupaten</span>
                            <span>Kecamatan</span>
                            <span>Alamat</span>
                        </div>
                        <div>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                        </div>
                        <div>
                            <input type="hidden" name="Add" value="<?= $title == 'Edit' ? '' : 'Add' ?>" required>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm" name="Image">
                                <input type="file" name="Image">
                                <input type="button" value="Show Image" class="ShowImageForm" name="Image" required>
                                <input type="hidden" name="ImageEdit" value="<?= $title == 'Edit' ? $dataImage : '' ?>">
                            </span>
                            <input type="text" placeholder="Username" name="Username" value="<?= $title == 'Edit' ? $dataUsername : '' ?>" required>
                            <input type="text" placeholder="Password" name="Password" value="<?= $title == 'Edit' ? $dataPassword : '' ?>" required>
                            <input type="text" placeholder="Email" name="Email" value="<?= $title == 'Edit' ? $dataEmail : '' ?>" required>
                            <input type="text" placeholder="PhoneNumber" name="PhoneNumber" value="<?= $title == 'Edit' ? $dataPhoneNumber : '' ?>" required>
                            <input type="text" placeholder="Province" name="Province" value="<?= $title == 'Edit' ? $dataProvince : '' ?>" required>
                            <input type="text" placeholder="District" name="District" value="<?= $title == 'Edit' ? $dataDistrict : '' ?>" required>
                            <input type="text" placeholder="Subdistrict" name="Subdistrict" value="<?= $title == 'Edit' ? $dataSubdistrict : '' ?>" required>
                            <input type="text" placeholder="Address" name="Address" value="<?= $title == 'Edit' ? $dataAddress : '' ?>" required>
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
                <img src="<?= $title == 'Edit' ? $dataImageCard : '' ?>">
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