<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pasien = $_POST['id_pasien'];
    $nama_pasien = $_POST['nama_pasien'];
    $jk_pasien = $_POST['jk_pasien'];
    $notelp_pasien = $_POST['notelp_pasien'];
    $alamat_pasien = $_POST['alamat_pasien'];
    $usia = $_POST['usia'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $status = $_POST['status'];

    $sql = "INSERT INTO pasien (id_pasien, nama_pasien, jk_pasien, notelp_pasien, alamat_pasien, usia, tgl_lahir, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $id_pasien, $nama_pasien, $jk_pasien, $notelp_pasien, $alamat_pasien, $usia, $tgl_lahir, $status);

    if ($stmt->execute()) {
        echo "Data pasien berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Input Data Pasien</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px); /* Adjust for navbar height */
            margin-top: 70px; /* Ensure it doesn't overlap the navbar */
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form-container">
            <h1>Input Data Pasien</h1>
            <form method="POST" action="">
                <label for="id_pasien">ID Pasien:</label>
                <input type="text" id="id_pasien" name="id_pasien" required>

                <label for="nama_pasien">Nama Pasien:</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required>

                <label for="jk_pasien">Jenis Kelamin:</label>
                <select id="jk_pasien" name="jk_pasien" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>

                <label for="notelp_pasien">No. Telepon:</label>
                <input type="text" id="notelp_pasien" name="notelp_pasien" required>

                <label for="alamat_pasien">Alamat:</label>
                <textarea id="alamat_pasien" name="alamat_pasien" required></textarea>

                <label for="usia">Usia:</label>
                <input type="number" id="usia" name="usia" required>

                <label for="tgl_lahir">Tanggal Lahir:</label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Sudah menikah">Sudah menikah</option>
                    <option value="Belum menikah">Belum menikah</option>
                </select>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>