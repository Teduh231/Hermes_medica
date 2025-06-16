<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.html");
    exit();
}

include 'header.php';
include 'navbar.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hermes_medica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nm_obat = $_POST['nm_obat'];
    $jml_obat = $_POST['jml_obat'];
    $ukuran = $_POST['ukuran'];
    $harga = $_POST['harga'];

    $sql = "INSERT INTO obat (nm_obat, jml_obat, ukuran, harga) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisd", $nm_obat, $jml_obat, $ukuran, $harga);

    if ($stmt->execute()) {
        echo "<script>alert('Obat berhasil ditambahkan.'); window.location.href='input-obat.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan obat.'); window.location.href='input-obat.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Obat</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            margin-top: 10%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        textarea {
            resize: none; /* Disable resizing */
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: rgb(7, 221, 192);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: rgb(7, 200, 174);
        }

        .form-container .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Input Obat</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nm_obat">Nama Obat</label>
                <input type="text" id="nm_obat" name="nm_obat" required>
            </div>

            <div class="form-group">
                <label for="jml_obat">Jumlah Obat</label>
                <input type="number" id="jml_obat" name="jml_obat" required>
            </div>

            <div class="form-group">
                <label for="ukuran">Ukuran</label>
                <input type="text" id="ukuran" name="ukuran" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" step="0.01" required>
            </div>

            <button type="submit" name="create">Tambah Obat</button>
        </form>
    </div>  
</body>

</html>