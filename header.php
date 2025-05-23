<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Dropdown.css"> </head>
<body>
    <div class="header">
        <div class="icon"><img src="img/hermess.png" alt="hermes" width="43px" height="43px"></div>
        <div style="color: white; font-size:23px;">Hermes Medica</div>

        <div class="user-dropdown">
            <div class="dropdown-trigger" style="margin-left: 6rem;">
                <img src="data:image/jpeg;base64,<?php echo $_SESSION['Foto_dokter']; ?>" alt="User" width="40px" height="40px" style="border-radius: 50%; margin-left: 20px; cursor: pointer;">
                <h4 style="color:white; margin-left: 5px;"><?php echo $_SESSION['nama']; ?></h4>
            </div>
            <div class="dropdown-content">
                <div class="dropdown-info">
                <img src="data:image/jpeg;base64,<?php echo $_SESSION['Foto_dokter']; ?>" alt="User"  width="55px" height="55px" style="border-radius: 50%; cursor: pointer;">
                <div>
                <span style="color:black; font-size: 20px; margin-left: 5px;"><?php echo $_SESSION['nama']; ?></span>
                <span style="color:black; margin-left: 5px;">Spesialis:<?php echo $_SESSION['spesialis']; ?></span>
            </div>
            </div>
                <div class="dropdown-links">
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Log out</a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/dropdown.js"></script> </body>
</html>