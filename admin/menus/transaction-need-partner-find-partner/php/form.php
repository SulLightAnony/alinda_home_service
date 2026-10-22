<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Partner Data</title>

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
                $ImageURL = "../../../../database/partner/image/";
                $table = "tbl_partners";

                $IndexPage = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
                $IndexSearch = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
                $IndexFilter = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
                $IndexSort = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
                $IndexDateSearch = isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;
                $transactionID = "&TransactionID=" . $_GET['TransactionID']; echo "<script>let transactionID = '&TransactionID=" . $_GET['TransactionID'] . "';</script>";
                $transactionIDOnly = $_GET['TransactionID'];
                $transactionPage = "&TransactionPage=" . $_GET['TransactionPage']; echo "<script>let transactionPage = '&TransactionPage=" . $_GET['TransactionPage'] . "';</script>";                
                $transactionProduct = "&TransactionProduct=" . $_GET['TransactionProduct']; echo "<script>let transactionProduct = '&TransactionProduct=" . $_GET['TransactionProduct'] . "';</script>";

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
                $accountNumber = htmlspecialchars($_POST['AccountNumber']);
                $identificationNumber = htmlspecialchars($_POST['IdentificationNumber']);
                $registerDate = htmlspecialchars($_POST['RegisterDate']);
                $statusApproval = htmlspecialchars($_POST['StatusApproval']);
                $approvalDate = $_POST['StatusApproval'] == "Belum dikonfirmasi" ? "" : htmlspecialchars($_POST['ApprovalDate']);
                $status = htmlspecialchars($_POST['Status']);
                $image = $_POST['ImageEdit'];
                $imageCard = $_POST['ImageCardEdit'];
                $transactionStatus = null;

                $transaction = mysqli_query($conn, "SELECT Status FROM tbl_transaction WHERE ID ='$transactionIDOnly'");
                $transaction = mysqli_fetch_assoc($transaction);
                $transactionStatus = $transaction['Status'] == "Menunggu konfirmasi mitra." ? "Menunggu konfirmasi mitra" : "Transaksi dibatalkan oleh mitra. Menunggu konfirmasi mitra baru";

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
                    AccountNumber,
                    IdentificationNumber,
                    RegisterDate,
                    StatusApproval,
                    ApprovalDate,
                    Status,
                    Image,
                    ImageCard)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssssssssssssssss", $username, $password, $email, $phoneNumber, $province, $district, $subdistrict, $address, $accountNumber, $identificationNumber, $registerDate, $statusApproval, $approvalDate, $status, $image, $imageCard);

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
                    $partnerUpdate = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
                    $partnerStatus = "Sedang tidak dapat melayani";
                    $partnerUpdate->bind_param("ss", $partnerStatus, $email);
                    $partnerUpdate->execute();
                    $partnerUpdate->close();
                    $_SESSION['StatusPartner'] = "Sedang tidak dapat melayani";

                    $query = "UPDATE tbl_transaction SET
                    PartnerID = ?,
                    PartnerUsername = ?, 
                    PartnerEmail = ?,
                    Status = ?  
                    WHERE ID = ?";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssssi", $id, $username, $email, $transactionStatus, $transactionIDOnly); 

                    if ($stmt->execute()) {
                        echo "<script>window.location.href = '../../transaction-need-partner/php/index.php?page=" . $_GET['TransactionPage'] . "';</script>";
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
                $dataAccountNumber = null;
                $dataIdentificationNumber = null;
                $dataRegisterDate = null;
                $dataStatusApproval = null;
                $dataApprovalDate = null;
                $dataStatus = null;
                $dataImage = null;
                $dataImageCard = null;

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
                    $dataAccountNumber = $datas['AccountNumber'];
                    $dataIdentificationNumber = $datas['IdentificationNumber'];
                    $dataRegisterDate = $datas['RegisterDate'];
                    $dataStatusApproval = $datas['StatusApproval'];
                    $dataApprovalDate = $datas['ApprovalDate'];
                    $dataStatus = $datas['Status'];
                    $dataImage = $datas['Image'];
                    $dataImageCard = $datas['ImageCard'];
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
                <form action="<?= $title == 'Edit' ? $ThisURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . "&editing&id=" . $id . $transactionID . $transactionPage : $ThisURL ?>" method="post" enctype="multipart/form-data">
                    <div class="content">
                        <div>
                            <span>Foto Profil</span>
                            <span>Username</span>
                            <span>Password</span>
                            <span>Email</span>
                            <span>Phone Number</span>
                            <span>Provinsi</span>
                            <span>Kecamatan</span>
                            <span>Kelurahan</span>
                            <span>Alamat</span>
                            <span>Nomor Rekening</span>
                            <span>NIK KTP</span>
                            <span>Foto KTP</span>
                            <?=
                                $title == 'Edit' ? '
                                    <span>Register Date</span>
                                    <span>Status Approval</span>
                                    <span>Approval Date</span>
                                    <span>Status</span>
                                ' : ''
                            ?>
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
                            <?=
                                $title == 'Edit' ? '
                                    <span>:</span>
                                    <span>:</span>
                                    <span>:</span>
                                    <span>:</span>
                                ' : ''
                            ?>
                        </div>
                        <div>
                            <input type="hidden" name="Add" value="<?= $title == 'Edit' ? '' : 'Add' ?>" required>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm" name="Image" disabled>
                                <input type="file" name="Image">
                                <input type="button" value="Show Image" class="ShowImageForm" name="Image" required>
                                <input type="hidden" name="ImageEdit" value="<?= $title == 'Edit' ? $dataImage : '' ?>">
                            </span>
                            <input type="text" placeholder="Username" name="Username" value="<?= $title == 'Edit' ? $dataUsername : '' ?>" readonly>
                            <input type="text" placeholder="Password" name="Password" value="<?= $title == 'Edit' ? $dataPassword : '' ?>" readonly>
                            <input type="text" placeholder="Email" name="Email" value="<?= $title == 'Edit' ? $dataEmail : '' ?>" readonly>
                            <input type="text" placeholder="PhoneNumber" name="PhoneNumber" value="<?= $title == 'Edit' ? $dataPhoneNumber : '' ?>" readonly>
                            <input type="text" placeholder="Province" name="Province" value="<?= $title == 'Edit' ? $dataProvince : '' ?>" readonly>
                            <input type="text" placeholder="District" name="District" value="<?= $title == 'Edit' ? $dataDistrict : '' ?>" readonly>
                            <input type="text" placeholder="Subdistrict" name="Subdistrict" value="<?= $title == 'Edit' ? $dataSubdistrict : '' ?>" readonly>
                            <input type="text" placeholder="Address" name="Address" value="<?= $title == 'Edit' ? $dataAddress : '' ?>" readonly>
                            <input type="text" placeholder="AccountNumber" name="AccountNumber" value="<?= $title == 'Edit' ? $dataAccountNumber : '' ?>" readonly>
                            <input type="text" placeholder="IdentificationNumber" name="IdentificationNumber" value="<?= $title == 'Edit' ? $dataIdentificationNumber : '' ?>" readonly>
                            <span class="image">
                                <input type="button" value="Select Image" class="SelectImageForm Two" name="ImageCard" disabled>
                                <input type="file" name="ImageCard">
                                <input type="button" value="Show Image" class="ShowImageForm Two" name="ImageCard" required>
                                <input type="hidden" name="ImageCardEdit" value="<?= $title == 'Edit' ? $dataImageCard : '' ?>">
                            </span>
                            <input type="<?= $title == 'Edit' ? 'text' : 'hidden' ?>" placeholder="RegisterDate" name="RegisterDate" value="<?= $title == 'Edit' ? $dataRegisterDate : '' ?>" readonly>
                            <select name="StatusApproval" disabled>
                                <!-- Configure your select value -->
                                <option value="<?= $selectvalue = 'Dikonfirmasi' ?>" <?= $title == 'Edit' && $dataStatusApproval == $selectvalue ? 'selected' : '' ?> disabled><?= $selectvalue ?></option>
                                <option value="<?= $selectvalue = 'Belum dikonfirmasi' ?>" <?= $title == 'Edit' && $dataStatusApproval == $selectvalue ? 'selected' : '' ?>><?= $selectvalue ?></option>
                            </select>
                            <input type="<?= $title == 'Edit' ? 'text' : 'hidden' ?>" placeholder="ApprovalDate" name="ApprovalDate" value="<?= $title == 'Edit' ? $dataApprovalDate : '' ?>" readonly>
                            <input type="<?= $title == 'Edit' ? 'text' : 'hidden' ?>" placeholder="Status" name="Status" value="<?= $title == 'Edit' ? $dataStatus : '' ?>" readonly>
                        </div>
                    </div>

                    <div class="decision">
                        <div>
                            <a href="<?= $RedirectURL . $IndexPage . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch . $transactionID . $transactionPage . $transactionProduct ?>">Kembali</a>     
                            <input type="submit" value="Pilih mitra" id="buttonPilihMitra">
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