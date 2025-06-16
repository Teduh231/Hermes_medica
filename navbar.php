<?php
session_start();

function isActive($pageName) {
    return basename($_SERVER['PHP_SELF']) === $pageName ? 'active' : '';
}
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
            <a href="/Hermes_medica/index.php" class="<?php echo isActive('index.php'); ?>">Beranda</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Dokter'): ?>
                <a href="/Hermes_medica/nav-pasien.php" class="<?php echo isActive('nav-pasien.php'); ?>">Pasien</a>
                <a href="/Hermes_medica/nav-obat.php" class="<?php echo isActive('nav-obat.php'); ?>">Obat</a>
                <a href="/Hermes_medica/nav-poli.php" class="<?php echo isActive('nav-poli.php'); ?>">Poliklinik</a>
                <a href="/Hermes_medica/nav-lab.php" class="<?php echo isActive('nav-lab.php'); ?>">Laboratorium</a>
                <a href="/Hermes_medica/nav-tindakan.php" class="<?php echo isActive('nav-tindakan.php'); ?>">Tindakan</a>
                <a href="/Hermes_medica/nav-rekap.php" class="<?php echo isActive('nav-rekap.php'); ?>">Rekap medis</a>
                
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                <a href="/Hermes_medica/adminpanel.php" class="<?php echo isActive('adminpanel.php'); ?>">Admin Panel</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>