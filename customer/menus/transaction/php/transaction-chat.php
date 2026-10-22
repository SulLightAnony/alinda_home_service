<?php 
    include '../../header.php';
    
    if( (isset($_SESSION['Address']) && $_SESSION['Address'] != "-") &&
        (isset($_SESSION['Province']) && $_SESSION['Province'] != "-") &&
        (isset($_SESSION['District']) && $_SESSION['District'] != "-") &&
        (isset($_SESSION['Subdistrict']) && $_SESSION['Subdistrict'] != "-") &&
        (isset($_SESSION['ProductStatus']) && $_SESSION['ProductStatus'] == "Existed")){
?>

    <!-- App Capsule -->
    <link rel="stylesheet" href="../css/style.css">
    <div id="appCapsule" style="background:rgb(226, 237, 238)!important;">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="transaction-detail.php?ID=<?= $_SESSION['ID-Transaction'] ?>" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">
                <?php
                    $chatroomCode = $_SESSION['Chatroom'];
                    $query = "SELECT PartnerUsername FROM tbl_transaction WHERE Code = '$chatroomCode'";
                    $result = mysqli_query($conn, $query);
                    $partnerUsername = "Chat Partner";
                    if ($result && mysqli_num_rows($result) > 0) {
                        $data = mysqli_fetch_assoc($result);
                        $partnerUsername = htmlspecialchars($data['PartnerUsername'], ENT_QUOTES, 'UTF-8');
                    }
                    echo $partnerUsername;
                ?>
            </div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2" style="background:#e2edee; height:calc(100vh - 200px); overflow-y: scroll; overflow-x: hidden;">
            <div class="wide-block pt-1" style="background: none!important; border:none!important;">
                <div class="developer-original-bubble-chat partner">
                    <div username>Sistem</div>
                    <div message>
                        Harap untuk refresh halaman secara berkala untuk melihat pesan terbaru yang diterima
                    </div>
                </div>
            </div>

            <?php
                $chatroomCode = $_SESSION['Chatroom'];
                $chatMessages = mysqli_query($conn, "SELECT * FROM tbl_chatroom WHERE Chatroom = '$chatroomCode' ORDER BY Timestamp ASC");
                while($row = mysqli_fetch_assoc($chatMessages)){
            ?>
            <div class="wide-block pt-1" style="background: none!important; border:none!important;">
                <div class="developer-original-bubble-chat <?= $row['Sender'] == "Customer" ? "customer" : "partner" ?>">
                    <?= $row['Sender'] == "Customer" ? "" : "<div username>$partnerUsername</div>" ?>
                    <div message>
                        <?= htmlspecialchars($row['Message'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <div timestamp>
                        <?= $row['Timestamp'] ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <form action="transaction-chat-action.php" method="post">
        <div class="developer-original-write-message">
            <textarea name="Message" placeholder="Tulis pesan di sini ..."></textarea>
            <input type="button" value="&#8635;">
            <div><img src="../../../../database/universal/image/Send-Message.png"></div>
            <input type="submit">
        </div>
    </form>

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
    <script src="../js/script.js"></script>
<?php
    }
    else { header("location: ../../home/php/home.php"); }
?>