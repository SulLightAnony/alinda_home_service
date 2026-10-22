<?php include '../../header.php' ?>

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="profile.php" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="login-form">
            <div class="section">
                <h1>Ubah password</h1>
            </div>
            <div class="section mt-2 mb-5">
                <form action="form-password-action.php" method="post" id="Form">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" Name="PasswordOld" placeholder="Password lama" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        <span style="color:rgba(255, 41, 41, 0.7); font-size:11px; <?= isset($_GET['false']) ? "" : "display: none;" ?>" id="LoginFailed">Password lama salah</span>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" Name="PasswordNew" placeholder="Password baru" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        <span style="color:rgba(255, 41, 41, 0.7); font-size:11px; display: none;" id="PasswordReminder">Password harus di isi dengan minimal 8 karakter</span>
                    </div>
                     
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="PasswordRepeat" placeholder="Konfirmasi password baru" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" disabled>Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ///////////// Js Files //////////////////// -->
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
        let disable = true;
        let form = document.getElementById("Form");
        let check = "null";
        
        document.querySelectorAll(".form-control").forEach((e)=>{
            e.addEventListener("input", ()=>{
                if( form.children[0].children[0].children[0].value != "" && 
                    form.children[1].children[0].children[0].value == form.children[2].children[0].children[0].value &&
                    form.children[2].children[0].children[0].value.length > 7
                  )
                    { form.children[3].children[0].removeAttribute("disabled"); }

                else{ form.children[3].children[0].setAttribute("disabled", ""); }
            });
        });

        form.children[1].children[0].children[0].addEventListener("input", ()=>{
            if(form.children[1].children[0].children[0].value.length < 8)
            {
                document.getElementById("PasswordReminder").style.display="block";
            }
            else
            {
                document.getElementById("PasswordReminder").style.display="none";
            }
            
            PasswordMatch();
        });

        form.children[2].children[0].children[0].addEventListener("input", ()=>{
            PasswordMatch();
        });

        function PasswordMatch()
        {
            if(form.children[1].children[0].children[0].value != form.children[2].children[0].children[0].value)
            {
                form.children[2].children[0].children[0].style.border="1px solid rgba(255, 41, 41, 0.7)";
            }
            else
            {
                form.children[2].children[0].children[0].style.border="1px solid rgba(0, 0, 0, 0.18)";
            }
        }
    </script>
</body>
</html>