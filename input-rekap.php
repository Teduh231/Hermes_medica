<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.html");
    exit();
}
include 'header.php';
include 'navbar.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hermes_medica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_pasien = $_POST['no_pasien'];
    $kd_tindakan = $_POST['kd_tindakan'];
    $kd_obat = $_POST['kd_obat'];
    $jumlah_pakai = $_POST['jumlah_pakai'];
    $kd_user = $_POST['kd_user'];
    $keluhan = $_POST['keluhan'];
    $diagnosa = $_POST['diagnosa'];
    $resep = $_POST['resep'];
    $tgl_pemeriksaan = $_POST['tgl_pemeriksaan'];
    $ket = $_POST['ket'];

    $sql = "INSERT INTO rekam_medis (no_pasien, kd_tindakan, kd_obat, jumlah_pakai, kd_user, keluhan, diagnosa, resep, tgl_pemeriksaan, ket) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    $stmt->bind_param("iiiiisssss", $no_pasien, $kd_tindakan, $kd_obat, $jumlah_pakai, $kd_user, $keluhan, $diagnosa, $resep, $tgl_pemeriksaan, $ket);

    if ($stmt->execute()) {
        echo "<script>alert('Rekam medis berhasil ditambahkan.'); window.location.href='data-rekap.php';</script>";
    } else {
        die("Execute failed: " . $stmt->error);
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
    <title>Input Rekap Medis</title>
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
        <h2>Input Rekap Medis</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="no_pasien">No. Pasien</label>
                <input type="number" id="no_pasien" name="no_pasien" required>
            </div>

            <div class="form-group">
                <label for="kd_tindakan">Kode Tindakan</label>
                <input type="number" id="kd_tindakan" name="kd_tindakan" required>
            </div>

            <div class="form-group">
                <label for="kd_obat">Kode Obat</label>
                <input type="number" id="kd_obat" name="kd_obat" required>
            </div>

            <div class="form-group">
                <label for="jumlah_pakai">Jumlah Pakai</label>
                <input type="number" id="jumlah_pakai" name="jumlah_pakai" required>
            </div>

            <div class="form-group">
                <label for="kd_user">Kode User</label>
                <input type="number" id="kd_user" name="kd_user" required>
            </div>

            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea id="keluhan" name="keluhan" required></textarea>
            </div>

            <div class="form-group">
                <label for="diagnosa">Diagnosa</label>
                <textarea id="diagnosa" name="diagnosa" required></textarea>
            </div>

            <div class="form-group">
                <label for="resep">Resep</label>
                <textarea id="resep" name="resep" required></textarea>
            </div>

            <div class="form-group">
                <label for="tgl_pemeriksaan">Tanggal Pemeriksaan</label>
                <input type="date" id="tgl_pemeriksaan" name="tgl_pemeriksaan" required>
            </div>

            <div class="form-group">
                <label for="ket">Keterangan</label>
                <textarea id="ket" name="ket"></textarea>
            </div>

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>