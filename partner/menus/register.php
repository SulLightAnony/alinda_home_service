<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Register Partner</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icon/192x192.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="manifest" href="../__manifest.json">
</head>

<body class="bg-white">

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="login.php" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
            <a href="login.php" class="headerButton">
                Login
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="login-form">
            <div class="section">
                <h1>Register Partner</h1>
            </div>
            <div class="section mt-2 mb-5">
                <form action="register-action.php" method="post" id="Form">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" Name="Username" placeholder="Username" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" class="form-control" Name="Email" placeholder="Email address" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        <span style="color:rgba(255, 41, 41, 0.7); font-size:11px; display: none;" id="EmailReminder">Email ini sudah digunakan</span>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="number" class="form-control" Name="PhoneNumber" placeholder="Nomor HP" required min="0">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" Name="Password" placeholder="Password" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        <span style="color:rgba(255, 41, 41, 0.7); font-size:11px; display: none;" id="PasswordReminder">Password harus di isi dengan minimal 8 karakter</span>
                    </div>
                     
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="PasswordRepeat" placeholder="Password Repeat" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" disabled>Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ///////////// Js Files //////////////////// -->
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
        let disable = true;
        let form = document.getElementById("Form");
        let check = "null";

        form.children[1].children[0].children[0].addEventListener("blur", async ()=>{
            
        });
        
        document.querySelectorAll(".form-control").forEach((e)=>{
            e.addEventListener("input", async ()=>{
                await fetch("email-check.php?email=" + form.children[1].children[0].children[0].value)
                .then(response => response.text())
                .then(data => {check = data;});

                if(check == "true")
                {
                    document.getElementById("EmailReminder").style.display="block";
                }
                else if(check == "false")
                {
                    document.getElementById("EmailReminder").style.display="none";
                }

                if( form.children[0].children[0].children[0].value != "" && 
                    form.children[1].children[0].children[0].value != "" && 
                    form.children[2].children[0].children[0].value != "" && 
                    form.children[3].children[0].children[0].value != "" && 
                    form.children[4].children[0].children[0].value != "" && 
                    form.children[3].children[0].children[0].value == form.children[4].children[0].children[0].value &&
                    form.children[3].children[0].children[0].value.length > 7 &&
                    check == "false"
                  )
                    { form.children[5].children[0].removeAttribute("disabled"); }

                else{ form.children[5].children[0].setAttribute("disabled", ""); }
            });
        });

        form.children[3].children[0].children[0].addEventListener("input", ()=>{
            if(form.children[3].children[0].children[0].value.length < 8)
            {
                document.getElementById("PasswordReminder").style.display="block";
            }
            else
            {
                document.getElementById("PasswordReminder").style.display="none";
            }
            
            PasswordMatch();
        });
        form.children[4].children[0].children[0].addEventListener("input", ()=>{
            PasswordMatch();
        });

        form.children[2].children[0].children[0].addEventListener("input", ()=>{
            form.children[2].children[0].children[0].value = form.children[2].children[0].children[0].value.replace(/[^0-9]/g, '');
        });

        function PasswordMatch()
        {
            if(form.children[3].children[0].children[0].value != form.children[4].children[0].children[0].value)
            {
                form.children[4].children[0].children[0].style.border="1px solid rgba(255, 41, 41, 0.7)";
            }
            else
            {
                form.children[4].children[0].children[0].style.border="1px solid rgba(0, 0, 0, 0.18)";
            }
        }
    </script>
</body>
</html>