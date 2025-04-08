<?php
session_start();
require '../db.php';

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
    'admin' => [
        ['label' => 'Mahasiswa', 'link' => '../MsMahasiswa/MsMahasiswa.php', 'icon' => '../assets/graduation-cap.png'],
        ['label' => 'Dosen', 'link' => '../MsDosen/MsDosen.php', 'icon' => '../assets/reading.png'],
        ['label' => 'Mata Kuliah', 'link' => '../MsMataKuliah/MsMatkul.php', 'icon' => '../assets/open-book.png'],
        ['label' => 'KRS', 'link' => '../MsKRS/MsKRS.php', 'icon' => '../assets/clipboard.png']
    ],
    'dosen' => [['label' => 'Report', 'link' => '../MsLaporan/MsLaporan.php', 'icon' => '../assets/report.png']],
    'mahasiswa' => [['label' => 'Report', 'link' => '../MsLaporan/MsLaporan.php', 'icon' => '../assets/report.png']]
];

$userMenus = $menus[$role] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Main Menu - MyUMN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MainMenu.css">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="navbar-left">
                <div class="logo">
                    <img src="../assets/UMN.png" alt="UMN Logo">
                </div>
                <div class="links">
                    <a href="#" onclick="showSignOutPopup()">Log Out</a>
                </div>
            </div>
            <div class="profile">
                <span><?php echo htmlspecialchars($name); ?></span>
                <div class="avatar">
                    <img src="../assets/profile-picture.png" alt="Profile Picture">
                </div>
            </div>
        </div>

        <h2>Menu</h2>
        <div class="search-bar">
            <label for="search">Search :</label>
            <input type="text" id="search" oninput="filterMenu()">
        </div>

        <div class="grid-menu" id="menu-grid">
            <?php foreach ($userMenus as $menu): ?>
                <a href="<?= $menu['link'] ?>" class="menu-card">
                    <div class="menu-icon">
                        <img src="<?= $menu['icon'] ?>" alt="<?= htmlspecialchars($menu['label']) ?>">
                    </div>
                    <div class="menu-title"><?= htmlspecialchars($menu['label']) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="popup" id="signout-popup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
        <div class="popup-content" style="background: white; padding: 20px; border-radius: 10px; text-align: center;">
            <p>Yakin ingin keluar?</p>
            <button onclick="signOut()">Ya</button>
            <button onclick="hideSignOutPopup()">Tidak</button>
        </div>
    </div>

    <script>
    function filterMenu() {
        const search = document.getElementById('search').value.toLowerCase();
        const items = document.querySelectorAll('.menu-card');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(search) ? '' : 'none';
        });
    }
    function showSignOutPopup() {
        document.getElementById('signout-popup').style.display = 'flex';
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