<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hermes_medica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is an admin
function handleAdminLogin($conn, $user_id, $user_password)
{
    $sql = "SELECT Id_admin, Password FROM admin WHERE Id_admin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($user_password === $row['Password']) { // Plain text comparison
            $_SESSION['role'] = 'admin'; // Set role as admin
            $_SESSION['user_id'] = $row['Id_admin'];
            header("Location: dashboard.php");
            exit();
        }
    }
    return false;
}

$user_id = $_POST['Id_user'];
$user_password = $_POST['Password'];

if (empty($user_id) || empty($user_password)) {
    echo "User ID or Password cannot be empty.";
    exit();
}

// Check if the user is an admin
if (handleAdminLogin($conn, $user_id, $user_password)) {
    exit();
}

// Check if the user is a doctor
$sql = "SELECT Id_user, nama_dokter, Spesialis, Foto_dokter, Password FROM user_doctor WHERE Id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($user_password, $row['Password'])) {
        $_SESSION['role'] = 'doctor'; // Set role as doctor
        $_SESSION['user_id'] = $row['Id_user'];
        $_SESSION['nama'] = $row['nama_dokter'];
        $_SESSION['spesialis'] = $row['Spesialis'];
        $_SESSION['Foto_dokter'] = base64_encode($row['Foto_dokter']);

        header("Location: dashboard.php");
        exit();
    }
}

echo "<script>alert('Invalid User ID or Password.'); window.location.href='loginpage.php';</script>";

$stmt->close();
$conn->close();
?>