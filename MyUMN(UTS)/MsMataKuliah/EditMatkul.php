<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (!isset($_GET['Kode_Matkul'])) {
    echo "Kode matkul tidak dikirim.";
    exit();
}

$kode_matkul = $_GET['Kode_Matkul'];

$stmt = $con->prepare("SELECT * FROM mata_kuliah WHERE Kode_Matkul = ?");
$stmt->bind_param("s", $kode_matkul);
$stmt->execute();
$result = $stmt->get_result();
$matkul = $result->fetch_assoc();

if (!$matkul) {
    echo "Data Mata Kuliah tidak ditemukan.";
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
    <title>Edit Mata Kuliah</title>
    <link rel="stylesheet" href="MsMatkul.css">
</head>
<body>
<?php endif; ?>

<div class="modal-content">
    <h2 class="judul">Edit Mata Kuliah</h2>

    <form method="POST" action="MsMatkul.php" id="formEditMatkul" enctype="multipart/form-data" class="form-edit">
        <div class="form-group">
            <label for="kode_matkul">Kode Matkul:</label>
            <input type="text" id="kode_matkul" name="Kode_Matkul" value="<?= htmlspecialchars($matkul['kode_matkul']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nama_matkul">Nama Matkul:</label>
            <input type="text" id="nama_matkul" name="Nama_Matkul" value="<?= htmlspecialchars($matkul['nama_matkul']) ?>">
        </div>
        <div class="form-group">
            <label for="sks">SKS:</label>
            <input type="number" id="sks" name="sks" value="<?= htmlspecialchars($matkul['sks']) ?>">
        </div>
        <div class="form-group">
            <label for="semester">Semester:</label>
            <input type="number" id="semester" name="Semester" value="<?= htmlspecialchars($matkul['semester']) ?>">
        </div>

        <input type="hidden" name="action" value="edit">
        <div class="button-group">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <button type="button" class="btn btn-danger" onclick="if(confirm('Yakin ingin menghapus data ini?')) window.location.href='DeleteMatkul.php?Kode_Matkul=<?= $matkul['kode_matkul'] ?>'">Hapus</button>
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