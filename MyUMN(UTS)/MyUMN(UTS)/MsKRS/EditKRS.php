<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (!isset($_GET['kode_matkul'])) {
    echo "Kode matkul tidak dikirim.";
    exit();
}
$kode_matkul = $_GET['kode_matkul'];

$stmt = $con->prepare("SELECT * FROM krs WHERE Kode_Matkul = ?");
$stmt->bind_param("s", $kode_matkul);
$stmt->execute();
$result = $stmt->get_result();
$krs = $result->fetch_assoc();

if (!$krs) {
    echo "Data KRS tidak ditemukan.";
    exit();
}
    
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
              strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
?>

<?php if (!$isAjax): ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit KRS</title>
    <link rel="stylesheet" href="MsKRS.css">
</head>
<body>
<?php endif; ?>
<div class="modal-content">
    <h2 class="judul">Edit KRS</h2>

    <form method="POST" action="MsKRS.php" id="formEditKRS" enctype="multipart/form-data" class="form-edit">
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
            <input type="text" id="hari_matkul" name="Hari_Matkul" value="<?php echo htmlspecialchars($krs['hari_matkul'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="ruangan">Ruangan:</label>
            <input type="text" id="ruangan" name="Ruangan" value="<?php echo htmlspecialchars($krs['ruangan'] ?? ''); ?>" required>
        </div>

        <input type="hidden" name="action" value="edit">

        <div class="button-group">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <button type="button" class="btn btn-danger" onclick="if(confirm('Yakin ingin menghapus data ini?')) window.location.href='DeleteKRS.php?Kode_Matkul=<?= $krs['Kode_Matkul'] ?>'">Hapus</button>
        </div>
    </form>

    <img src="../assets/cross-mark.png" alt="Close" class="close-img" onclick="closeModal()">
</div>

<?php if (!$isAjax): ?>
<script>
    function closeModal() {
        document.querySelector(".modal").style.display = "none";
        document.body.classList.remove("modal-open");
    }
</script>
</body>
</html>
<?php endif; ?>