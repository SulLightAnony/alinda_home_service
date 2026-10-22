<!-- Jquery JS-->
<script src="../../../vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="../../../vendor/bootstrap-4.1/popper.min.js"></script>
<script src="../../../vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="../../../vendor/slick/slick.min.js">
</script>
<script src="../../../vendor/wow/wow.min.js"></script>
<script src="../../../vendor/animsition/animsition.min.js"></script>
<script src="../../../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="../../../vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="../../../vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="../../../vendor/circle-progress/circle-progress.min.js"></script>
<script src="../../../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../../../vendor/chartjs/Chart.bundle.min.js"></script>
<script src="../../../vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="../../../js/main.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        let countdown = document.getElementById("Countdown");

        if(!window.location.href.includes("form.php"))
        {
            let duration = 300;
            let minutes = 5;
            let seconds = 59;
            let zero = "";

            setInterval(()=>{
                duration--;
                minutes = Math.floor(duration / 60);
                seconds = duration % 60;
                zero = seconds < 10 ? "0" : "";
                countdown.textContent = `Auto Refresh : 0${minutes}:${zero}${seconds}`;
            },1000);

            setTimeout(()=>window.location.reload(),300000);
        }
        else
        {
            countdown.textContent = ``;
        }
    });
</script>