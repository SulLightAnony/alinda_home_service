const writeMessage = document.querySelector(".developer-original-write-message");
const sectionFull = document.querySelector(".section.full.mt-2");

sectionFull.scrollTop = sectionFull.scrollHeight;

writeMessage.children[0].focus();
writeMessage.children[0].addEventListener("keyup", (event) => {
    if (event.key === "Enter" && writeMessage.children[0].value.trim() !== "") {
        writeMessage.children[3].click();
    }
});
writeMessage.children[1].addEventListener("click", ()=>window.location.reload());
writeMessage.children[2].addEventListener("click", ()=>{if(writeMessage.children[0].value.trim() !== ""){writeMessage.children[3].click();}});