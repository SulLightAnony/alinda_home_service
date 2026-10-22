<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Admin Customer Service</title>

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
                $table = "tbl_admin_customer_service";

                $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
                $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
                $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
                $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
                $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $add = htmlspecialchars($_POST['Add']);
                $id = isset($_GET['id']) ? $_GET['id'] : null;

                // Configuration --------------------------
                $name = htmlspecialchars($_POST['Name']);
                $phoneNumber = htmlspecialchars($_POST['PhoneNumber']);

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
                    $image = "No profile Image!";
                }
                // End If

                if($add == "Add")
                {
                    $query = "INSERT INTO $table (
                    Name,
                    PhoneNumber,
                    Image)
                    VALUES (?, ?, ?)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sss", $name, $phoneNumber, $image);

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
                    Name = ?,
                    PhoneNumber = ?,
                    Image = ?
                    WHERE ID = ?";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssi", $name, $phoneNumber, $image, $id); 

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
                $dataName = null;
                $dataPhoneNumber = null;
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
                    $dataName = $datas['Name'];
                    $dataPhoneNumber = $datas['PhoneNumber'];
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
                            <span>Name</span>
                            <span>PhoneNumber</span>
                            <span>Image</span>
                        </div>
                        <div>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                        </div>
                        <div>
                            <input type="hidden" name="Add" value="<?= $title == 'Edit' ? '' : 'Add' ?>" required>
                            <input type="text" placeholder="Name" name="Name" value="<?= $title == 'Edit' ? $dataName : '' ?>" required>
                            <input type="text" placeholder="PhoneNumber" name="PhoneNumber" value="<?= $title == 'Edit' ? $dataPhoneNumber : '' ?>" required>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm" required>
                                <input type="file" name="Image">
                                <input type="button" value="Show Image" class="ShowImageForm" required>
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