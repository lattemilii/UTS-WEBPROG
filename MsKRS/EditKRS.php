<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (isset($_GET['Kode_Matkul'])) {
    $kode_matkul = $_GET['Kode_Matkul'];
    $stmt = $con->prepare("SELECT * FROM krs WHERE Kode_Matkul = ?");
    $stmt->bind_param("s", $kode_matkul);
    $stmt->execute();
    $result = $stmt->get_result();
    $krs = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nik_dosen = $_POST['NIK_Dosen'] ?? '';
    $nim_mahasiswa = $_POST['NIM_Mahasiswa'] ?? '';
    $hari_matkul = $_POST['Hari_Matkul'] ?? '';
    $ruangan = $_POST['Ruangan'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    $stmt = $con->prepare("UPDATE krs SET NIK_Dosen = ?, NIM_Mahasiswa = ?, Hari_Matkul = ?, Ruangan = ?, User_Input = ?, Tanggal_Input = ? WHERE Kode_Matkul = ?");
    $stmt->bind_param("sssssss", $nik_dosen, $nim_mahasiswa, $hari_matkul, $ruangan, $user_input, $tanggal_input, $kode_matkul);
    if ($stmt->execute()) {
        header("Location: MsKRS.php");
        exit();
    } else {
        echo "Data gagal diupdate " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit KRS</title>
    <link rel="stylesheet" href="MsKRS.css">
</head>
<body>
<div class="container">
    <h1>Edit KRS</h1>
    <form action="EditKRS.php?Kode_Matkul=<?php echo htmlspecialchars($kode_matkul); ?>" method="post">
        <div class="form-group">
            <label for="kode_matkul">Kode Matkul:</label>
            <input type="text" id="kode_matkul" name="Kode_Matkul" value="<?php echo htmlspecialchars($krs['Kode_Matkul'] ?? ''); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nik_dosen">NIK Dosen:</label>
            <input type="text" id="nik_dosen" name="NIK_Dosen" value="<?php echo htmlspecialchars($krs['NIK_Dosen'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="nim_mahasiswa">NIM Mahasiswa:</label>
            <input type="text" id="nim_mahasiswa" name="NIM_Mahasiswa" value="<?php echo htmlspecialchars($krs['NIM_Mahasiswa'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="hari_matkul">Hari Matkul:</label>
            <input type="text" id="hari_matkul" name="Hari_Matkul" value="<?php echo htmlspecialchars($krs['Hari_Matkul'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="ruangan">Ruangan:</label>
            <input type="text" id="ruangan" name="Ruangan" value="<?php echo htmlspecialchars($krs['Ruangan'] ?? ''); ?>" required>
        </div>
        <button type="submit" name="edit" class="btn">Simpan Perubahan</button>
        <button type="button" class="btn" onclick="window.location.href='DeleteKRS.php?Kode_Matkul=<?php echo htmlspecialchars($kode_matkul); ?>'">Hapus</button>
        <button type="button" class="btn" onclick="window.location.href='MsKRS.php'">Batal</button>
    </form>
</div>
</body>
</html>
