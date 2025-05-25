<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/dropdownnav.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-links">
            <a href="dashboard.php">Beranda</a>

            <div class="dropdown">
                <a href="#" class="dropdown-trigger" onclick="toggleDropdown(event, this)">Pasien</a>
                <div class="dropdown-content">
                    <a href="pasien.php">Pasien Data</a>
                    <a href="inputpasien.php">Input Pasien Data</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#" class="dropdown-trigger" onclick="toggleDropdown(event, this)">Rekap Medis</a>
                <div class="dropdown-content">
                    <a href="datarekap.php">Rekap Medis Data</a>
                    <a href="inputrekap.php">Input Rekap Medis</a>
                </div>
            </div>
        </div>
    </div>
    <script src="js/dropdown.js"></script>
    </script>
</body>

</html>