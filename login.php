<?php
session_start();

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hermes_medica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle admin login
function handleAdminLogin($conn, $user_id, $user_password) {
    // Define the unique admin credentials (replace with your actual admin credentials)
    $admin_user_id = "admin";
    $admin_password = "admin123";

    if ($user_id === $admin_user_id && $user_password === $admin_password) {
        $_SESSION['is_admin'] = true;
        header("Location: adminpanel.php"); // Redirect to admin console
        exit();
    }
    return false; // Not an admin login
}

// Get form input
$user_id = $_POST['Id_user'];
$user_password = $_POST['Password'];

if (empty($user_id) || empty($user_password)) {
    echo "User ID or Password cannot be empty.";
    exit();
}

// Check for admin login first
if (handleAdminLogin($conn, $user_id, $user_password)) {
    exit(); // Stop further execution if admin login was successful
}

// Prepare query for doctor login
$sql = "SELECT Id_user, nama_dokter, Spesialis, Foto_dokter FROM user_doctor WHERE Id_user = ? AND Password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_id, $user_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    $_SESSION['user_id'] = $row['Id_user'];
    $_SESSION['nama'] = $row['nama_dokter'];
    $_SESSION['spesialis'] = $row['Spesialis'];
    $_SESSION['Foto_dokter'] = base64_encode($row['Foto_dokter']);

    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid User ID or Password.";
}

$stmt->close();
$conn->close();
?>