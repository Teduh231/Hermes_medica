<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/global-style.css">
</head>

<body>
    <div class="sidebar">
        <div class="profile">
            <div class="p_icon">
                <img src="data:image/jpeg;base64,<?php echo $_SESSION['Foto_dokter']; ?>" alt="" height="45" width="45" style="border-radius: 50%;">
            </div>
            <div class="p_name">
                <div style="color: white;"><?php echo $_SESSION['nama']; ?></div>
                <div style="color: white; font-size:13px;">Spelialis:<?php echo $_SESSION['spesialis']; ?></div>
            </div>
        </div>
        <div>
            <hr>
        </div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</body>

</html>