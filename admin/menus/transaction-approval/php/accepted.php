<?php
    include '../../connection/Validate.php';
    date_default_timezone_set("Asia/Jakarta");

    $IndexPage      = isset($_GET['page']) ? "?page=" . $_GET['page'] : null;
    $IndexSearch    = isset($_GET['search']) ? "&search=" .  $_GET['search'] : null;
    $IndexFilter    = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : null;
    $IndexSort      = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] . "&by=" . $_GET['by'] : null;
    $IndexDateSearch= isset($_GET['past']) ? "&past=" . $_GET['past'] . "&present=" . $_GET['present'] : null;

    if (isset($_GET['ID'])) {
        $id = $_GET['ID'];

        // Ambil info produk
        $result = $conn->prepare("SELECT ProductName, CustomerSubdistrict, ProductStatus FROM tbl_transaction WHERE ID = ?");
        $result->bind_param("i", $id);
        $result->execute();
        $res = $result->get_result();
        $row = $res->fetch_assoc();
        $result->close();

        $productName    = $row['ProductName'];
        $productStatus  = $row['ProductStatus'];
        $subdistrict    = $row['CustomerSubdistrict'];

        if (strtolower(trim($productName)) === 'suruh apa saja') {
            // 🔥 Abaikan semua proses POST → langsung ubah status jadi "Berjalan"
            $update = $conn->prepare("UPDATE tbl_transaction SET Status = 'Berjalan' WHERE ID = ?");
            $update->bind_param("i", $id);
            $update->execute();
            $update->close();
        } 
        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = "Menunggu konfirmasi mitra";

            // Cari semua partner di lokasi yang sesuai
            $emails = [];
            $stmt = $conn->prepare("SELECT Email FROM tbl_partners 
                WHERE Subdistrict = ? 
                AND Status = 'Sedang dapat melayani' 
                AND StatusApproval = 'Sudah dikonfirmasi'");
            $stmt->bind_param("s", $subdistrict);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($r = $res->fetch_assoc()) {
                $emails[] = $r['Email'];
            }
            $stmt->close();

            shuffle($emails);

            $found = false;
            foreach ($emails as $email) {
                $skillStmt = $conn->prepare("SELECT SkillStatus, SkillName 
                                            FROM tbl_partners_skill 
                                            WHERE PartnerEmail = ? AND Status = 'Sudah dikonfirmasi'");
                $skillStmt->bind_param("s", $email);
                $skillStmt->execute();
                $skills = $skillStmt->get_result();

                while ($skill = $skills->fetch_assoc()) {
                    if (
                        strtolower(trim($skill['SkillName'])) == strtolower(trim($productName))
                    ) {
                        // Simpan partner
                        $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = ?, Status = ? WHERE ID = ?");
                        $update->bind_param("ssi", $email, $status, $id);
                        $update->execute();
                        $update->close();
                        $found = true;

                        $partnerUpdate = $conn->prepare("UPDATE tbl_partners SET Status = ? WHERE Email = ?");
                        $partnerStatus = "Sedang tidak dapat melayani";
                        $partnerUpdate->bind_param("ss", $partnerStatus, $email);
                        $partnerUpdate->execute();
                        $partnerUpdate->close();
                        
                        $_SESSION['StatusPartner'] = "Sedang tidak dapat melayani";
                        break 2;
                    }
                }
                $skillStmt->close();
            }

            if (!$found) {
                $status = "Menunggu konfirmasi mitra.";
                $update = $conn->prepare("UPDATE tbl_transaction SET PartnerEmail = '', Status = ? WHERE ID = ?");
                $update->bind_param("si", $status, $id);
                $update->execute();
                $update->close();
            }
        }
    }

    header("Location: index.php" . $IndexPage . "&id=" . $id . $IndexSearch . $IndexSort . $IndexFilter . $IndexDateSearch);
    exit;
?>