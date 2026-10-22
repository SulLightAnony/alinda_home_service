<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Transaction Detail</title>

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
                $table = "tbl_transaction";

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
                $password = htmlspecialchars($_POST['Password']);
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
                $dataCode = null;
                $dataCustomerUsername = null;
                $dataCustomerEmail = null;
                $dataCustomerPhoneNumber = null;
                $dataCustomerProvince = null;
                $dataCustomerDistrict = null;
                $dataCustomerSubdistrict = null;
                $dataCustomerAddress = null;
                $dataCustomerImage = null;
                $dataCustomerImageProve = null;
                $dataCustomerOrderTimestamp = null;
                $dataCustomerRepairDetail = null;
                $dataProductName = null;
                $dataProductStatus = null;
                $dataProductPrice = null;
                $dataProductImage = null;
                $dataProductDetail = null;
                $dataPartnerID = null;
                $dataPartnerUsername = null;
                $dataPartnerEmail = null;
                $dataPartnerPhoneNumber = null;
                $dataPartnerProvince = null;
                $dataPartnerDistrict = null;
                $dataPartnerSubdistrict = null;
                $dataPartnerAddress = null;
                $dataPartnerImage = null;
                $dataPartnerAccountNumber = null;
                $dataPartnerAgreedTimestamp = null;
                $dataPartnerFinishedTimestamp = null;
                $dataPartnerFinishedImageProve = null;
                $dataPartnerRejectedEmail = null;
                $dataPartnerRejectedReason = null;
                $dataPartnerRejectedTimestamp = null;
                $dataPartnerCanceledEmail = null;
                $dataPartnerCanceledReason = null;
                $dataPartnerCanceledImageProve = null;
                $dataPartnerCanceledTimestamp = null;
                $dataPartnerPrice = null;
                $dataAdminPrice = null;
                $dataStatus = null;
                $dataStatusPayment = null;
                $dataStatusPaymentImageProve = null;
                $dataStatusCanceledFrom = null;
                $dataStatusCanceledTimestamp = null;
                $dataStatusCanceledReason = null;
                $dataStatusRejectedReason = null;
                $dataDate = null;
                $dataDateExpired = null;


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
                    $dataCode = $datas['Code'];
                    $dataCustomerUsername = $datas['CustomerUsername'];
                    $dataCustomerEmail = $datas['CustomerEmail'];
                    $dataCustomerPhoneNumber = $datas['CustomerPhoneNumber'];
                    $dataCustomerProvince = $datas['CustomerProvince'];
                    $dataCustomerDistrict = $datas['CustomerDistrict'];
                    $dataCustomerSubdistrict = $datas['CustomerSubdistrict'];
                    $dataCustomerAddress = $datas['CustomerAddress'];
                    $dataCustomerImage = $datas['CustomerImage'];
                    $dataCustomerImageProve = $datas['CustomerImageProve'];
                    $dataCustomerOrderTimestamp = $datas['CustomerOrderTimestamp'];
                    $dataCustomerRepairDetail = $datas['CustomerRepairDetail'];
                    $dataProductName = $datas['ProductName'];
                    $dataProductStatus = $datas['ProductStatus'];
                    $dataProductPrice = str_replace("Rp", "", $datas['ProductPrice']);;
                    $dataProductImage = $datas['ProductImage'];
                    $dataProductDetail = $datas['ProductDetail'];
                    $dataPartnerID = $datas['PartnerID'];
                    $dataPartnerUsername = $datas['PartnerUsername'];
                    $dataPartnerEmail = $datas['PartnerEmail'];
                    $dataPartnerPhoneNumber = $datas['PartnerPhoneNumber'];
                    $dataPartnerProvince = $datas['PartnerProvince'];
                    $dataPartnerDistrict = $datas['PartnerDistrict'];
                    $dataPartnerSubdistrict = $datas['PartnerSubdistrict'];
                    $dataPartnerAddress = $datas['PartnerAddress'];
                    $dataPartnerImage = $datas['PartnerImage'];
                    $dataPartnerAccountNumber = $datas['PartnerAccountNumber'];
                    $dataPartnerAgreedTimestamp = $datas['PartnerAgreedTimestamp'];
                    $dataPartnerFinishedTimestamp = $datas['PartnerFinishedTimestamp'];
                    $dataPartnerFinishedImageProve = $datas['PartnerFinishedImageProve'];
                    $dataPartnerRejectedEmail = $datas['PartnerRejectedEmail'];
                    $dataPartnerRejectedReason = $datas['PartnerRejectedReason'];
                    $dataPartnerRejectedTimestamp = $datas['PartnerRejectedTimestamp'];
                    $dataPartnerCanceledEmail = $datas['PartnerCanceledEmail'];
                    $dataPartnerCanceledReason = $datas['PartnerCanceledReason'];
                    $dataPartnerCanceledImageProve = $datas['PartnerCanceledImageProve'];
                    $dataPartnerCanceledTimestamp = $datas['PartnerCanceledTimestamp'];
                    $dataPartnerPrice = str_replace("Rp", "", $datas['PartnerPrice']);;
                    $dataAdminPrice = str_replace("Rp", "", $datas['AdminPrice']);;
                    $dataStatus = $datas['Status'];
                    $dataStatusPayment = $datas['StatusPayment'];
                    $dataStatusPaymentImageProve = $datas['StatusPaymentImageProve'];
                    $dataStatusCanceledFrom = $datas['StatusCanceledFrom'];
                    $dataStatusCanceledTimestamp = $datas['StatusCanceledTimestamp'];
                    $dataStatusCanceledReason = $datas['StatusCanceledReason'];
                    $dataStatusRejectedReason = $datas['StatusRejectedReason'];
                    $dataDate = $datas['Date'];
                    $dataDateExpired = $datas['DateExpired'];
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
                            <span>Code</span>
                            <span>Customer Username</span>
                            <span>Customer Email</span>
                            <span>Customer Phone Number</span>
                            <span>Customer Province</span>
                            <span>Customer District</span>
                            <span>Customer Subdistrict</span>
                            <span>Customer Address</span>
                            <span>Customer Image</span>
                            <span>Customer Image Prove</span>
                            <span>Customer Order Timestamp</span>
                            <span>Customer Detail</span>
                            <span>Product Name</span>
                            <span>Product Price</span>
                            <span>Product Image</span>
                            <span>Product Detail</span>
                            <span>Partner ID</span>
                            <span>Partner Username</span>
                            <span>Partner Email</span>
                            <span>Partner Phone Number</span>
                            <span>Partner Province</span>
                            <span>Partner District</span>
                            <span>Partner Subdistrict</span>
                            <span>Partner Address</span>
                            <span>Partner Image</span>
                            <span>Partner Account Number</span>
                            <span>Partner Agreed Timestamp</span>
                            <span>Partner Finished Timestamp</span>
                            <span>Partner Finished Image Prove</span>
                            <span>Partner Rejected</span>
                            <span>Partner Canceled</span>
                            <span>Partner Price</span>
                            <span>Admin Price</span>
                            <span>Status</span>
                            <span>Status Payment</span>
                            <span>Status Payment Image Prove</span>
                            <span>Status Canceled From</span>
                            <span>Status Canceled Timestamp</span>
                            <span>Status Canceled Reason</span>
                            <span>Status Rejected Reason</span>
                            <span>Date</span>
                            <span>Date Expired</span>
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
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
                            <span>:</span>
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
                            <input type="text" placeholder="Code" name="Code" value="<?= $title == 'Edit' ? $dataCode : '' ?>" readonly>
                            <input type="text" placeholder="CustomerUsername" name="CustomerUsername" value="<?= $title == 'Edit' ? $dataCustomerUsername : '' ?>" readonly>
                            <input type="text" placeholder="CustomerEmail" name="CustomerEmail" value="<?= $title == 'Edit' ? $dataCustomerEmail : '' ?>" readonly>
                            <input type="text" placeholder="CustomerPhoneNumber" name="CustomerPhoneNumber" value="<?= $title == 'Edit' ? $dataCustomerPhoneNumber : '' ?>" readonly>
                            <input type="text" placeholder="CustomerProvince" name="CustomerProvince" value="<?= $title == 'Edit' ? $dataCustomerProvince : '' ?>" readonly>
                            <input type="text" placeholder="CustomerDistrict" name="CustomerDistrict" value="<?= $title == 'Edit' ? $dataCustomerDistrict : '' ?>" readonly>
                            <input type="text" placeholder="CustomerSubdistrict" name="CustomerSubdistrict" value="<?= $title == 'Edit' ? $dataCustomerSubdistrict : '' ?>" readonly>
                            <input type="text" placeholder="CustomerAddress" name="CustomerAddress" value="<?= $title == 'Edit' ? $dataCustomerAddress : '' ?>" readonly>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm" name="CustomerImage" disabled>
                                <input type="file" name="CustomerImage">
                                <input type="button" value="Show Image" class="ShowImageForm" name="CustomerImage">
                            </span>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Two" name="CustomerImageProve" disabled>
                                <input type="file" name="CustomerImageProve">
                                <input type="button" value="Show Image" class="ShowImageForm Two" name="CustomerImageProve">
                            </span>
                            <input type="text" placeholder="CustomerOrderTimestamp" name="CustomerOrderTimestamp" value="<?= $title == 'Edit' ? $dataCustomerOrderTimestamp : '' ?>" readonly>
                            <input type="text" placeholder="CustomerDetail" name="CustomerDetail" value="<?= $title == 'Edit' ? $dataCustomerRepairDetail : '' ?>" readonly>
                            <input type="text" placeholder="ProductName" name="ProductName" value="<?= $title == 'Edit' ? $dataProductName : '' ?>" readonly>
                            <span class="money"><span>RP</span><input type="text" placeholder="ProductPrice" name="ProductPrice" value="<?= $title == 'Edit' ? $dataProductPrice : '' ?>" readonly></span>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Three" name="ProductImage" disabled>
                                <input type="file" name="ProductImage">
                                <input type="button" value="Show Image" class="ShowImageForm Three" name="ProductImage">
                            </span>
                            <input type="text" placeholder="ProductDetail" name="ProductDetail" value="<?= $title == 'Edit' ? $dataProductDetail : '' ?>" readonly>
                            <input type="text" placeholder="PartnerID" name="PartnerID" value="<?= $title == 'Edit' ? $dataPartnerID : '' ?>" readonly>
                            <input type="text" placeholder="PartnerUsername" name="PartnerUsername" value="<?= $title == 'Edit' ? $dataPartnerUsername : '' ?>" readonly>
                            <input type="text" placeholder="PartnerEmail" name="PartnerEmail" value="<?= $title == 'Edit' ? $dataPartnerEmail : '' ?>" readonly>
                            <input type="text" placeholder="PartnerPhoneNumber" name="PartnerPhoneNumber" value="<?= $title == 'Edit' ? $dataPartnerPhoneNumber : '' ?>" readonly>
                            <input type="text" placeholder="PartnerProvince" name="PartnerProvince" value="<?= $title == 'Edit' ? $dataPartnerProvince : '' ?>" readonly>
                            <input type="text" placeholder="PartnerDistrict" name="PartnerDistrict" value="<?= $title == 'Edit' ? $dataPartnerDistrict : '' ?>" readonly>
                            <input type="text" placeholder="PartnerSubdistrict" name="PartnerSubdistrict" value="<?= $title == 'Edit' ? $dataPartnerSubdistrict : '' ?>" readonly>
                            <input type="text" placeholder="PartnerAddress" name="PartnerAddress" value="<?= $title == 'Edit' ? $dataPartnerAddress : '' ?>" readonly>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Four" name="PartnerImage" disabled>
                                <input type="file" name="PartnerImage">
                                <input type="button" value="Show Image" class="ShowImageForm Four" name="PartnerImage">
                            </span>
                            <input type="text" placeholder="PartnerAccountNumber" name="PartnerAccountNumber" value="<?= $title == 'Edit' ? $dataPartnerAccountNumber : '' ?>" readonly>
                            <input type="text" placeholder="PartnerAgreedTimestamp" name="PartnerAgreedTimestamp" value="<?= $title == 'Edit' ? $dataPartnerAgreedTimestamp : '' ?>" readonly>
                            <input type="text" placeholder="PartnerFinishedTimestamp" name="PartnerFinishedTimestamp" value="<?= $title == 'Edit' ? $dataPartnerFinishedTimestamp : '' ?>" readonly>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Five" name="PartnerFinishedImageProve" disabled>
                                <input type="file" name="PartnerFinishedImageProve">
                                <input type="button" value="Show Image" class="ShowImageForm Five" name="PartnerFinishedImageProve">
                            </span>
                            <a href="rejected.php<?= $IndexPage . "&ID=" . $id . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch ?>"><input type="button" value="<?= $title == 'Edit' ? 'Lihat mitra yang menolak transaksi' : '' ?>" style="background: white;"></a>
                            <a href="canceled.php<?= $IndexPage . "&ID=" . $id . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch ?>"><input type="button" value="<?= $title == 'Edit' ? 'Lihat mitra yang membatalkan transaksi' : '' ?>" style="background: white;"></a>
                            <span class="money"><span>RP</span><input type="text" placeholder="PartnerPrice" name="PartnerPrice" value="<?= $title == 'Edit' ? $dataPartnerPrice : '' ?>" readonly></span>
                            <span class="money"><span>RP</span><input type="text" placeholder="AdminPrice" name="AdminPrice" value="<?= $title == 'Edit' ? $dataAdminPrice : '' ?>" readonly></span>
                            <input type="text" placeholder="Status" name="Status" value="<?= $title == 'Edit' ? $dataStatus : '' ?>" readonly>
                            <input type="text" placeholder="StatusPayment" name="StatusPayment" value="<?= $title == 'Edit' ? $dataStatusPayment : '' ?>" readonly>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Six" name="StatusPaymentImageProve" disabled>
                                <input type="file" name="StatusPaymentImageProve">
                                <input type="button" value="Show Image" class="ShowImageForm Six" name="StatusPaymentImageProve">
                            </span>
                            <input type="text" placeholder="StatusCanceledFrom" name="StatusCanceledFrom" value="<?= $title == 'Edit' ? $dataStatusCanceledFrom : '' ?>" readonly>
                            <input type="text" placeholder="StatusCanceledTimestamp" name="StatusCanceledTimestamp" value="<?= $title == 'Edit' ? $dataStatusCanceledTimestamp : '' ?>" readonly>
                            <input type="text" placeholder="StatusCanceledReason" name="StatusCanceledReason" value="<?= $title == 'Edit' ? $dataStatusCanceledReason : '' ?>" readonly>
                            <input type="text" placeholder="StatusRejectedReason" name="StatusRejectedReason" value="<?= $title == 'Edit' ? $dataStatusRejectedReason : '' ?>" readonly>
                            <input type="text" placeholder="Date" name="Date" value="<?= $title == 'Edit' ? $dataDate : '' ?>" readonly>
                            <input type="text" placeholder="DateExpired" name="DateExpired" value="<?= $title == 'Edit' ? $dataDateExpired : '' ?>" readonly>
                        </div>
                    </div>

                    <div class="decision">
                        <div>
                            <a href="<?= $RedirectURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch ?>">Kembali</a>     
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
                <img src="<?= $title == 'Edit' ? $dataCustomerImage : '' ?>">
                </div>

                <div class="developer-original-modal-image-02 hidden">
                <img src="<?= $title == 'Edit' ? $dataCustomerImageProve : '' ?>">
                </div>

                <div class="developer-original-modal-image-03 hidden">
                <img src="<?= $title == 'Edit' ? $dataProductImage : '' ?>">
                </div>

                <div class="developer-original-modal-image-04 hidden">
                <img src="<?= $title == 'Edit' ? $dataPartnerImage : '' ?>">
                </div>

                <div class="developer-original-modal-image-05 hidden">
                <img src="<?= $title == 'Edit' ? $dataPartnerFinishedImageProve : '' ?>">
                </div>

                <div class="developer-original-modal-image-06 hidden">
                <img src="<?= $title == 'Edit' ? $dataStatusPaymentImageProve : '' ?>">
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