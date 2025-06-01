<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/dropdown.css" />
</head>

<body>
  <div class="header">
    <div class="icon">
      <img src="img/hermes-logo.png" alt="hermes" width="43px" height="43px" />
    </div>
    <div style="color: white; font-size: 23px">Hermes Medica</div>

    <?php if ($_SESSION['role'] === 'doctor'): ?>
      <!-- Dropdown for Doctor -->
      <div class="user-dropdown">
        <div class="dropdown-trigger" style="margin-left: 6rem">
          <img src="data:image/jpeg;base64,<?php echo $_SESSION['Foto_dokter']; ?>" alt="User" width="40px" height="40px"
            style="border-radius: 50%; margin-left: 20px; cursor: pointer" />
          <h4 style="color: white; margin-left: 5px">
            <?php echo $_SESSION['nama']; ?>
          </h4>
        </div>
        <div class="dropdown-content">
          <div class="dropdown-info">
            <img src="data:image/jpeg;base64,<?php echo $_SESSION['Foto_dokter']; ?>" alt="User" width="55px"
              height="55px" style="border-radius: 50%; cursor: pointer" />
            <div>
              <span style="color: black; font-size: 20px; margin-left: 5px"><?php echo $_SESSION['nama']; ?></span>
              <span style="color: black; margin-left: 5px">Spesialis: <?php echo $_SESSION['spesialis']; ?></span>
            </div>
          </div>
          <div class="dropdown-links">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Log out</a>
          </div>
        </div>
      </div>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
      <!-- Logout Button for Admin -->
      <div class="admin-logout" style="margin-left: auto; margin-right: 20px;">
        <a href="logout.php" style="color: white; font-size: 18px; text-decoration: none; background-color: #007bff; padding: 10px 20px; border-radius: 5px;">Log out</a>
      </div>
    <?php endif; ?>
  </div>

  <script src="js/dropdown.js"></script>
</body>

</html>