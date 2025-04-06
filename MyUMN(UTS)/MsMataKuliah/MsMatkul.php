<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['kode_matkul'];
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $user_input = $_SESSION['email'];
    $tanggal_input = date('Y-m-d H:i:s');    
}
$result = $con->query("SELECT * FROM mata_kuliah");
$mata_kuliah = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Subject</title>
    <link rel="stylesheet" href="MsMatkul.css">
</head>
<body>
<div class="container">
    <h1>Master Subject</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Matkul</th>
                    <th>Nama Matkul</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mata_kuliah as $mk): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mk['kode_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($mk['nama_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($mk['sks']); ?></td>
                        <td><?php echo htmlspecialchars($mk['semester']); ?></td>
                        <td><?php echo htmlspecialchars($mk['user_input']); ?></td>
                        <td><?php echo htmlspecialchars($mk['tanggal_input']); ?></td>
                        <td>
                            <button onclick="location.href='EditMatkul.php?Kode_Matkul=<?php echo $mk['kode_matkul']; ?>' ">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button onclick="location.href='TambahMatkul.php'" class="btn">Tambah Mata Kuliah</button>
    <button onclick="location.href='../MainMenu/MainMenu.php'" class="btn">Kembali</button>
</div>
</body>
</html>