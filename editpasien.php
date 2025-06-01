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

// Fetch existing data for the selected patient
$no_pasien = $_GET['no_pasien'];
$sql = "SELECT * FROM pasien WHERE no_pasien = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $no_pasien);
$stmt->execute();
$result = $stmt->get_result();
$pasien = $result->fetch_assoc();

if (!$pasien) {
    echo "Data pasien tidak ditemukan.";
    exit();
}

// Handle form submission to update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pasien = $_POST['nama_pasien'];
    $jk_pasien = $_POST['jk_pasien'];
    $alamat_pasien = $_POST['alamat_pasien'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $usia = $_POST['usia'];
    $status = $_POST['status'];
    $notelp_pasien = $_POST['notelp_pasien'];
    $nm_kk = $_POST['nm_kk']; // Changed from no_kk to nm_kk
    $hubungan_keluarga = $_POST['hubungan_keluarga'];

    $update_sql = "UPDATE pasien SET 
        nama_pasien = ?, 
        jk_pasien = ?, 
        alamat_pasien = ?, 
        tgl_lahir = ?, 
        usia = ?, 
        status = ?, 
        notelp_pasien = ?, 
        nm_kk = ?, 
        hubungan_keluarga = ? 
        WHERE no_pasien = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "ssssisssss",
        $nama_pasien,
        $jk_pasien,
        $alamat_pasien,
        $tgl_lahir,
        $usia,
        $status,
        $notelp_pasien,
        $nm_kk, // Changed from no_kk to nm_kk
        $hubungan_keluarga,
        $no_pasien
    );

    if ($update_stmt->execute()) {
        header("Location: data-pasien.php");
        exit();
    } else {
        echo "Error updating record: " . $update_stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pasien</title>
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
            font-size: 2rem;
            color: #333;
        }

        form {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        form div {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        form input,
        form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        form button {
            background: rgb(7, 221, 192);
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        form button:hover {
            background: rgb(6, 194, 169);
        }
    </style>
</head>

<body>
    <h1>Edit Data Pasien</h1>
    <form method="POST">
        <div>
            <label for="nama_pasien">Nama Pasien:</label>
            <input type="text" id="nama_pasien" name="nama_pasien" value="<?php echo $pasien['nama_pasien']; ?>"
                required>
        </div>
        <div>
            <label for="jk_pasien">Jenis Kelamin:</label>
            <select id="jk_pasien" name="jk_pasien" required>
                <option value="Laki-laki" <?php echo $pasien['jk_pasien'] === 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki
                </option>
                <option value="Perempuan" <?php echo $pasien['jk_pasien'] === 'Perempuan' ? 'selected' : ''; ?>>Perempuan
                </option>
            </select>
        </div>
        <div>
            <label for="alamat_pasien">Alamat:</label>
            <input type="text" id="alamat_pasien" name="alamat_pasien" value="<?php echo $pasien['alamat_pasien']; ?>"
                required>
        </div>
        <div>
            <label for="tgl_lahir">Tanggal Lahir:</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" value="<?php echo $pasien['tgl_lahir']; ?>" required>
        </div>
        <div>
            <label for="usia">Usia:</label>
            <input type="number" id="usia" name="usia" value="<?php echo $pasien['usia']; ?>" readonly>
        </div>
        <script>
            // Automatically calculate age based on the selected date of birth
            document.getElementById('tgl_lahir').addEventListener('change', function () {
                const birthDate = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById('usia').value = age;
            });
        </script>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Menikah" <?php echo $pasien['status'] === 'Sudah Menikah' ? 'selected' : ''; ?>>Sudah Menikah
                </option>
                <option value="Belum Menikah" <?php echo $pasien['status'] === 'Belum Menikah' ? 'selected' : ''; ?>>
                    Belum Menikah</option>

            </select>
        </div>
        <div>
            <label for="notelp_pasien">No. Telepon:</label>
            <input type="text" id="notelp_pasien" name="notelp_pasien" value="<?php echo $pasien['notelp_pasien']; ?>"
                required>
        </div>
        <div>
            <label for="nm_kk">NM. KK:</label>
            <input type="text" id="nm_kk" name="nm_kk" value="<?php echo $pasien['nm_kk']; ?>" required>
        </div>
        <div>
            <label for="hubungan_keluarga">Hubungan Keluarga:</label>
            <input type="text" id="hubungan_keluarga" name="hubungan_keluarga"
                value="<?php echo $pasien['hubungan_keluarga']; ?>" required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>

</html>