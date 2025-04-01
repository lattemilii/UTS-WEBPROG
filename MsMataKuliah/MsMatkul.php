<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'];
    $nama_matkul = $_POST['Nama_Matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['Semester'];
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
                        <td><?php echo htmlspecialchars($mk['Kode_Matkul']); ?></td>
                        <td><?php echo htmlspecialchars($mk['Nama_Matkul']); ?></td>
                        <td><?php echo htmlspecialchars($mk['sks']); ?></td>
                        <td><?php echo htmlspecialchars($mk['Semester']); ?></td>
                        <td><?php echo htmlspecialchars($mk['User_Input']); ?></td>
                        <td><?php echo htmlspecialchars($mk['Tanggal_Input']); ?></td>
                        <td>
                            <button onclick="location.href='EditMatkul.php?Kode_Matkul=<?php echo $mk['Kode_Matkul']; ?>' ">Edit</button>
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