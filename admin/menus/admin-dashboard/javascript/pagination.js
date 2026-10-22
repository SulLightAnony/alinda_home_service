document.addEventListener("DOMContentLoaded", ()=>document.getElementById("sidebarMenu").children[0].classList.add("active"));
document.addEventListener("DOMContentLoaded", ()=>document.getElementById("sidebarMenu").children[0].children[1].children[0].classList.add("active"));

document.getElementById("AllTime").addEventListener("click", ()=>window.location.href=`index.php?date=AllTime`);