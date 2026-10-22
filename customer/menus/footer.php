    <!-- App Bottom Menu -->
    <div class="appBottomMenu" style="height:70px;">
        <a href="../../home/php/home.php" class="item">
            <div class="col">
                <img src="../../../../database/universal/image/Menu-Home.png" class="developer-original-menu-icon">
            </div>
        </a>
        <a href="../../profile/php/information-page.php" class="item">
            <div class="col">
                <img src="../../../../database/universal/image/Menu-Video.png" class="developer-original-menu-icon">
            </div>
        </a>
        <a href="../../product/php/product.php?status=cleaning" class="item">
            <div class="col">
                <img src="../../../../database/universal/image/Menu-Product.png" class="developer-original-menu-icon">
            </div>
        </a>
        <a href="../../transaction/php/transaction.php" class="item">
            <div class="col">
                <img src="../../../../database/universal/image/Menu-Transaction.png" class="developer-original-menu-icon">
            </div>
        </a>
        <a href="../../profile/php/profile.php" class="item">
            <div class="col">
                <img src="../../../../database/universal/image/Menu-Profile.png" class="developer-original-menu-icon">
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <!-- profile box -->
                    <div class="profileBox">
                        <a href="#">
                            <div class="image-wrapper" id="ProfilePicture">
                                <img src="<?= $_SESSION['Image'] ?>" alt="image" class="imaged rounded">
                            </div>
                        </a>

                        <a href="../../profile/php/profile.php">
                            <div class="in">
                                <strong><?= $_SESSION['Username']?></strong>
                                <div class="text-muted">
                                    <ion-icon name="location"></ion-icon>
                                    Jawa Barat
                                </div>
                            </div>
                        </a>

                        <a href="javascript:;" class="close-sidebar-button" data-dismiss="modal">
                            <ion-icon name="close"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->

                    <ul class="listview flush transparent no-line image-listview mt-2">
                        <li>
                            <a href="../../home/php/home.php" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="home-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Home</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="../../product/php/product.php" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="cube-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Product</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="../../transaction/php/transaction.php" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="layers-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Transaction</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="../../profile/php/profile.php" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="person-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Profile</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="../../customer-service/php/customer-service.php?link=<?= $_SERVER['REQUEST_URI'] ?>" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Chat Customer Service</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="../../bug-and-suggestion/php/bug-and-suggestion.php?link=<?= $_SERVER['REQUEST_URI'] ?>" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Report Bug and Suggestion</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="../../profile/php/information-page.php" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Information Page</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item" id="Logout">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Logout</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden" id="ProfilePictureShow">
        <img src="<?= $_SESSION['Image'] ?>">
    </div>

    <div class="developer-original-modal-confirm-logout hidden">
        <p>Yakin ingin Logout?</p>
        <div>
            <button>Tidak</button>
            <button>Iya</button>
        </div>
    </div>

    <div class="hidden" id="Blackbarrier"></div>

    <!-- * App Sidebar -->

    <!-- welcome notification  -->
    <!-- <div id="notification-welcome" class="notification-box">
        <div class="notification-dialog android-style">
            <div class="notification-header">
                <div class="in">
                    <img src="../../../assets/img/icon/72x72.png" alt="image" class="imaged w24">
                    <strong>Mobilekit</strong>
                    <span>just now</span>
                </div>
                <a href="#" class="close-button">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="notification-content">
                <div class="in">
                    <h3 class="subtitle">Welcome to Mobilekit</h3>
                    <div class="text">
                        Mobilekit is a PWA ready Mobile UI Kit Template.
                        Great way to start your mobile websites and pwa projects.
                    </div>
                </div>
            </div>
        </div>
    </div>
    * welcome notification -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
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
        // setTimeout(() => {
        //     notification('notification-welcome', 5000);
        // }, 2000);

        let profilePicture = document.getElementById("ProfilePicture");
        let profilePictureAccount = document.getElementById("ProfilePictureAccount");
        let profilePictureShow = document.getElementById("ProfilePictureShow");
        let blackbarrier = document.getElementById("Blackbarrier");
        let modalConfirmLogout = document.querySelector(".developer-original-modal-confirm-logout");

        profilePicture.addEventListener("click", ()=>{
            profilePictureShow.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        });

        blackbarrier.addEventListener("click", ()=>{
            profilePictureShow.classList.add("hidden");
            blackbarrier.classList.add("hidden");
            modalConfirmLogout.classList.add("hidden");
        });

        document.getElementById("Logout").addEventListener("click", ()=>{
            modalConfirmLogout.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        });

        modalConfirmLogout.children[1].children[0].addEventListener("click", ()=>{
            blackbarrier.classList.add("hidden");
            modalConfirmLogout.classList.add("hidden");
        });

        modalConfirmLogout.children[1].children[1].addEventListener("click", ()=>{
            window.location.href = "../../logout.php?email=<?= $_SESSION['Email'] ?>";
        });

        let bottomMenu = document.querySelector(".appBottomMenu");

        if(window.location.href.includes("/home/")){ bottomMenu.children[0].classList.add("active"); }
        else if(window.location.href.includes("/product/")){ bottomMenu.children[2].classList.add("active"); }
        else if(window.location.href.includes("/transaction/")){ bottomMenu.children[3].classList.add("active"); }
        else if(window.location.href.includes("/profile/"))
        { 
            bottomMenu.children[4].classList.add("active"); 

            profilePictureAccount.addEventListener("click", ()=>{
                profilePictureShow.classList.remove("hidden");
                blackbarrier.classList.remove("hidden");
            });
        }
    </script>
</body>
</html>