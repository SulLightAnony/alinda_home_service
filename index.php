<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levels</title>
    <style>
        .developer-original-container{
            border: 3px solid rgba(0,0,0,0.3);
            border-radius: 7px;
            width:350px;
            height:50px;
            position:absolute;
            top:50%;
            left:50%;
            transform: translate(-50%, -50%);
            display: flex;
            gap:10px;
            justify-content: center;
            align-items: center;

            & a{
                display: flex;
                justify-content: center;
                align-items: center;
                background: cyan;
                width:100px;
                height:30px;
                color:blue;
                text-decoration: none;
                border: 1px solid blue;
                border-radius: 7px;
                transition: 0.3s;

                &:hover{
                    transform: scale(1.05);
                }
            }
        }
    </style>
</head>
<body>
    <div class="developer-original-container">
        <a href="admin/menus/login/PHP/Login.php">Admin</a>
        <a href="partner/menus/login.php">Partner</a>
        <a href="customer/menus/login.php">Customer</a>
    </div>
</body>
</html>