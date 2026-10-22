<script>
    document.addEventListener("DOMContentLoaded", async ()=>{
        await localStorage.setItem("KrabbyPattyIsTheBestBurgerAfterDonsBurgerYeay", window.location.hash.split("#")[1]);
        window.location.href="home/php/home.php";
    });
</script>