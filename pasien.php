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

// Function to fetch all pasien data
function getPasienData($conn) {
    $sql = "SELECT * FROM pasien";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fetch pasien data
$pasienData = getPasienData($conn);

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM pasien WHERE id_pasien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $delete_id);
    if ($stmt->execute()) {
        header("Location: pasien.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
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
    <title>Pasien</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Data Pasien</h1>
    <a href="inputpasien.php">Tambah Pasien</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID Pasien</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Usia</th>
                <th>Tanggal Lahir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pasienData)): ?>
                <?php foreach ($pasienData as $pasien): ?>
                    <tr>
                        <td><?php echo $pasien['id_pasien']; ?></td>
                        <td><?php echo $pasien['nama_pasien']; ?></td>
                        <td><?php echo $pasien['jk_pasien']; ?></td>
                        <td><?php echo $pasien['notelp_pasien']; ?></td>
                        <td><?php echo $pasien['alamat_pasien']; ?></td>
                        <td><?php echo $pasien['usia']; ?></td>
                        <td><?php echo $pasien['tgl_lahir']; ?></td>
                        <td><?php echo $pasien['status']; ?></td>
                        <td>
                            <a href="editpasien.php?id=<?php echo $pasien['id_pasien']; ?>">Edit</a>
                            <a href="pasien.php?delete_id=<?php echo $pasien['id_pasien']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">Tidak ada data pasien.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>