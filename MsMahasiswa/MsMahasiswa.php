<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['NIM'] ??'';
    $nama = $_POST['Nama'] ?? '';
    $tahun_masuk = $_POST['Tahun_Masuk'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $prodi = $_POST['Prodi'] ?? '';
    $alamat = $_POST['Alamat'] ?? '';
    $telp = $_POST['Telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $email = $_POST['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');
    }
$result = $con->query("SELECT * FROM mahasiswa");
$mahasiswa = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Student</title>
    <link rel="stylesheet" href="MsMahasiswa.css">
</head>
<body>
<div class="container">
    <h1>Master Student</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tahun Masuk</th>
                    <th>Prodi</th>
                    <th>DOB</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Email</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswa as $m): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($m['NIM']); ?></td>
                        <td><?php echo htmlspecialchars($m['Nama']); ?></td>
                        <td><?php echo htmlspecialchars($m['Tahun_Masuk']); ?></td>
                        <td><?php echo htmlspecialchars($m['Prodi']); ?></td>
                        <td><?php echo htmlspecialchars($m['dob']); ?></td>
                        <td><?php echo htmlspecialchars($m['Alamat']); ?></td>
                        <td><?php echo htmlspecialchars($m['Telp']); ?></td>
                        <td><?php echo htmlspecialchars($m['email']); ?></td>
                        <td><?php echo htmlspecialchars($m['User_Input']); ?></td>
                        <td><?php echo htmlspecialchars($m['Tanggal_Input']); ?></td>
                        <td>
                        <button onclick="location.href='EditMahasiswa.php?NIM=<?php echo $m['NIM']; ?>'">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button onclick="location.href='TambahMahasiswa.php'" class="btn">Tambah Mahasiswa</button>
    <button onclick="location.href='../MainMenu/MainMenu.php'"class="btn" >Kembali</button>
</div>
</body>
</html>