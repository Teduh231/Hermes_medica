<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php"); // Redirect if not an admin
    exit();
}

// DB connection (you might want to put this in a separate file)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hermes_medica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['add_doctor'])) {
    // Get doctor data from the form
    $new_user_id = $_POST['new_Id_user'];
    $new_password = $_POST['new_Password'];
    $new_nama_dokter = $_POST['new_nama_dokter'];
    $new_spesialis = $_POST['new_Spesialis'];
    // Handle file upload for Foto_dokter (this is a simplified example)
    $new_foto_dokter = file_get_contents($_FILES['new_Foto_dokter']['tmp_name']);

    // Prepare and execute the SQL query to insert the new doctor
    $sql_insert = "INSERT INTO user_doctor (Id_user, Password, nama_dokter, Spesialis, Foto_dokter) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssssb", $new_user_id, $new_password, $new_nama_dokter, $new_spesialis, $new_foto_dokter);

    if ($stmt_insert->execute()) {
        echo "<p style='color: green;'>New doctor added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error adding doctor: " . $stmt_insert->error . "</p>";
    }

    $stmt_insert->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Console</title>
</head>
<body>
    <h1>Admin Console</h1>
    <p><a href="logout.php">Logout</a></p>

    <h2>Add New Doctor</h2>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="new_Id_user">User ID:</label>
            <input type="text" name="new_Id_user" required>
        </div>
        <div>
            <label for="new_Password">Password:</label>
            <input type="password" name="new_Password" required>
        </div>
        <div>
            <label for="new_nama_dokter">Nama Dokter:</label>
            <input type="text" name="new_nama_dokter" required>
        </div>
        <div>
            <label for="new_Spesialis">Spesialis:</label>
            <input type="text" name="new_Spesialis">
        </div>
        <div>
            <label for="new_Foto_dokter">Foto Dokter:</label>
            <input type="file" name="new_Foto_dokter">
        </div>
        <button type="submit" name="add_doctor">Add Doctor</button>
    </form>
</body>
</html>