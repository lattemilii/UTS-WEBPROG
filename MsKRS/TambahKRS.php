<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nik_dosen = $_POST['NIK_Dosen'] ?? '';
    $nim_mahasiswa = $_POST['NIM_Mahasiswa'] ?? '';
    $hari_matkul = $_POST['Hari_Matkul'] ?? '';
    $jam_matkul = $_POST['Jam_Matkul'] ?? '';
    $ruangan = $_POST['Ruangan'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    $cek_ruangan = $con->prepare("SELECT 1 FROM krs WHERE Ruangan = ? AND Hari_Matkul = ? AND Jam_Matkul = ?");
    $cek_ruangan->bind_param("sss", $ruangan, $hari_matkul, $jam_matkul);
    $cek_ruangan->execute();
    $cek_ruangan->store_result();
    if ($cek_ruangan->num_rows > 0) {
        header("Location: TambahKRS.php?error=Ruangan sudah digunakan di hari dan jam yang sama");
        exit();
    }

    $cek_matkul = $con->prepare("SELECT 1 FROM mata_kuliah WHERE Kode_Matkul = ?");
    $cek_matkul->bind_param("s", $kode_matkul);
    $cek_matkul->execute();
    $cek_matkul->store_result();
    if ($cek_matkul->num_rows == 0) {
        header("Location: TambahKRS.php?error=Kode mata kuliah tidak ditemukan");
        exit();
    }

    $cek_dosen = $con->prepare("SELECT 1 FROM dosen WHERE NIK = ?");
    $cek_dosen->bind_param("s", $nik_dosen);
    $cek_dosen->execute();
    $cek_dosen->store_result();
    if ($cek_dosen->num_rows == 0) {
        header("Location: TambahKRS.php?error=NIK dosen tidak ditemukan");
        exit();
    }

    $cek_mahasiswa = $con->prepare("SELECT 1 FROM mahasiswa WHERE NIM = ?");
    $cek_mahasiswa->bind_param("s", $nim_mahasiswa);
    $cek_mahasiswa->execute();
    $cek_mahasiswa->store_result();
    if ($cek_mahasiswa->num_rows == 0) {
        header("Location: TambahKRS.php?error=NIM mahasiswa tidak ditemukan");
        exit();
    }

    $cek_krs = $con->prepare("SELECT 1 FROM krs WHERE Kode_Matkul = ? AND NIM_Mahasiswa = ?");
    $cek_krs->bind_param("ss", $kode_matkul, $nim_mahasiswa);
    $cek_krs->execute();
    $cek_krs->store_result();
    if ($cek_krs->num_rows > 0) {
        header("Location: TambahKRS.php?error=Mahasiswa sudah mengambil mata kuliah ini");
        exit();
    }

    $cek_dosen_matkul = $con->prepare("SELECT NIK_Dosen FROM krs WHERE Kode_Matkul = ?");
    $cek_dosen_matkul->bind_param("s", $kode_matkul);
    $cek_dosen_matkul->execute();
    $cek_dosen_matkul->bind_result($existing_nik_dosen);
    $cek_dosen_matkul->fetch();
    $cek_dosen_matkul->close();
    
    if ($existing_nik_dosen && $existing_nik_dosen !== $nik_dosen) {
        header("Location: TambahKRS.php?error=Mata kuliah sudah diajar oleh dosen lain");
        exit();
    }

    $cek_jam_dosen = $con->prepare("SELECT 1 FROM krs WHERE NIK_Dosen = ? AND Hari_Matkul = ? AND Jam_Matkul = ?");
    $cek_jam_dosen->bind_param("sss", $nik_dosen, $hari_matkul, $jam_matkul);
    $cek_jam_dosen->execute();
    $cek_jam_dosen->store_result();
    if ($cek_jam_dosen->num_rows > 0) {
        header("Location: TambahKRS.php?error=Dosen sudah mengajar mata kuliah lain di jam yang sama");
        exit();
    }

    
    $insert = $con->prepare("INSERT INTO krs (Kode_Matkul, NIK_Dosen, NIM_Mahasiswa, Hari_Matkul, Jam_Matkul, Ruangan, User_Input, Tanggal_Input) VALUES (?,?,?,?,?,?,?,?)");
    $insert->bind_param("ssssssss", $kode_matkul, $nik_dosen, $nim_mahasiswa, $hari_matkul, $jam_matkul, $ruangan, $user_input, $tanggal_input);
    if ($insert->execute()) {
        header("Location: MsKRS.php");
    } else {
        echo "Data gagal masuk " . $insert->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah KRS</title>
    <link rel="stylesheet" href="MsKRS.css">
</head>
<body>
    <div class="container">
        <h1>Tambah KRS</h1>
        <form action="TambahKRS.php" method="post">
            <div class="form-group">
                <label for="kode_matkul">Kode Matkul:</label>
                <input type="text" id="kode_matkul" name="Kode_Matkul" required>
            </div>
            <div class="form-group">
                <label for="nik_dosen">NIK Dosen:</label>
                <input type="text" id="nik_dosen" name="NIK_Dosen" required>
            </div>
            <div class="form-group">
                <label for="nim_mahasiswa">NIM Mahasiswa:</label>
                <input type="text" id="nim_mahasiswa" name="NIM_Mahasiswa" required>
            </div>
            <div class="form-group">
                <label for="hari_matkul">Hari Matkul:</label>
                <select id="hari_matkul" name="Hari_Matkul" required>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ruangan">Ruangan:</label>
                <input type="text" id="ruangan" name="Ruangan" required>
            </div>
            <div class="form-group">
                <label for="jam_matkul">Jam Matkul:</label>
                <input type="time" id="jam_matkul" name="Jam_Matkul" required>
            </div>
            <button type="submit" class="btn">Tambah</button>
            <button type="button" class="btn" onclick="window.location.href='MsKRS.php'">Kembali</button>
        </form>
    </div>
</body>
</html>

