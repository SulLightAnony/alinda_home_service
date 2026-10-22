<script>
    if(window.location.hash!="#login" && window.location.hash!="#failed"){
        const LoginKey = localStorage.getItem("KenapaHarusAdaPerangDuniaKeTigaDisaatAkuMenjadiDewasa");
        window.location.href = "autologin.php?LoginKey=" + encodeURIComponent(LoginKey) + "<?= isset($_GET['target']) ? '&target=profile' : '' ?>";
    }
</script>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Login</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icon/192x192.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="manifest" href="../__manifest.json">
</head>

<body style="background-image:url('../../database/universal/image/Login-Background.jpg'); background-size:cover; background-repeat: no-repeat; background-position: center;">
    <!-- App Capsule -->
    <div id="appCapsule" style="background-image: none !important;" class="pt-0">
        <br><br><br><br>
        <div class="login-form mt-1">
            <div class="section">
                <img src="../../database/universal/image/LogoJPG.png" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1>Login Partner</h1>
            </div>
            <div class="section mt-1 mb-5">
                <form action="login-action.php" method="post">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" class="form-control" name="Email" placeholder="Email address" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" name="Password" placeholder="Password" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        <div style="position: absolute; padding-top: 5px;">
                            <input type="checkbox" onclick="if(this.checked){document.getElementsByName('Password')[0].type='text';}else{document.getElementsByName('Password')[0].type='password';}" style="margin-top: 5px; width: 20px; height:20px;" id="show-password" name="show-password">
                            <label for="show-password" style="position: absolute; width: 150px; transform: translate(-10px, 4px);">Show Password</label>
                        </div>
                    </div>
                    <br>
                    
                    <span style="color:rgba(255, 41, 41, 0.7); font-size:11px; display: none;" id="LoginFailed">Email atau Password salah</span>

                    <div class="form-links mt-2">
                        <div>
                            <a href="register.php">Register</a>
                        </div>
                        <div><a href="customer-service.php" class="text-muted">Aku lupa password😭</a></div>
                    </div>
                    <div class="form-button">
                        <br>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="../assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="../assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>

    <script>
        document.querySelectorAll(".form-control").forEach((e)=>{
            e.addEventListener("input", ()=>{
                document.getElementById("LoginFailed").style.display="none";
            });
        });

        if(window.location.hash=="#failed"){
            document.getElementById("LoginFailed").style.display="block";

            setTimeout(()=>window.location.hash="",300);
        }
    </script>
</body>

</html>