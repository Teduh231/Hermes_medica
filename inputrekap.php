<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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
    $id_pasien = $_POST['id_pasien'];
    $tanggal = $_POST['tanggal'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $resep = $_POST['resep'];

    $sql = "INSERT INTO rekap_medis (id_pasien, tanggal, diagnosa, tindakan, resep) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    $stmt->bind_param("sssss", $id_pasien, $tanggal, $diagnosa, $tindakan, $resep);

    if ($stmt->execute()) {
        echo "<script>alert('Rekap medis berhasil ditambahkan.'); window.location.href='datarekap.php';</script>";
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
    <title>Input Rekap Medis</title>
    <style>
        .form-container {
            background: #fff;
            padding: 32px 24px 24px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            margin: 40px auto;
        }
        label { display: block; margin-bottom: 6px; font-weight: 500; }
        input, textarea { width: 100%; padding: 8px; margin-bottom: 18px; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 12px 0; background-color: #142e6e; color: #fff; border: none; border-radius: 4px; font-size: 1.1rem; font-weight: 500; cursor: pointer; }
        button:hover { background-color: #0d2047; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Input Rekap Medis</h2>
        <form method="POST" action="">
            <label for="id_pasien">ID Pasien</label>
            <input type="text" id="id_pasien" name="id_pasien" required>

            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" required>

            <label for="diagnosa">Diagnosa</label>
            <textarea id="diagnosa" name="diagnosa" required></textarea>

            <label for="tindakan">Tindakan</label>
            <textarea id="tindakan" name="tindakan" required></textarea>

            <label for="resep">Resep</label>
            <textarea id="resep" name="resep" required></textarea>

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>