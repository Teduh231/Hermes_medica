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

$sql = "SELECT * FROM rekap_medis";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Rekap Medis</title>
    <style>
        table {
            width: 98%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 24px auto 0 auto;
            background: #fff;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 8px rgba(60, 60, 60, 0.10);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #bdbdbd;
            padding: 6px 14px;
            text-align: left;
            font-size: 1rem;
            font-weight: 400;
            background: #fff;
        }
        th {
            background: #444a54;
            color: #fff;
            font-weight: 600;
        }
        tr:nth-child(even) td { background: #f8f8f8; }
        tr:hover td { background: #e6f0ff; }
        td { vertical-align: middle; height: 32px; }
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
                <th>Resep</th>
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
                        <td><?php echo $row['resep']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Tidak ada data rekap medis.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php $conn->close(); ?>