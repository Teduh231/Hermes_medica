<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: loginpage.php");
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

// Query to get the total number of patients
$sql_total_patients = "SELECT COUNT(*) AS total_patients FROM pasien";
$result_total_patients = $conn->query($sql_total_patients);
$total_patients = $result_total_patients->fetch_assoc()['total_patients'];

// Query to get the total number of visits
$sql_total_visits = "SELECT COUNT(*) AS total_visits FROM rekam_medis";
$result_total_visits = $conn->query($sql_total_visits);
$total_visits = $result_total_visits->fetch_assoc()['total_visits'];

$conn->close();
?>
<style>
    .welcome-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px auto;
        margin-top: 150px; /* Adjusted for better positioning */
        padding: 30px; /* Increased padding */
        max-width: 1000px; /* Increased width */
        height: 400px; /* Increased height */
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px; /* Slightly larger border radius */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Slightly stronger shadow */
        opacity: 0; /* Start hidden for animation */
        transform: translateX(-50px); /* Start position for animation */
        animation: fadeInSlide 1s ease-out forwards; /* Animation */
    }

    @keyframes fadeInSlide {
        to {
            opacity: 1;
            transform: translateX(0); /* Slide into place */
        }
    }

    .welcome-text {
        flex: 1;
        padding: 30px; /* Increased padding */
    }

    .welcome-text h1 {
        font-size: 28px; /* Slightly larger font size */
        font-weight: bold;
        margin-bottom: 15px; /* Increased margin */
        color: #333;
    }

    .welcome-text p {
        font-size: 18px; /* Slightly larger font size */
        line-height: 1.6; /* Adjusted line height */
        color: #555;
    }

    .welcome-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-placeholder {
        width: 400px; /* Original width */
        height: 400px; /* Original height */
        background-color: #e0e0e0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px; /* Original font size */
        border-radius: 15px; /* Original border radius */
    }

    .image-placeholder img {
        max-width: 100%; /* Ensure the image fits within the placeholder */
        max-height: 100%; /* Ensure the image fits within the placeholder */
        object-fit: contain; /* Maintain aspect ratio */
    }

    .stats-container {
        margin: 20px auto;
        max-width: 1000px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stat-box {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 200px;
    }

    .stat-box h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .stat-box p {
        font-size: 18px;
        color: #555;
    }
</style>
<div class="welcome-container">
    <div class="welcome-text">
        <h1>Selamat Datang Dokter</h1>
        <p>Mari Kita Bersama-sama<br>Berusaha Untuk Menyembuhkan Dunia</p>
    </div>
    <div class="welcome-image">
        <div class="image-placeholder">
            <img src="img/sambutan.png" alt="Welcome Image">
        </div>
    </div>
</div>

<div class="stats-container">
    <div class="stat-box">
        <h2><?php echo $total_patients; ?></h2>
        <p>Jumlah Pasien</p>
    </div>
    <div class="stat-box">
        <h2><?php echo $total_visits; ?></h2>
        <p>Total Kunjungan</p>
    </div>
</div>
