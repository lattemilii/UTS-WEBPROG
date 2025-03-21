<?php
session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['email'])) {
    header("Location: ../LoginPage/Login.php");
    exit();
}

$role = $_SESSION['role'];
$email = $_SESSION['email'];
$name = formatName(explode('@', $email)[0]);

function formatName($name) {
    $parts = explode('.', $name);
    $formattedParts = array_map('ucfirst', $parts);
    return implode(' ', $formattedParts);
}

$menus = [
    'admin' => ['Login', 'Main Menu', 'Master Lecturer', 'Master Student', 'Master Subject', 'KRS Transaction'],
    'dosen' => ['Report'],
    'mahasiswa' => ['Report']
];

$userMenus = $menus[$role] ?? [];
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu - MyUMN</title>
    <link rel="stylesheet" href="MainMenu.css">
    <script>
        function filterMenu() {
            const searchInput = document.getElementById('search').value.toLowerCase();
            const menuItems = document.querySelectorAll('.menu-list li');

            menuItems.forEach(item => {
                const menuText = item.textContent.toLowerCase();
                if (menuText.includes(searchInput)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function clearSearch() {
            document.getElementById('search').value = '';
            filterMenu();
        }
    </script>
</head>
<body>
<h1>Selamat Datang Kembali, <?php echo htmlspecialchars($name); ?></h1>
<div class="menu-container">
    <h2>Menu</h2>
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" oninput="filterMenu()">
    <ul class="menu-list">
        <?php foreach ($userMenus as $menu): ?>
            <li>
                <?php if ($menu == 'Login'): ?>
                    <a href="../LoginPage/Login.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php elseif ($menu == 'Main Menu'): ?>
                    <a href="../MainMenu/MainMenu.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php elseif ($menu == 'Master Lecturer'): ?>
                    <a href="../MsDosen/MsDosen.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php elseif ($menu == 'Master Student'): ?>
                    <a href="../MsMahasiswa/MsMahasiswa.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php elseif ($menu == 'Master Subject'): ?>
                    <a href="../MsMataKuliah/MsMatkul.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php elseif ($menu == 'KRS Transaction'): ?>
                    <a href="../MsKRS/MsKRS.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php elseif ($menu == 'Report'): ?>
                    <a href="../MsLaporan/MsLaporan.php" class="menu-button"><?php echo htmlspecialchars($menu); ?></a>
                <?php else: ?>
                    <button class="menu-button"><?php echo htmlspecialchars($menu); ?></button>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <button class="signout-btn" onclick="showSignOutPopup()">Sign Out</button>
</div>

<div id="signout-popup" class="popup">
    <div class="popup-content">
        <p>Apakah kamu yakin ingin keluar?</p>
        <button onclick="signOut()">Ya</button>
        <button onclick="hideSignOutPopup()">Tidak</button>
    </div>
</div>

<script>
function showSignOutPopup() {
    document.getElementById('signout-popup').style.display = 'block';
}

function hideSignOutPopup() {
    document.getElementById('signout-popup').style.display = 'none';
}

function signOut() {
    window.location.href = '../LogoutSection/Logout.php';
}
</script>
</body>
</html>