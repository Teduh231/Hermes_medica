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
    <title>Pasien</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Table styling */
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

        th,
        td {
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
            font-size: 1rem;
            border-top: none;
            border-bottom: none;
        }

        tr:nth-child(even) td {
            background: #f8f8f8;
        }

        tr:hover td {
            background: #e6f0ff;
        }

        td {
            vertical-align: middle;
            height: 32px;
        }

        /* Button action styling */
        .btn-action {
            display: inline-block;
            padding: 2px 16px;
            margin: 0 2px;
            border-radius: 18px;
            background: #1a238a;
            color: #fff !important;
            font-size: 1rem;
            font-weight: 400;
            text-decoration: none;
            border: none;
            text-align: center;
            transition: background 0.2s;
            letter-spacing: 1px;
            height: 28px;
            line-height: 24px;
            box-sizing: border-box;
            vertical-align: middle;
        }

        .btn-action:hover {
            background: #0d2047;
        }

        .btn-edit {
            /* Optionally add specific styles for edit */
        }

        .btn-hapus {
            /* Optionally add specific styles for hapus */
        }
    </style>
</head>

<body>
    <h1>Data Pasien</h1>
    <table border="1">
        <thead>
            <tr>
                <center>
                    <th>ID Pasien</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kelamin</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Usia</th>
                    <th>Tanggal Lahir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </center>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pasienData)): ?>
                <?php foreach ($pasienData as $pasien): ?>
                    <tr>
                        <td><?php echo $pasien['no_pasien']; ?></td>
                        <td><?php echo $pasien['nama_pasien']; ?></td>
                        <td><?php echo $pasien['jk_pasien']; ?></td>
                        <td><?php echo $pasien['notelp_pasien']; ?></td>
                        <td><?php echo $pasien['alamat_pasien']; ?></td>
                        <td><?php echo $pasien['usia']; ?></td>
                        <td><?php echo $pasien['tgl_lahir']; ?></td>
                        <td><?php echo $pasien['status']; ?></td>
                        <td>
                            <a href="editpasien.php?no_pasien=<?php echo $pasien['no_pasien']; ?>"
                                class="btn-action btn-edit">EDIT</a>
                            <a href="pasien.php?delete_no=<?php echo $pasien['no_pasien']; ?>" class="btn-action btn-hapus"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">HAPUS</a>
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