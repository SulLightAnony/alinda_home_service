<?php 
    include "../../header.php";

    if (isset($_SESSION['SkillStatusPartner']) && $_SESSION['SkillStatusPartner'] != "-"){header("location: home.php");}
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="form-skill.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Isi data skill</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2">
                <form class="needs-validation" action="form-skill-add-action.php" method="post" novalidate>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="SkillName">Daftar skill yang tersedia*</label>
                            <select class="form-control custom-select" id="SkillName" style="font-size:14px;" name="SkillName" required>
                                <option selected disabled value="">Pilih</option>
                                <?php 
                                    $district = mysqli_query($conn, "SELECT * FROM tbl_admin_product WHERE Status = 'Secondary' ORDER BY Name ASC");
                                    while($row = mysqli_fetch_assoc($district)){
                                ?>
                                    <option value="<?= $row['ID'] . "|" . $row['Name'] ?>"><?= $row['Name'] ?></option>
                                <?php } ?>                                
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih produk</div>
                        </div>
                    </div>

                    <input type="hidden" name="SkillStatus" value="-">
                    <input type="hidden" name="Email" value="<?= $_SESSION['EmailPartner'] ?>">

                    <div class="mt-2">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>

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
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>