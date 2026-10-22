<?php 
    include "../../header.php";

    if( (isset($_SESSION['SubdistrictPartner']) && $_SESSION['SubdistrictPartner'] != "-"))
    // { header("location: home.php"); }
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="home.php" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Isi data lengkap</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2">
                <form class="needs-validation" enctype="multipart/form-data" action="form-action.php" method="post" novalidate>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Province">Provinsi*</label>
                            <select class="form-control custom-select" id="Province" style="font-size:14px;" name="Province" required>
                                <option selected disabled value="">Pilih</option>
                                <?php 
                                    $province = mysqli_query($conn, "SELECT * FROM tbl_province");
                                    while($row = mysqli_fetch_assoc($province)){
                                ?>
                                    <option value="<?= $row['Name'] ?>"><?= $row['Name'] ?></option>
                                <?php } ?>                                
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih provinsi</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="District">Kota/Kabupaten*</label>
                            <select class="form-control custom-select" id="District" style="font-size:14px;" name="District" required disabled>
                                <option selected disabled value="">Pilih</option>
                                <?php 
                                    $district = mysqli_query($conn, "SELECT * FROM tbl_district");
                                    while($row = mysqli_fetch_assoc($district)){
                                ?>
                                    <option value="<?= $row['DistrictID'] . "|" . $row['Name'] ?>"><?= $row['Name'] ?></option>
                                <?php } ?>                                
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih kota/kabupaten</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Subdistrict">Kecamatan*</label>
                            <select class="form-control custom-select" id="Subdistrict" style="font-size:14px;" name="Subdistrict" required disabled>
                                <option selected disabled value="">Pilih</option>
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih kecamatan</div>
                        </div>
                    </div>
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Address">Alamat lengkap*</label>
                            <textarea class="form-control" style="font-size:14px;" id="Address" name="Address" required disabled></textarea>
                            <div class="invalid-feedback">Mohon untuk mengisi alamat</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="FileChooseForm02">Foto KTP*</label>
                            <button class="btn btn-primary form-control-file" id="FileChooseForm02" disabled>Pilih file</button>
                            <input type="file" style="display: none;" accept="image/*" name="ImageCard" required></input>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="IdentificationNumber">NIK KTP*</label>
                            <input type="text" class="form-control" id="IdentificationNumber" name="IdentificationNumber" required disabled>
                            <div class="invalid-feedback">Mohon untuk mengisi NIK KTP</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="BankName">Bank Rekening*</label>
                            <input type="text" class="form-control" id="BankName" name="BankName" placeholder="Nama dan kode bank milikimu" required disabled>
                            <div class="invalid-feedback">Mohon untuk mengisi nama bank yang kamu gunakan</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="AccountNumber">Nomor Rekening*</label>
                            <input type="text" class="form-control" id="AccountNumber" name="AccountNumber" required disabled>
                            <div class="invalid-feedback">Mohon untuk mengisi nomor rekening kamu</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="FileChooseForm">Foto Profil</label>
                            <button class="btn btn-primary form-control-file" id="FileChooseForm" disabled>Pilih file</button>
                            <input type="file" style="display: none;" accept="image/*" name="Image"></input>
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
        let identificationNumberField = document.getElementById("IdentificationNumber");
        let bankNameField = document.getElementById("BankName");
        let accountNumberField = document.getElementById("AccountNumber");
        let fileChooseButton = document.getElementById("FileChooseForm");
        let fileChooseButton02 = document.getElementById("FileChooseForm02");

        fileChooseButton.addEventListener("click", (e)=>{
            e.preventDefault();
            fileChooseButton.nextElementSibling.click();
        });

        fileChooseButton02.addEventListener("click", (e)=>{
            e.preventDefault();
            fileChooseButton02.nextElementSibling.click();
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
            if(provinceSelect.value!="" && districtSelect.value!="" && subdistrictSelect.value!="" && addressArea.value.length>10){fileChooseButton.removeAttribute("disabled"); fileChooseButton02.removeAttribute("disabled"); identificationNumberField.removeAttribute("disabled"); bankNameField.removeAttribute("disabled"); accountNumberField.removeAttribute("disabled");}
            else {fileChooseButton.setAttribute("disabled", ""); fileChooseButton02.setAttribute("disabled", ""); identificationNumberField.setAttribute("disabled", ""); bankNameField.setAttribute("disabled", ""); accountNumberField.setAttribute("disabled", "");}
        });
    </script>
</body>
</html>