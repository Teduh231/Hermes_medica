<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hermes Medica</title>
    <link rel="stylesheet" href="/Hermes_medica/css/nav-style.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-links">
            <a href="/Hermes_medica/dashboard.php"
                class="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">Beranda</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'doctor'): ?>
                <a href="/Hermes_medica/nav-pasien.php"
                    class="<?php echo basename($_SERVER['PHP_SELF']) === 'nav-pasien.php' ? 'active' : ''; ?>">Pasien</a>

                <a href="/Hermes_medica/nav-rekap.php"
                    class="<?php echo basename($_SERVER['PHP_SELF']) === 'nav-rekap.php' ? 'active' : ''; ?>">Rekap medis</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/Hermes_medica/adminpanel.php"
                    class="<?php echo basename($_SERVER['PHP_SELF']) === 'adminpanel.php' ? 'active' : ''; ?>">Admin Panel</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>