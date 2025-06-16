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

// Fetch poli data
$sql = "SELECT * FROM laboratorium";
$result = $conn->query(query: $sql);
$poliData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $poliData[] = $row;
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $kd_lab = $_POST['kd_lab'];
    $nm_lab = $_POST['nm_lab'];
    $hasil = $_POST['hasil_lab'];
    $ket = $_POST['ket'];

    $sql = "UPDATE laboratorium SET nm_lab = ?, hasil_lab = ?, ket = ? WHERE kd_lab = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nm_lab, $hasil, $ket, $kd_lab);

    if ($stmt->execute()) {
        echo "<script>alert('Data laboratorium berhasil diperbarui.'); window.location.href='manage-lab.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data laboratorium.'); window.location.href='manage-lab.php';</script>";
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
                <th>Kode Lab</th>
                <th>Nama Lab</th>
                <th>Hasil Lab</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($obatData)): ?>
                <?php foreach ($obatData as $index => $obat): ?>
                    <tr>
                        <td><?php echo $obat['kd_lab']; ?></td>
                        <td><?php echo $obat['nm_lab']; ?></td>
                        <td><?php echo $obat['hasil_lab']; ?></td>
                        <td><?php echo $obat['ket']; ?></td>
                        <td>
                            <button class="btn-action" onclick="openModal(<?php echo $obat['kd_poli']; ?>, '<?php echo $obat['nm_poli']; ?>', <?php echo $obat['lantai']; ?>)">EDIT</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data laboratorium.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal Edit -->
    <div class="overlay" id="overlay"></div>
    <div class="modal" id="editModal">
        <h2>Edit Laboratorium</h2>
        <form method="POST" action="">
            <input type="hidden" id="editKdLab" name="kd_lab">
            <label for="editNmLab">Nama Laboratorium:</label>
            <input type="text" id="editNmLab" name="nm_lab" required>
            <label for="editHasilLab">Hasil Lab:</label>
            <input type="text" id="editHasilLab" name="hasil_lab" required>
            <label for="editKet">Keterangan:</label>
            <input type="text" id="editKet" name="ket" required>

            <button type="submit" name="edit">Simpan Perubahan</button>
            <button type="button" class="close-btn" onclick="closeModal()">Batal</button>
        </form>
    </div>

    <script>
        function openModal(kd_lab, nm_lab, hasil_lab, ket) {
            document.getElementById('editKdLab').value = kd_lab;
            document.getElementById('editNmLab').value = nm_lab;
            document.getElementById('editHasilLab').value = hasil_lab;
            document.getElementById('editKet').value = ket;
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