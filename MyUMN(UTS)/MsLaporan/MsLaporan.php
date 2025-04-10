<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || !isset($_SESSION['email'])) {
    header("Location: ../LoginPage/Login.php");
    exit();
}

function formatName($name) {
    $parts = explode('.', $name);
    $formattedParts = array_map('ucfirst', $parts);
    return implode(' ', $formattedParts);
}

$email = $_SESSION['email'] ?? '';
$name = formatName(explode('@', $email)[0]);

$role = $_SESSION['role'];
$email = $_SESSION['email'];
$jadwal = [];

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($role == 'dosen') {
    $sql = "SELECT * FROM v_krs_dosen WHERE Email_Dosen = ?";
} elseif ($role == 'mahasiswa') {
    $sql = "SELECT * FROM v_krs_mahasiswa WHERE Email_Mahasiswa = ?";
} else {
    header("Location: ../LoginPage/Login.php");
    exit();
}

$stmt = $con->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $con->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $jadwal = $result->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();

function calculateTimeRange($startTime, $sks) {
    $start = new DateTime($startTime);
    $end = clone $start;
    $end->modify('+' . ($sks * 1) . ' hours');
    return $start->format('H:i:s') . '-' . $end->format('H:i:s');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="MsLaporan.css">
</head>
<body>
<div class="container">
    <div class="navbar">
        <div class="navbar-left">
            <div class="logo">
                <img src="../assets/UMN.png" alt="UMN Logo">
            </div>
            <div class="links">
                <a href="../MainMenu/MainMenu.php">Menu</a>
            </div>
        </div>
        <div class="profile">
            <span><?php echo htmlspecialchars($name); ?></span>
            <div class="avatar">
                <img src="../assets/profile-picture.png" alt="Profile Picture">
            </div>
        </div>
    </div>

    <h1 class="judul">Report</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Matkul</th>
                    <th>Nama Matkul</th>
                    <th>SKS</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <?php if ($role == 'mahasiswa'): ?>
                        <th>Dosen Pengajar</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($jadwal)): ?>
                    <tr>
                        <td colspan="<?= $role == 'mahasiswa' ? 7 : 6 ?>" style="text-align: center;">Tidak ada data</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($jadwal as $j): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($j['Kode_Matkul']); ?></td>
                            <td><?php echo htmlspecialchars($j['nama_matkul']); ?></td>
                            <td><?php echo htmlspecialchars($j['sks']); ?></td>
                            <td><?php echo htmlspecialchars($j['hari_matkul']); ?></td>
                            <td>
                                <?php echo calculateTimeRange($j['jam_matkul'], $j['sks']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($j['ruangan']); ?></td>
                            <?php if ($role == 'mahasiswa' && isset($j['nama_dosen'])): ?>
                                <td><?php echo htmlspecialchars($j['nama_dosen']); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>