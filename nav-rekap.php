<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<?php include 'header.php';?>
<?php include 'navbar.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/nav-style.css">
</head>

<body>
    <div class="pasien-nav-container">
        <a href="data-rekap.php" class="pasien-card">
            <div>
                <div class="pasien-card-title">DATA</div>
                <div class="pasien-card-sub">Rekap Medis</div>
            </div>
            <div class="pasien-card-icon">
                <svg width="60" height="48" viewBox="0 0 60 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="36" width="10" height="10" rx="2" fill="#111" />
                    <rect x="16" y="26" width="10" height="20" rx="2" fill="#111" />
                    <rect x="30" y="16" width="10" height="30" rx="2" fill="#111" />
                    <rect x="44" y="6" width="10" height="40" rx="2" fill="#111" />
                </svg>
            </div>
        </a>
        <a href="input-rekap.php" class="pasien-card">
            <div>
                <div class="pasien-card-title">INPUT</div>
                <div class="pasien-card-sub">Rekap Medis</div>
            </div>
            <div class="pasien-card-icon">
                <svg width="60" height="48" viewBox="0 0 60 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="8" width="44" height="32" rx="4" fill="#111" />
                    <rect x="16" y="16" width="28" height="4" rx="1" fill="#18d4bb" />
                    <rect x="16" y="24" width="20" height="4" rx="1" fill="#18d4bb" />
                    <rect x="16" y="32" width="12" height="4" rx="1" fill="#18d4bb" />
                    <polygon points="44,8 52,16 44,16" fill="#18d4bb" />
                </svg>
            </div>
        </a>
    </div>
</body>

</html>