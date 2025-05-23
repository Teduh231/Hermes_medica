<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdownmenu.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-links">
            <a href="dashboard.php">Beranda</a>

            <!-- Pasien Dropdown -->
            <div class="dropdown">
                <a href="#" class="dropdown-trigger">Pasien</a>
                <div class="dropdown-content">
                    <a href="pasien.php">Pasien Data</a>
                    <a href="inputpasien.php">Input Pasien Data</a>
                </div>
            </div>

            <!-- Rekap Medis Dropdown -->
            <div class="dropdown">
                <a href="#" class="dropdown-trigger">Rekap Medis</a>
                <div class="dropdown-content">
                    <a href="rekapmedis_data.php">Rekap Medis Data</a>
                    <a href="input_rekapmedis.php">Input Rekap Medis</a>
                </div>
            </div>
        </div>
        <script src="js/dropdown.js"></script>
    </div>
</body>
</html>