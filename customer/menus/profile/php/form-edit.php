<?php include "../../header.php"; ?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="<?= isset($_GET['orderpage']) ? '../../product/php/product-order.php?ID=' . $_GET['ID'] . '&search=' . $_GET['search'] : 'profile.php' ?>" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Edit data</div>
            <div class="right"></div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="wide-block pt-2 pb-2">
                <form class="needs-validation" enctype="multipart/form-data" action="form-edit-action.php<?= isset($_GET['orderpage']) ? '?orderpage&ID=' . $_GET['ID'] . '&search=' . $_GET['search'] : '' ?>" method="post" novalidate>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Username">Username*</label>
                            <input type="text" class="form-control" id="Username" name="Username" value="<?= $_SESSION['Username'] ?>" required>
                            <div class="invalid-feedback">Mohon untuk mengisi username</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="PhoneNumber">Nomor Telepon*</label>
                            <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" value="<?= $_SESSION['PhoneNumber'] ?>" required>
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
                                    <option value="<?= $row['Name'] ?>" <?= $_SESSION['Province'] == $row['Name'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
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
                                        if ($districtID === null && $_SESSION['District'] == $row['Name'])
                                        {
                                            $districtID = $row['DistrictID'];
                                        }
                                ?>
                                        <option value="<?= $row['DistrictID'] . "|" . $row['Name'] ?>" <?= $_SESSION['District'] == $row['Name'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
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
                                <option value="<?= $row['Name'] ?>" <?= $_SESSION['Subdistrict'] == $row['Name'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                            <?php } ?>     
                            </select>
                            <div class="invalid-feedback">Mohon untuk memilih kecamatan</div>
                        </div>
                    </div>
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="Address">Alamat lengkap*</label>
                            <textarea class="form-control" style="font-size:14px;" id="Address" name="Address" required><?= $_SESSION['Address'] ?></textarea>
                            <div class="invalid-feedback">Mohon untuk mengisi alamat</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="GoogleMap">Link Google Map* (Cari alamat kamu di Google Map lalu klik button share [<svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            	 width="10px" height="10px" viewBox="0 0 483 483" xml:space="preserve">
                            <g>
                            	<path d="M395.72,0c-48.204,0-87.281,39.078-87.281,87.281c0,2.036,0.164,4.03,0.309,6.029l-161.233,75.674
                            		c-15.668-14.971-36.852-24.215-60.231-24.215c-48.204,0.001-87.282,39.079-87.282,87.282c0,48.204,39.078,87.281,87.281,87.281
                            		c15.206,0,29.501-3.907,41.948-10.741l69.789,58.806c-3.056,8.896-4.789,18.396-4.789,28.322c0,48.204,39.078,87.281,87.281,87.281
                            		c48.205,0,87.281-39.078,87.281-87.281s-39.077-87.281-87.281-87.281c-15.205,0-29.5,3.908-41.949,10.74l-69.788-58.805
                            		c3.057-8.891,4.789-18.396,4.789-28.322c0-2.035-0.164-4.024-0.308-6.029l161.232-75.674c15.668,14.971,36.852,24.215,60.23,24.215
                            		c48.203,0,87.281-39.078,87.281-87.281C482.999,39.079,443.923,0,395.72,0z"/>
                            </g>
                            </svg>] dan salin link)</label>
                            <textarea class="form-control" style="font-size:14px;" id="GoogleMap" name="GoogleMap" required><?= $_SESSION['GoogleMap'] ?></textarea>
                            <div class="invalid-feedback">Mohon untuk mengisi link google map</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="FileChooseForm">Foto Profil</label>
                            <button class="btn btn-primary form-control-file" id="FileChooseForm">Pilih file</button>
                            <input type="file" style="display: none;" accept="image/*" name="Image" value="<?= $_SESSION['Image'] ?>"></input>
                        </div>
                    </div>

                    <input type="hidden" name="Email" value="<?= $_SESSION['Email'] ?>">

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