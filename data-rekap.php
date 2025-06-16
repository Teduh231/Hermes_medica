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

// Query to fetch all relevant data from rekam_medis table
$sql = "SELECT no_rm AS id_rekap, no_pasien AS id_pasien, tgl_pemeriksaan AS tanggal, diagnosa, kd_tindakan AS tindakan, kd_obat, jumlah_pakai, kd_user, resep, keluhan, ket FROM rekam_medis";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Rekap Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            font-size: 1.8rem;
            color: #333;
        }

        table {
            width: 96%;
            border-collapse: collapse;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 70px;
                opacity: 0; /* Start hidden */
            transform: translateY(20px); /* Start slightly below */
            animation: slideUp 0.5s ease-out forwards; /* Slide up animation */
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        thead {
            background-color: #18d4bb;
        }

        thead th {
            color: #fff;
            font-weight: 600;
            padding: 10px;
            text-align: left;
            font-size: 1rem;
        }

        tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody td {
            padding: 10px;
            font-size: 0.9rem;
            color: #333;
            text-align: left;
        }

        tbody tr:hover {
            background: #e6f7f5;
        }

        .btn-action {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 4px 10px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Data Rekap Medis</h2>
    <table>
        <thead>
            <tr>
                <th>ID Rekap</th>
                <th>ID Pasien</th>
                <th>Tanggal</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Kode Obat</th>
                <th>Jumlah Pakai</th>
                <th>Kode User</th>
                <th>Resep</th>
                <th>Keluhan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_rekap']; ?></td>
                        <td><?php echo $row['id_pasien']; ?></td>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['diagnosa']; ?></td>
                        <td><?php echo $row['tindakan']; ?></td>
                        <td><?php echo $row['kd_obat']; ?></td>
                        <td><?php echo $row['jumlah_pakai']; ?></td>
                        <td><?php echo $row['kd_user']; ?></td>
                        <td><?php echo $row['resep']; ?></td>
                        <td><?php echo $row['keluhan']; ?></td>
                        <td><?php echo $row['ket']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="11">Tidak ada data rekap medis.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php $conn->close(); ?>