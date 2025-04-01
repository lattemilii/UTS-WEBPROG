<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['NIK'] ?? '';
    $nama = $_POST['Nama'] ?? '';
    $gelar = $_POST['Gelar'] ?? '';
    $lulusan = $_POST['Lulusan'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $email = $_POST['email'] ?? '';
    $telp = $_POST['Telp'] ?? '';
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
                        <td><?php echo htmlspecialchars($d['Nama']); ?></td>
                        <td><?php echo htmlspecialchars($d['dob']); ?></td>
                        <td><?php echo htmlspecialchars($d['Gelar']); ?></td>
                        <td><?php echo htmlspecialchars($d['Lulusan']); ?></td>
                        <td><?php echo htmlspecialchars($d['email']); ?></td>
                        <td><?php echo htmlspecialchars($d['Telp']); ?></td>
                        <td><?php echo htmlspecialchars($d['User_Input']); ?></td>
                        <td><?php echo htmlspecialchars($d['Tanggal_Input']); ?></td>
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