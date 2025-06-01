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
function getPasienData($conn)
{
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
if (isset($_GET['delete_no'])) {
    $delete_id = $_GET['delete_no'];
    $sql = "DELETE FROM pasien WHERE no_pasien = ?";
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
    <title>Data Pasien</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Updated styles for table */
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
    <h1>Data Pasien</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Jenis kelamin</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Usia</th>
                <th>Status</th>
                <th>No_telp</th>
                <th>No KK</th>
                <th>Hubungan keluarga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pasienData)): ?>
                <?php foreach ($pasienData as $index => $pasien): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $pasien['nama_pasien']; ?></td>
                        <td><?php echo $pasien['jk_pasien']; ?></td>
                        <td><?php echo $pasien['alamat_pasien']; ?></td>
                        <td><?php echo $pasien['tgl_lahir']; ?></td>
                        <td><?php echo $pasien['usia']; ?></td>
                        <td><?php echo $pasien['status']; ?></td>
                        <td><?php echo $pasien['notelp_pasien']; ?></td>
                        <td><?php echo $pasien['nm_kk']; ?></td>
                        <td><?php echo $pasien['hubungan_keluarga']; ?></td>
                        <td>
                            <a href="editpasien.php?no_pasien=<?php echo $pasien['no_pasien']; ?>" class="btn-action">EDIT</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" style="text-align: center;">Tidak ada data pasien.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>