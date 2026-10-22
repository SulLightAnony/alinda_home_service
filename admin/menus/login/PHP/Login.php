<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="assets/assets_login/img/Alinda Logo.png">
        <link rel = "stylesheet" href = "../CSS/Login.css">
        <script src="assets/assets_login/font.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/assets_login/style.css" />
        <title>Login</title>
    </head>

    <body class="authentication">
        <div class = "transition transitionH" id = "transition"></div>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form class="sign-in-form">
                        <img src="assets/assets_login/img/Alinda Logo.png" style="width: 250px;"> 

                        <h2 class="text-center" style="margin-bottom: 10px; margin-top: 20px;">Login</h2>
                        <p id = "sub-title" hidden>Masuk</p>
                        <div class="input-field">
                            <i class="fas fa-address-card"></i>
                            <input type="text" class="form-control" placeholder="username" name="username" id="username">
                        </div>

                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-control" placeholder="password" name="password" id="password">
                        </div>

                        <div class="alerts">
                            <p class = "alert hidden" id = "alert">Username atau Password salah!</p>
                            <p class = "alert hidden" id = "useralert">Isi Username!</p>
                            <p class = "alert hidden" id = "passalert">Isi Password!</p>
                        </div>
                        <div class="actions mb-4">
                            <button type="submit" class="btn btn-success" id="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src = "../Javascript/Login.js"></script>    
    </body>
</html>