<?php
session_start();

$users = [
    'admin' => ['email' => 'Yaqub.Salamander@admin.umn.ac.id', 'password' => 'admin123'],
    'dosen' => ['email' => 'Djawa.Tsunda@lecturer.umn.ac.id', 'password' => 'dosen123'],
    'mahasiswa' => ['email' => 'Tjan.Malaka@student.umn.ac.id', 'password' => 'mahasiswa123']
];

function getRoleByEmail($email) {
    $domain = explode('@', $email)[1];
    if ($domain == 'admin.umn.ac.id') {
        return 'admin';
    } elseif ($domain == 'lecturer.umn.ac.id') {
        return 'dosen';
    } elseif ($domain == 'student.umn.ac.id') {
        return 'mahasiswa';
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = getRoleByEmail($email);

    if ($role && isset($users[$role]) && $users[$role]['email'] === $email && $users[$role]['password'] === $password) {
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        header("Location: ../MainMenu/MainMenu.php");
        exit();
    } else {
        $error = "Login gagal! Periksa kembali email dan password Anda.";
    }
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