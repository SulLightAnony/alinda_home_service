document.getElementById('Price').addEventListener('input', function (e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    if (value) {
        value = parseInt(value, 10).toLocaleString('id-ID');
    }
    e.target.value = value;
});

const orderButton = document.getElementById("OrderButton");
const orderConfirm = document.getElementById("OrderConfirm");
const blackbarrier02 = document.getElementById("Blackbarrier-02");

let submit = false;

orderButton.addEventListener("click", (e)=>{
    if(!submit)
    {
        e.preventDefault();
        submit = true; 
        orderConfirm.classList.remove("hidden");
        blackbarrier02.classList.remove("hidden");
    }
});

blackbarrier02.addEventListener("click", ()=>{
    submit = false;
    orderConfirm.classList.add("hidden");
    blackbarrier02.classList.add("hidden");
});

orderConfirm.children[1].children[0].addEventListener("click", ()=>{
    submit = false;
    orderConfirm.classList.add("hidden");
    blackbarrier02.classList.add("hidden");
});

orderConfirm.children[1].children[1].addEventListener("click", ()=>{
    orderButton.click();
});