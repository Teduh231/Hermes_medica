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

// Fetch obat data
$sql = "SELECT * FROM obat";
$result = $conn->query($sql);
$obatData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $obatData[] = $row;
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $kd_obat = $_POST['kd_obat'];
    $nm_obat = $_POST['nm_obat'];
    $jml_obat = $_POST['jml_obat'];
    $ukuran = $_POST['ukuran'];
    $harga = $_POST['harga'];

    $sql = "UPDATE obat SET nm_obat = ?, jml_obat = ?, ukuran = ?, harga = ? WHERE kd_obat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisdi", $nm_obat, $jml_obat, $ukuran, $harga, $kd_obat);

    if ($stmt->execute()) {
        echo "<script>alert('Data obat berhasil diperbarui.'); window.location.href='manage-obat.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data obat.'); window.location.href='manage-obat.php';</script>";
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
    <title>Data Obat</title>
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

        button[type="submit"] {
            width: 100%;
            padding: 12px 0;
            background-color: rgb(7, 221, 192);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            margin-top: 8px;
            box-shadow: 0 2px 4px rgba(20, 46, 110, 0.08);
            transition: background 0.2s;
        }

        button[type="submit"]:hover {
            background-color: rgb(7, 200, 174);
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
    <h1>Data Obat</h1>
    <table>
        <thead>
            <tr>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($obatData)): ?>
                <?php foreach ($obatData as $index => $obat): ?>
                    <tr>
                        <td><?php echo $obat['kd_obat']; ?></td>
                        <td><?php echo $obat['nm_obat']; ?></td>
                        <td><?php echo $obat['jml_obat']; ?></td>
                        <td><?php echo $obat['ukuran']; ?></td>
                        <td><?php echo $obat['harga']; ?></td>
                        <td>
                            <button class="btn-action" onclick="openModal(<?php echo $obat['kd_obat']; ?>, '<?php echo $obat['nm_obat']; ?>', <?php echo $obat['jml_obat']; ?>, '<?php echo $obat['ukuran']; ?>', <?php echo $obat['harga']; ?>)">EDIT</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data obat.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal Edit -->
    <div class="overlay" id="overlay"></div>
    <div class="modal" id="editModal">
        <h2>Edit Obat</h2>
        <form method="POST" action="">
            <input type="hidden" id="editKdObat" name="kd_obat">
            <label for="editNmObat">Nama Obat:</label>
            <input type="text" id="editNmObat" name="nm_obat" required>

            <label for="editJmlObat">Jumlah Obat:</label>
            <input type="number" id="editJmlObat" name="jml_obat" required>

            <label for="editUkuran">Ukuran:</label>
            <input type="text" id="editUkuran" name="ukuran" required>

            <label for="editHarga">Harga:</label>
            <input type="number" id="editHarga" name="harga" step="0.01" required>

            <button type="submit" name="edit">Simpan Perubahan</button>
            <button type="button" class="close-btn" onclick="closeModal()">Batal</button>
        </form>
    </div>

    <script>
        function openModal(kd_obat, nm_obat, jml_obat, ukuran, harga) {
            document.getElementById('editKdObat').value = kd_obat;
            document.getElementById('editNmObat').value = nm_obat;
            document.getElementById('editJmlObat').value = jml_obat;
            document.getElementById('editUkuran').value = ukuran;
            document.getElementById('editHarga').value = harga;
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