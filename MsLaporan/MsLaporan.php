<?php
session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['email'])) {
    header("Location: ../LoginPage/UserSelection.php");
    exit();
}

$role = $_SESSION['role'];
$email = $_SESSION['email'];

$dsn = 'mysql:host=localhost;dbname=myumn';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

if ($role == 'dosen') {
    $stmt = $db->prepare("SELECT * FROM krs WHERE nik_dosen = ?");
    $stmt->execute([$email]);
    $jadwal = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($role == 'mahasiswa') {
    $stmt = $db->prepare("SELECT * FROM krs WHERE nim_mahasiswa = ?");
    $stmt->execute([$email]);
    $jadwal = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $jadwal = [];
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
    <h1>Report</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Matkul</th>
                    <th>Nama Matkul</th>
                    <th>SKS</th>
                    <th>Hari</th>
                    <th>Ruangan</th>
                    <?php if ($role == 'mahasiswa'): ?>
                        <th>Dosen Pengajar</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal as $j): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($j['kode_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($j['nama_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($j['sks']); ?></td>
                        <td><?php echo htmlspecialchars($j['hari_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($j['ruangan']); ?></td>
                        <?php if ($role == 'mahasiswa'): ?>
                            <td><?php echo htmlspecialchars($j['nik_dosen']); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button class="btn" onclick="window.location.href='../MainMenu/MainMenu.php'">Kembali</button>
</div>
</body>
</html>