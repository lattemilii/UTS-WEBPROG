<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nama_matkul = $_POST['Nama_Matkul'] ?? '';
    $sks = $_POST['sks'] ?? '';
    $semester = $_POST['Semester'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');    


    $stmt = $con->prepare("INSERT INTO mata_kuliah (Kode_Matkul, Nama_Matkul, SKS, Semester, User_Input, Tanggal_Input) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $kode_matkul, $nama_matkul, $sks, $semester, $user_input, $tanggal_input);
    if($stmt->execute()) {
        header("Location: MsMatkul.php");
    } else {
        echo "Data gagal masuk " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah</title>
    <link rel="stylesheet" href="MsMatkul.css">
</head>
<body>
<div class="container">
    <h1>Tambah Mata Kuliah</h1>
    <form method="post" action="TambahMatkul.php">
        <div class = "form-group">
            <label for="Kode_Matkul">Kode Mata Kuliah:</label>
            <input type="text" id="Kode_Matkul" name="Kode_Matkul" required>
        </div>
        <div class = "form-group">
            <label for="Nama_Matkul">Nama Mata Kuliah:</label>
            <input type="text" id="Nama_Matkul" name="Nama_Matkul" required>
        </div>
        <div class = "form-group">
            <label for="sks">SKS:</label>
            <input type="text" id="sks" name="sks" required>
        </div>
        <div class = "form-group">
            <label for="Semester">Semester:</label>
            <input type="text" id="Semester" name="Semester" required>
        </div>
        <button type="submit" class="btn" >Tambah</button>
        <button type="button" class="btn" onclick="window.location.href='MsMatkul.php'">Batal</button>
    </form>
</div>
</body>
</html>