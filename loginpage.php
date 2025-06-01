<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Menu</title>
    <link rel="stylesheet" href="css/global-style.css">
</head>

<body>
    <div class="header">
        <h2 class="header-title">LOGIN MENU</h2>
    </div>
    <div class="container">
        <div class="login">
            <p>WELCOME BACK<br>DOCTOR</p>
            <small>Please Enter Your<br>ID</small>
            <form action="login.php" method="post">
                <label for="id_user">ID USER</label>
                <input type="text" id="id_user" name="Id_user" placeholder="Masukan id user" required>
                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="Password" placeholder="Masukan password" required>
                <input type="submit" value="LOGIN">
            </form>
        </div>
    </div>
</body>
</html>