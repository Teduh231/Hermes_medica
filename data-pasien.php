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

// Fetch pasien data
$sql = "SELECT * FROM pasien";
$result = $conn->query($sql);
$pasienData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pasienData[] = $row;
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $no_pasien = $_POST['no_pasien'];
    $nama_pasien = $_POST['nama_pasien'];
    $jk_pasien = $_POST['jk_pasien'];
    $notelp_pasien = $_POST['notelp_pasien'];
    $alamat_pasien = $_POST['alamat_pasien'];
    $usia = $_POST['usia'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $status = $_POST['status'];
    $nm_kk = $_POST['nm_kk'];
    $hubungan_keluarga = $_POST['hubungan_keluarga'];

    $sql = "UPDATE pasien SET nama_pasien = ?, jk_pasien = ?, notelp_pasien = ?, alamat_pasien = ?, usia = ?, tgl_lahir = ?, status = ?, nm_kk = ?, hubungan_keluarga = ? WHERE no_pasien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssissssi", $nama_pasien, $jk_pasien, $notelp_pasien, $alamat_pasien, $usia, $tgl_lahir, $status, $nm_kk, $hubungan_keluarga, $no_pasien);

    if ($stmt->execute()) {
        echo "<script>alert('Data pasien berhasil diperbarui.'); window.location.href='data-pasien.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data pasien.'); window.location.href='data-pasien.php';</script>";
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
            cursor: pointer;
        }

        .btn-action:hover {
            background-color: #007bff;
            color: #fff;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            z-index: 1000;
        }

        .modal.active {
            display: block;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        button.close-btn {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button.close-btn:hover {
            background-color: #d32f2f;
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
                            <button class="btn-action" onclick="openModal(<?php echo $pasien['no_pasien']; ?>, '<?php echo $pasien['nama_pasien']; ?>', '<?php echo $pasien['jk_pasien']; ?>', '<?php echo $pasien['notelp_pasien']; ?>', '<?php echo $pasien['alamat_pasien']; ?>', <?php echo $pasien['usia']; ?>, '<?php echo $pasien['tgl_lahir']; ?>', '<?php echo $pasien['status']; ?>', '<?php echo $pasien['nm_kk']; ?>', '<?php echo $pasien['hubungan_keluarga']; ?>')">EDIT</button>
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

    <!-- Modal Edit -->
    <div class="overlay" id="overlay"></div>
    <div class="modal" id="editModal">
        <h2>Edit Pasien</h2>
        <form method="POST" action="">
            <input type="hidden" id="editNoPasien" name="no_pasien">
            <label for="editNamaPasien">Nama Pasien:</label>
            <input type="text" id="editNamaPasien" name="nama_pasien" required>

            <label for="editJkPasien">Jenis Kelamin:</label>
            <input type="text" id="editJkPasien" name="jk_pasien" required>

            <label for="editNotelpPasien">No Telepon:</label>
            <input type="text" id="editNotelpPasien" name="notelp_pasien" required>

            <label for="editAlamatPasien">Alamat:</label>
            <input type="text" id="editAlamatPasien" name="alamat_pasien" required>

            <label for="editUsia">Usia:</label>
            <input type="number" id="editUsia" name="usia" required>

            <label for="editTglLahir">Tanggal Lahir:</label>
            <input type="text" id="editTglLahir" name="tgl_lahir" required>

            <label for="editStatus">Status:</label>
            <input type="text" id="editStatus" name="status" required>

            <label for="editNmKk">Nama Kepala Keluarga:</label>
            <input type="text" id="editNmKk" name="nm_kk" required>

            <label for="editHubunganKeluarga">Hubungan Keluarga:</label>
            <input type="text" id="editHubunganKeluarga" name="hubungan_keluarga" required>

            <button type="submit" name="edit">Simpan Perubahan</button>
            <button type="button" class="close-btn" onclick="closeModal()">Batal</button>
        </form>
    </div>

    <script>
        function openModal(no_pasien, nama_pasien, jk_pasien, notelp_pasien, alamat_pasien, usia, tgl_lahir, status, nm_kk, hubungan_keluarga) {
            document.getElementById('editNoPasien').value = no_pasien;
            document.getElementById('editNamaPasien').value = nama_pasien;
            document.getElementById('editJkPasien').value = jk_pasien;
            document.getElementById('editNotelpPasien').value = notelp_pasien;
            document.getElementById('editAlamatPasien').value = alamat_pasien;
            document.getElementById('editUsia').value = usia;
            document.getElementById('editTglLahir').value = tgl_lahir;
            document.getElementById('editStatus').value = status;
            document.getElementById('editNmKk').value = nm_kk;
            document.getElementById('editHubunganKeluarga').value = hubungan_keluarga;
            document.getElementById('editModal').classList.add('active');
            document.getElementById('overlay').classList.add('active');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }
    </script>
</body>

</html>