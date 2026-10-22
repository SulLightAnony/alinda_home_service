<?php include "../../header.php"; ?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="profile.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Edit data</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2">
                <form class="needs-validation" enctype="multipart/form-data" action="form-edit-action.php<?= isset($_GET['orderpage']) ? '?orderpage&ID=' . $_GET['ID'] . '&status=' . $_GET['status'] . '&search=' . $_GET['search'] : '' ?>" method="post" novalidate>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Username">Username*</label>
                            <input type="text" class="form-control" id="Username" name="Username" value="<?= $_SESSION['UsernamePartner'] ?>" required>
                            <div class="invalid-feedback">Mohon untuk mengisi username</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="PhoneNumber">Nomor Telepon*</label>
                            <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" value="<?= $_SESSION['PhoneNumberPartner'] ?>" required>
                            <div class="invalid-feedback">Mohon untuk mengisi nomor telepon</div>
                        </div>
                    </div>
                
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Province">Provinsi*</label>
                            <select class="form-control custom-select" id="Province" style="font-size:14px;" name="Province" required>
                                <option selected disabled value="">Pilih</option>
                                <?php 
                                    $province = mysqli_query($conn, "SELECT * FROM tbl_province");
                                    while($row = mysqli_fetch_assoc($province)){
                                ?>
                                    <option value="<?= $row['Name'] ?>" <?= $_SESSION['ProvincePartner'] == $row['Name'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                <?php } ?>                                
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih provinsi</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="District">Kota/Kabupaten*</label>
                            <select class="form-control custom-select" id="District" style="font-size:14px;" name="District" required>
                                <?php 
                                    $district = mysqli_query($conn, "SELECT * FROM tbl_district");
                                    $districtID = null;

                                    while($row = mysqli_fetch_assoc($district)){
                                        if ($districtID === null && $_SESSION['DistrictPartner'] == $row['Name'])
                                        {
                                            $districtID = $row['DistrictID'];
                                        }
                                ?>
                                        <option value="<?= $row['DistrictID'] . "|" . $row['Name'] ?>" <?= $_SESSION['DistrictPartner'] == $row['Name'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                <?php } ?>                                
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih kota/kabupaten</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Subdistrict">Kecamatan*</label>
                            <select class="form-control custom-select" id="Subdistrict" style="font-size:14px;" name="Subdistrict" required>
                            <?php 
                                $subdistrict = mysqli_query($conn, "SELECT * FROM tbl_subdistrict WHERE DistrictID = '$districtID'");
                                while($row = mysqli_fetch_assoc($subdistrict)){
                            ?>
                                <option value="<?= $row['Name'] ?>" <?= $_SESSION['SubdistrictPartner'] == $row['Name'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                            <?php } ?>     
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih kecamatan</div>
                        </div>
                    </div>
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Address">Alamat lengkap*</label>
                            <textarea class="form-control" style="font-size:14px;" id="Address" name="Address" required><?= $_SESSION['AddressPartner'] ?></textarea>
                            <div class="invalid-feedback">Mohon untuk mengisi alamat</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="FileChooseForm02">Foto KTP*</label>
                            <button class="btn btn-primary form-control-file" id="FileChooseForm02">Pilih file</button>
                            <input type="file" style="display: none;" accept="image/*" name="ImageCard"></input>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="IdentificationNumber">NIK KTP*</label>
                            <input type="text" class="form-control" id="IdentificationNumber" name="IdentificationNumber" value="<?= $_SESSION['IdentificationNumberPartner'] ?>" required>
                            <div class="invalid-feedback">Mohon untuk mengisi NIK KTP</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="BankName">Bank Rekening*</label>
                            <input type="text" class="form-control" id="BankName" name="BankName" placeholder="Nama dan kode bank milikimu" value="<?= $_SESSION['BankNamePartner'] ?>" required>
                            <div class="invalid-feedback">Mohon untuk mengisi nama bank yang kamu gunakan</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="AccountNumber">Nomor Rekening*</label>
                            <input type="text" class="form-control" id="AccountNumber" name="AccountNumber" value="<?= $_SESSION['AccountNumberPartner'] ?>" required>
                            <div class="invalid-feedback">Mohon untuk mengisi nomor rekening kamu</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="FileChooseForm">Foto Profil</label>
                            <button class="btn btn-primary form-control-file" id="FileChooseForm">Pilih file</button>
                            <input type="file" style="display: none;" accept="image/*" name="Image" value="<?= $_SESSION['ImagePartner'] ?>"></input>
                        </div>
                    </div>

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

        let provinceSelect = document.getElementById("Province");
        let districtSelect = document.getElementById("District");
        let subdistrictSelect = document.getElementById("Subdistrict");
        let addressArea = document.getElementById("Address");
        let fileChooseButton = document.getElementById("FileChooseForm");

        fileChooseButton.addEventListener("click", (e)=>{
            e.preventDefault();
            fileChooseButton.nextElementSibling.click();
        });

        provinceSelect.addEventListener("input", ()=>{
            if(provinceSelect.value!=""){districtSelect.removeAttribute("disabled");}
        });

        districtSelect.addEventListener("input", async ()=>{
            await fetch('location-search.php?DistrictID=' + districtSelect.value.split("|")[0])
            .then(response => response.text())
            .then(data => {
                data = JSON.parse(data);
                if (data.length > 0) {
                    subdistrictSelect.innerHTML = "<option selected disabled value=''>Pilih</option>";

                    for(let i = 0; i < data.length; i++)
                    {
                        const option = document.createElement("option");
                        option.value = data[i];
                        option.textContent = data[i];
                        subdistrictSelect.appendChild(option);
                    }
                }
            });
  
            if(provinceSelect.value!="" && districtSelect.value!=""){subdistrictSelect.removeAttribute("disabled");}
        });
        
        subdistrictSelect.addEventListener("input", ()=>{
            if(provinceSelect.value!="" && districtSelect.value!="" && subdistrictSelect.value!=""){addressArea.removeAttribute("disabled");}
        });

        addressArea.addEventListener("input", ()=>{
            if(provinceSelect.value!="" && districtSelect.value!="" && subdistrictSelect.value!="" && addressArea.value.length>10){fileChooseButton.removeAttribute("disabled");}
            else {fileChooseButton.setAttribute("disabled", "");}
        });
    </script>
</body>
</html>