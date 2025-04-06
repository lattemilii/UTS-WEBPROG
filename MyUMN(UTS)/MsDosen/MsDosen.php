<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['NIK'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $gelar = $_POST['gelar'] ?? '';
    $lulusan = $_POST['lulusan'] ?? '';
    $dob = $_POST['DOB'] ?? '';
    $email = $_POST['email'] ?? '';
    $telp = $_POST['no_telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');
    }

$result = $con->query("SELECT * FROM dosen");
$dosen = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Lecturer</title>
    <link rel="stylesheet" href="MsDosen.css">
</head>
<body>
<div class="container">
    <h1>Master Lecturer</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>DOB</th>
                    <th>Gelar</th>
                    <th>Lulusan</th>
                    <th>Email</th>
                    <th>Telp</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dosen as $d): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($d['NIK']); ?></td>
                        <td><?php echo htmlspecialchars($d['nama']); ?></td>
                        <td><?php echo htmlspecialchars($d['DOB']); ?></td>
                        <td><?php echo htmlspecialchars($d['gelar']); ?></td>
                        <td><?php echo htmlspecialchars($d['lulusan']); ?></td>
                        <td><?php echo htmlspecialchars($d['email']); ?></td>
                        <td><?php echo htmlspecialchars($d['no_telp']); ?></td>
                        <td><?php echo htmlspecialchars($d['user_input']); ?></td>
                        <td><?php echo htmlspecialchars($d['tanggal_input']); ?></td>
                        <td>
                            <button onclick="location.href='EditDosen.php?NIK=<?php echo $d['NIK']; ?>'">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button onclick="location.href='TambahDosen.php'" class="btn">Tambah Dosen</button>
    <button onclick="location.href='../MainMenu/MainMenu.php'"class="btn" >Kembali</button>
</div>
</body>
</html>