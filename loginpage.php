<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <div>
        <link rel="stylesheet" href="css/style.css">
        <div class="header">
            <div class="icon"><img src="img/hermess.png" alt="hermes" width="50px" height="50px"></div>
            <div style="color: white; margin-left:20px;">Hermes Medica</div>
            <div style="color:white;justify-content:center;width:96rem; margin-left:32rem;">
                <h2>Login Menu</h2>
            </div>
        </div>
        <div class="container">
            <div class="login">
                <center>
                    <p style="color:black;font-size: 25px;">Welcome back<br>doctor
                    </p>
                    <p style="opacity:0.7;">enter your information</p>
                </center>
                <form action="login.php" method="post">

                    <div>
                        <div><input type="text" name="Id_user" placeholder="Masukan id....."></div>
                        <div>
                            <input type="password" name="Password" placeholder="Masukan Password.....">
                        </div>
                        <div>
                            <input type="submit" value="Masuk">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>