const TheURL = window.location.href;

// index ---------------------------------------
if(TheURL.includes("index.php"))
{
    document.addEventListener("DOMContentLoaded", () => {  
        const blackbarrier = document.querySelector(".developer-original-blackbarrier");
        const modalDelete = document.querySelector(".developer-original-modal-delete");
        const modalImage = document.querySelector(".developer-original-modal-image");
        const modalNoImage = document.querySelector(".developer-original-modal-no-image");
        const modalSystemsButtons = document.querySelector(".developer-original-modal-systems");
        const thead = document.querySelector(".developer-original-pagination-container .content .table thead tr");
        const noDataRow = document.getElementById("no-data-tr");

        let OpenModalSystemButtons = "";
        let Option = 0; 
        let partnerID02 = TheURL.includes("skill.php") ? partnerID : "";

        if(thead && noDataRow){
            let colCount = thead.children.length;
            noDataRow.children[0].setAttribute("colspan", colCount);
        }

        if(window.innerWidth<=1100){
            const systemButtons = document.getElementById("SystemsButtons");
            const cloned = systemButtons.cloneNode(true);
            cloned.lastElementChild.remove();
            cloned.lastElementChild.classList.remove("buttonshowsystems");
            cloned.lastElementChild.value = "Close";
            modalSystemsButtons.appendChild(cloned);

            if(systemButtons.children.length>2)
            {
                for(Option = 0; Option <= systemButtons.children.length - 2; Option++){ systemButtons.children[0].remove(); }
            }
            else
            {
                systemButtons.children[0].remove();
            }

            if(Option>0)
            {
                cloned.lastElementChild.addEventListener("click", ()=>closemodalSystemsButtons());
                OpenModalSystemButtons = "#OpenModalSystemButtons";

                if(TheURL.includes("#OpenModalSystemButtons"))
                {
                    openModalSystemsButtons();
                    window.location.hash = "";
                }
            }
        }

        const searchField = document.getElementById('searchfordata');
        const filterSelect = document.getElementById("FilterSelect");
        const sortSelect = document.getElementById("SortSelect");
        const searchForDate = document.getElementById("SearchForDate");

        if(searchField)
        {
            searchField.addEventListener("keydown", (e)=>{
                if (e.key === 'Enter')
                {
                    if(searchField.value=="")
                    {window.location.href= pageURL + "page=1" + sortData + dateData + partnerID02;}
    
                    else
                    {window.location.href= pageURL + "page=1" + "&search=" + searchField.value + sortData + dateData + partnerID02;}
                }
            });
        }
    
        if(filterSelect)
        {
            filterSelect.addEventListener("change", ()=>{
                if(filterSelect.value=="null")
                {window.location.href= pageURL + "page=1" + searchData + sortData + dateData + partnerID02 + OpenModalSystemButtons;}
    
                else
                {window.location.href= pageURL + "page=1" + sortData + "&filter=" + filterSelect.value + dateData + partnerID02 + OpenModalSystemButtons;}
            });
        }
    
        if(sortSelect)
        {
            sortSelect.addEventListener("change", ()=>{
                if(sortSelect.value=="null")
                {window.location.href= pageURL + "page=1" + filterData + dateData + OpenModalSystemButtons;}
    
                else
                {window.location.href= pageURL + "page=1" + searchData + "&sort=" + sortSelect.value + "&by=" + sortSelect.nextElementSibling.value + filterData + dateData + OpenModalSystemButtons;}
            });
    
            if(sortSelect.value != "null")
            {
                sortSelect.nextElementSibling.addEventListener("change", ()=>{
                    window.location.href= pageURL + "page=1" + searchData + "&sort=" + sortSelect.value + "&by=" + sortSelect.nextElementSibling.value + filterData + dateData + OpenModalSystemButtons;
                });
            }
        }
    
        if(searchForDate)
        {
            searchForDate.addEventListener("click", ()=>{
                if(searchForDate.parentElement.children[0].value == ""){ window.location.href= pageURL + "page=1" + sortData + filterData + OpenModalSystemButtons; }
                else{ window.location.href= pageURL + "page=1" + sortData + filterData + "&past=" + searchForDate.parentElement.children[0].value + "&present=" + searchForDate.parentElement.children[1].value + OpenModalSystemButtons; }
            });
    
            if(searchForDate.parentElement.children[1].value=="")
            {
                searchForDate.parentElement.children[0].addEventListener("input", ()=>searchForDate.parentElement.children[1].value = searchForDate.parentElement.children[0].value);
            }
        }
    
        document.querySelectorAll(".developer-original-pagination-container .content .table tbody tr td span .button-hapus").forEach((del)=>{
            if(del)
            {
                del.addEventListener("click",()=>{
                    openModalDelete(del.getAttribute("data-id"));
                });
            }
        });
    
        document.querySelectorAll(".developer-original-pagination-container .content .table tbody tr td span .button-show.image").forEach((image)=>{
            if(image)
            {
                image.addEventListener("click",()=>{
                    if(!image.getAttribute("data-image").includes("/")){openModalNoImage();}
                    else{openModalImage(image.getAttribute("data-image"));}
                });
            }
        });
    
        if(Option>0)
        {
            document.querySelector(".developer-original-pagination-container .content .buttons .systems .buttonshowsystems").addEventListener("click", ()=>{
                openModalSystemsButtons();
            });
        }

        if(modalDelete)
        {
            modalDelete.children[1].children[0].addEventListener("click", ()=>closeModalDelete());
            modalDelete.children[1].children[1].addEventListener("click", ()=>
                window.location.href = crud + "?page=" + page + searchData + sortData + filterData + "&id=" + modalDelete.children[1].children[1].getAttribute("data-id") + "&delete"
            );
        }
    
        if(modalImage){ modalImage.children[0].addEventListener("click", ()=>closeModalImage()); }
        if(modalNoImage){ modalNoImage.children[1].addEventListener("click", ()=>closeModalNoImage()); }
        if(blackbarrier){ blackbarrier.addEventListener("click",()=>closeAllModals()); }

        function openModalDelete(id){
            modalDelete.children[1].children[1].setAttribute("data-id", id);
            modalDelete.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closeModalDelete(){
            modalDelete.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function openModalImage(image){
            modalImage.children[0].src = image;
            modalImage.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closeModalImage(){
            modalImage.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function openModalNoImage(){
            modalNoImage.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closeModalNoImage(){
            modalNoImage.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function openModalSystemsButtons(){
            modalSystemsButtons.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closemodalSystemsButtons(){
            modalSystemsButtons.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function closeAllModals(){
            modalDelete.classList.add("hidden");
            modalImage.classList.add("hidden");
            modalNoImage.classList.add("hidden");
            modalSystemsButtons.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }
    });
}

// form ---------------------------------------
else if(TheURL.includes("form.php"))
{
    document.addEventListener("DOMContentLoaded", () => {  
        const blackbarrier = document.querySelector(".developer-original-blackbarrier");
        const modalConfirm = document.querySelector(".developer-original-modal-confirm");
        const modalConfirm02 = document.querySelector(".developer-original-modal-confirm-02");
        const buttonSelectImage = document.querySelector(".developer-original-form-add form .content div:nth-child(3) .image input.SelectImageForm");
        const buttonSelectImage02 = document.querySelector(".developer-original-form-add form .content div:nth-child(3) .image input.SelectImageForm.Two");
        const buttonSelectImage03 = document.querySelector(".developer-original-form-add form .content div:nth-child(3) .image input.SelectImageForm.Three");
        const buttonImage = document.querySelector(".developer-original-form-add form .content div:nth-child(3) .image input.ShowImageForm");
        const buttonImage02 = document.querySelector(".developer-original-form-add form .content div:nth-child(3) .image input.ShowImageForm.Two");
        const buttonImage03 = document.querySelector(".developer-original-form-add form .content div:nth-child(3) .image input.ShowImageForm.Three");
        const modalImage = document.querySelector(".developer-original-modal-image");
        const modalImage02 = document.querySelector(".developer-original-modal-image-02");
        const modalImage03 = document.querySelector(".developer-original-modal-image-03");
        const modalNoImage = document.querySelector(".developer-original-modal-no-image");
        const buttonRejected = document.querySelector("#ButtonRejected");
        const buttonAccepted = document.querySelector("#ButtonAccepted");
        const modalRejected = document.querySelector(".developer-original-modal-rejected");
        const modalAccepted = document.querySelector(".developer-original-modal-accepted");
        

        let modalConfirmStatus = false;
        let modalValue = false;

        document.querySelectorAll(".developer-original-form-add form .content div:nth-child(3) .money input[type='text']").forEach((money)=>{
            if(money){
                money.addEventListener("input", () => {
                    let moneys = money.value.replace(/\./g, '');
                    moneys = moneys.replace(/[^0-9]/g, '');
                    money.value = moneys.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                });
            }
        });

        // Kode ini adalah jika gambar lebih dari satu

        buttonSelectImage.addEventListener("click", ()=>{
            selectImage(buttonSelectImage);
        });

        buttonSelectImage02.addEventListener("click", ()=>{
            selectImage(buttonSelectImage02);
        });

        buttonSelectImage03.addEventListener("click", ()=>{
            selectImage(buttonSelectImage03);
        });

        buttonImage.addEventListener("click", ()=>{
            buttonShowImage(buttonImage);
        });

        buttonImage02.addEventListener("click", ()=>{
            buttonShowImage(buttonImage02);
        });

        buttonImage03.addEventListener("click", ()=>{
            buttonShowImage(buttonImage03);
        });

        // ---------------------------------------------

        if(modalImage){ modalImage.addEventListener("click",()=>closeModalImage()); }
        if(blackbarrier){ blackbarrier.addEventListener("click",()=>closeAllModals()); }
        if(modalConfirm02){ modalConfirm02.children[1].addEventListener("click",()=>closeModalConfirm02()); }
        if(modalNoImage){ modalNoImage.children[1].addEventListener("click", ()=>closeModalNoImage()); }

        // Kode ini adalah jika gambar lebih dari satu
        function selectImage(image){
            openModalConfirm();

            setTimeout(()=>{
                if(modalConfirmStatus == false){image.nextElementSibling.click(); closeModalConfirm();}
                modalConfirmStatus = false;
            },1000);

            modalConfirm.children[1].addEventListener("click", ()=>{
                closeModalConfirm();
            }), {once:true};
        }

        function buttonShowImage(image){
            const file = image.previousElementSibling.files[0];
            modalValue = false;

            if (file)
            {
                console.log(file);

                const reader = new FileReader();
                reader.onload = (e) => {     
                    console.log(reader);
                    let openWhere = image.getAttribute("name");
                    // Perhatikan kode ini juga
                    if(openWhere == "CustomerImage"){modalImage.children[0].src= e.target.result;}
                    else if(openWhere == "CustomerImageProve"){modalImage02.children[0].src= e.target.result;}
                    else if(openWhere == "ProductImage"){modalImage03.children[0].src= e.target.result;}
                    // -------------------------
                    console.log(e.target.result);
                };

                reader.readAsDataURL(file);
                modalValue = true;

                openModalImage(image);
            }
            else if(window.location.href.includes("?edit"))
            {
                openModalImage(image);
            }
            else{ openModalConfirm02(); }
        }

        // ---------------------------------------------

        function openModalConfirm(text){
            modalConfirm.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closeModalConfirm(){
            modalConfirm.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function openModalConfirm02(text){
            modalConfirm02.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closeModalConfirm02(){
            modalConfirm02.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        // Kode ini adalah jika gambar lebih dari satu
        function openModalImage(image){
            let openWhere = image.getAttribute("name");

            if(openWhere == "CustomerImage"){
                if(modalImage.children[0].getAttribute("src").includes("/") || modalValue == true)
                {
                    modalImage.classList.remove("hidden");
                    blackbarrier.classList.remove("hidden");
                }
                else
                {
                    openModalNoImage();
                }
            }

            else if(openWhere == "CustomerImageProve"){
                if(modalImage02.children[0].getAttribute("src").includes("/") || modalValue == true)
                {
                    modalImage02.classList.remove("hidden");
                    blackbarrier.classList.remove("hidden");
                }
                else
                {
                    openModalNoImage();
                }
            }

            else if(openWhere == "ProductImage"){
                if(modalImage03.children[0].getAttribute("src").includes("/") || modalValue == true)
                {
                    modalImage03.classList.remove("hidden");
                    blackbarrier.classList.remove("hidden");
                }
                else
                {
                    openModalNoImage();
                }
            }
        }
        // ---------------------------------------------

        function closeModalImage(){
            modalImage.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function openModalNoImage(){
            modalNoImage.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        }

        function closeModalNoImage(){
            modalNoImage.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        function closeAllModals(){
            modalConfirm.classList.add("hidden");
            modalConfirm02.classList.add("hidden");
            modalImage.classList.add("hidden");
            // Perhatikan sebelah sini juga. Jangan lupa menambahkan modal baru ke function ini
            modalImage02.classList.add("hidden");
            modalImage03.classList.add("hidden");
            modalNoImage.classList.add("hidden");
            modalRejected.classList.add("hidden");
            modalAccepted.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        }

        // -------------------------------------------------------

        buttonRejected.addEventListener("click", ()=>{
            modalRejected.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        });

        modalRejected.children[0].children[2].children[0].addEventListener("click", ()=>{
            modalRejected.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        });

        buttonAccepted.addEventListener("click", ()=>{
            modalAccepted.classList.remove("hidden");
            blackbarrier.classList.remove("hidden");
        });

        modalAccepted.children[0].children[1].children[0].addEventListener("click", ()=>{
            modalAccepted.classList.add("hidden");
            blackbarrier.classList.add("hidden");
        });
    });
}

document.addEventListener("DOMContentLoaded", ()=>document.getElementById("sidebarMenu").children[3].classList.add("active"));
document.addEventListener("DOMContentLoaded", ()=>document.getElementById("sidebarMenu").children[3].children[1].children[1].classList.add("active"));