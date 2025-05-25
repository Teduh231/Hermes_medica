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
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $nama_pasien = $_POST['nama_pasien'];
    $jk_pasien = $_POST['jk_pasien'];
    $notelp_pasien = $_POST['notelp_pasien'];
    $alamat_pasien = $_POST['alamat_pasien'];
    $usia = (int) $_POST['usia'];
    $tgl_lahir = $_POST['tgl_lahir_tahun'] . '-' . $_POST['tgl_lahir_bulan'] . '-' . $_POST['tgl_lahir_hari'];
    $status = $_POST['status'];
    $no_kk = $_POST['no_kk'];
    $hubungan_keluarga = $_POST['hubungan_keluarga'];

    $sql = "INSERT INTO pasien (nama_pasien, jk_pasien, notelp_pasien, alamat_pasien, usia, tgl_lahir, status, no_kk, hubungan_keluarga) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    $stmt->bind_param(
        "ssssissss",
        $nama_pasien,
        $jk_pasien,
        $notelp_pasien,
        $alamat_pasien,
        $usia,
        $tgl_lahir,
        $status,
        $no_kk,
        $hubungan_keluarga
    );

    if ($stmt->execute()) {
        echo "<script>alert('Data pasien berhasil ditambahkan.'); window.location.href='pasien.php';</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pasien</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin-top: 40px;
        }

        .form-container {
            background: #fff;
            padding: 32px 24px 24px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            margin-top: 32px;
        }

        h1 {
            text-align: center;
            font-size: 1.7rem;
            margin-bottom: 0;
        }

        .form-container>p {
            text-align: center;
            margin-top: 4px;
            margin-bottom: 24px;
            color: #555;
            font-size: 1rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #222;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            background: #fafafa;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            min-height: 38px;
        }

        .radio-group {
            display: flex;
            gap: 24px;
            margin-bottom: 18px;
        }

        .radio-group label {
            display: inline;
            font-weight: normal;
            margin-left: 4px;
            margin-right: 16px;
        }

        input[type="radio"] {
            accent-color: #003366;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px 0;
            background-color: #142e6e;
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
            background-color: #0d2047;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form-container">
            <h1>Pasien Baru</h1>
            <p>Tolong isi data pasien</p>
            <form method="POST" action="">
                <label for="nama_pasien">Nama Pasien:</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required>

                <label for="jk_pasien">Jenis kelamin</label>
                <div class="radio-group">
                    <input type="radio" id="jk_l" name="jk_pasien" value="Laki-laki" required>
                    <label for="jk_l">Laki-laki</label>
                    <input type="radio" id="jk_p" name="jk_pasien" value="Perempuan" required>
                    <label for="jk_p">Perempuan</label>
                </div>

                <label for="notelp_pasien">No. Telepon:</label>
                <input type="text" id="notelp_pasien" name="notelp_pasien" maxlength="11" required>

                <label for="alamat_pasien">Alamat:</label>
                <textarea id="alamat_pasien" name="alamat_pasien" required></textarea>

                <label for="usia">Usia:</label>
                <input type="number" id="usia" name="usia" required>

                <label for="tgl_lahir">Tanggal Lahir:</label>
                <div style="display: flex; gap: 8px; margin-bottom: 18px;">
                    <select id="tgl_lahir_hari" name="tgl_lahir_hari" required style="flex:1;">
                        <option value="">Hari</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= sprintf('%02d', $i) ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <select id="tgl_lahir_bulan" name="tgl_lahir_bulan" required style="flex:1;">
                        <option value="">Bulan</option>
                        <?php
                        $bulan = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];
                        foreach ($bulan as $num => $nama): ?>
                            <option value="<?= sprintf('%02d', $num) ?>"><?= $nama ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="tgl_lahir_tahun" name="tgl_lahir_tahun" required style="flex:1;">
                        <option value="">Tahun</option>
                        <?php for ($i = 2025; $i >= 1930; $i--): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <label for="status">Status:</label>
                <div class="radio-group">
                    <input type="radio" id="sudah_menikah" name="status" value="Sudah menikah" required>
                    <label for="sudah_menikah">Sudah menikah</label>
                    <input type="radio" id="belum_menikah" name="status" value="Belum menikah" required>
                    <label for="belum_menikah">Belum menikah</label>
                </div>

                <label for="no_kk">Nomor kartu Keluarga:</label>
                <input type="text" id="no_kk" name="no_kk" maxlength="11" required>

                <label for="hubungan_keluarga">Hubungan Keluarga:</label>
                <input type="text" id="hubungan_keluarga" name="hubungan_keluarga" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>