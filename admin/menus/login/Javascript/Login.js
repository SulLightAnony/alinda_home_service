let Target = "../../admin-dashboard/php/index.php";

function calculate()
{
    const userjs = document.getElementById("username").value;
    const passjs = document.getElementById("password").value;

    if(userjs=="")
    {
        document.getElementById("username").focus(); 
        document.getElementById("passalert").classList.add("hidden");
        document.getElementById("useralert").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("useralert").classList.add("hidden");
        }, 2000);
        return false;
    }
    else if(passjs=="")
    {
        document.getElementById("password").focus();
        document.getElementById("useralert").classList.add("hidden");
        document.getElementById("passalert").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("passalert").classList.add("hidden");
        }, 2000);
        return false;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../PHP/Log-in.php?username=' + userjs + "&password=" + passjs, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('sub-title').innerText = xhr.responseText;
        } else {
            console.error('Error:', xhr.statusText);
        }
    };

    xhr.send();
}

document.getElementById("submit").addEventListener("click", (e) =>{
    e.preventDefault();
    calculate();
});

document.getElementById("password").addEventListener("keydown", (e) => {
    if (e.key === 'Enter')
        {
            e.preventDefault();
            calculate();
        }
});

const targetNode = document.getElementById('sub-title');
const config = { childList: true, subtree: true };

const callback = function(mutationsList, observer) {
    for (let mutation of mutationsList) {
        if (mutation.type === 'childList') {
            let a = targetNode.innerText;
            if(a=="I AM ATOMIC")
            {
                if(Target !== "#")
                {
                    document.getElementById("transition").classList.remove("transitionH");
                    
                    //Lokasi Halaman Selanjutnya -------------------------------------------------------------------
                    setTimeout(() => {
                        window.location=Target;
                    }, 1000);
                }
                else{ alert("Tidak ada tempat tujuan! Target = " + Target); }
            }
            else
            {
                document.getElementById("alert").classList.remove("hidden");
                document.getElementById("useralert").classList.add("hidden");
                document.getElementById("passalert").classList.add("hidden");
            }
        }
    }
};

const observer = new MutationObserver(callback);
observer.observe(targetNode, config);

function alerts(){document.getElementById("alert").classList.add("hidden");}

document.getElementById("username").addEventListener("keydown", (e) => {
    if (e.key === 'Enter')
        {
            e.preventDefault();
            
            if(document.getElementById("username").value!="")
            {
                document.getElementById("password").focus();
            }
        }
});
document.getElementById("username").addEventListener("focus", () => {alerts();});
document.getElementById("password").addEventListener("focus", () => {alerts();});