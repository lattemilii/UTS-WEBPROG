<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $con->prepare("SELECT password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbPassword, $dbRole);
        $stmt->fetch();
        
        if (password_verify($password, $dbPassword)) {
            $_SESSION['role'] = $dbRole;
            $_SESSION['email'] = $email;
            header("Location: ../MainMenu/MainMenu.php");
            exit();
        } else {
            $error = "Login gagal! Password salah.";
        }
    } else {
        $error = "Login gagal! Periksa kembali email dan password Anda.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyUMN</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="Login.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-btn">Sign In</button>
    </form>
</div>
</body>
</html>
