<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (!isset($_GET['NIK'])) {
    echo "NIK tidak ditemukan.";
    exit();
}

$nik = $_GET['NIK'];
$stmt = $con->prepare("SELECT * FROM dosen WHERE NIK = ?");
$stmt->bind_param("s", $nik);
$stmt->execute();
$result = $stmt->get_result();
$dosen = $result->fetch_assoc();

if (!$dosen) {
    echo "Data dosen tidak ditemukan.";
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
    <title>Edit Dosen</title>
</head>
<body>
<?php endif; ?>
<div class="modal-content">
    <h2 class="judul">Edit Dosen</h2>

    <form method="POST" action="MsDosen.php" id="formEditDosen" enctype="multipart/form-data" class="form-edit">
        <div class="form-group">
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="NIK" value="<?= htmlspecialchars($dosen['NIK']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($dosen['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label for="dob">DOB:</label>
            <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($dosen['DOB']) ?>" required>
        </div>
        <div class="form-group">
            <label for="gelar">Gelar:</label>
            <input type="text" id="gelar" name="gelar" value="<?= htmlspecialchars($dosen['gelar']) ?>" required>
        </div>
        <div class="form-group">
            <label for="lulusan">Lulusan:</label>
            <input type="text" id="lulusan" name="lulusan" value="<?= htmlspecialchars($dosen['lulusan']) ?>" required>
        </div>
        <div class="form-group">
            <label for="no_telp">Telp:</label>
            <input type="text" id="no_telp" name="no_telp" value="<?= htmlspecialchars($dosen['no_telp']) ?>" required>
        </div>

        <input type="hidden" name="action" value="edit">

        <div class="button-group">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <button type="button" class="btn btn-danger" onclick="if(confirm('Yakin ingin menghapus data ini?')) window.location.href='DeleteDosen.php?NIK=<?= $dosen['NIK'] ?>'">Hapus</button>
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