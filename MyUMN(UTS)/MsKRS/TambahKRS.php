<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nik_dosen = $_POST['NIK_Dosen'] ?? '';
    $nim_mahasiswa = $_POST['NIM_Mahasiswa'] ?? '';
    $hari_matkul = $_POST['hari_matkul'] ?? '';
    $jam_matkul = $_POST['jam_matkul'] ?? '';
    $ruangan = $_POST['ruangan'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    $cek_matkul = $con->prepare("SELECT 1 FROM mata_kuliah WHERE Kode_Matkul = ?");
    $cek_matkul->bind_param("s", $kode_matkul);
    $cek_matkul->execute();
    $cek_matkul->store_result();
    if ($cek_matkul->num_rows == 0) {
        $error = "Kode mata kuliah tidak ditemukan.";
    }

    $cek_dosen = $con->prepare("SELECT 1 FROM dosen WHERE NIK = ?");
    $cek_dosen->bind_param("s", $nik_dosen);
    $cek_dosen->execute();
    $cek_dosen->store_result();
    if ($cek_dosen->num_rows == 0) {
        $error = "NIK dosen tidak ditemukan.";
    }

    $cek_mahasiswa = $con->prepare("SELECT 1 FROM mahasiswa WHERE NIM = ?");
    $cek_mahasiswa->bind_param("s", $nim_mahasiswa);
    $cek_mahasiswa->execute();
    $cek_mahasiswa->store_result();
    if ($cek_mahasiswa->num_rows == 0) {
        $error = "NIM mahasiswa tidak ditemukan.";
    }

    if (empty($error)) {
        $insert = $con->prepare("INSERT INTO krs (Kode_Matkul, NIK_Dosen, NIM_Mahasiswa, hari_matkul, jam_matkul, ruangan, user_input, tanggal_input) VALUES (?,?,?,?,?,?,?,?)");
        $insert->bind_param("ssssssss", $kode_matkul, $nik_dosen, $nim_mahasiswa, $hari_matkul, $jam_matkul, $ruangan, $user_input, $tanggal_input);
        if ($insert->execute()) {
            header("Location: MsKRS.php");
            exit();
        } else {
            $error = "Data gagal masuk: " . $insert->error;
        }
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
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
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
                <select id="hari_matkul" name="hari_matkul" required>
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
                <input type="text" id="ruangan" name="ruangan" required>
            </div>
            <div class="form-group">
                <label for="jam_matkul">Jam Matkul:</label>
                <input type="time" id="jam_matkul" name="jam_matkul" required>
            </div>
            <button type="submit" class="btn">Tambah</button>
            <button type="button" class="btn" onclick="window.location.href='MsKRS.php'">Kembali</button>
        </form>
    </div>
</body>
</html>