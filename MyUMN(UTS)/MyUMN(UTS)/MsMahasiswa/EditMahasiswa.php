<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (!isset($_GET['NIM'])) {
    echo "NIM tidak ditemukan.";
    exit();
}

$nim = $_GET['NIM'];
$stmt = $con->prepare("SELECT * FROM mahasiswa WHERE NIM = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();
$mahasiswa = $result->fetch_assoc();

if (!$mahasiswa) {
    echo "Data mahasiswa tidak ditemukan.";
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
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="MsMahasiswa.css">
</head>

<body>
<?php endif; ?>
<div class="modal-content">
    <h2 class="judul">Edit Mahasiswa</h2>

    <form method="POST" action="MsMahasiswa.php" id="formEditMahasiswa" enctype="multipart/form-data" class="form-edit">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="NIM" value="<?php echo htmlspecialchars($mahasiswa['NIM']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>" required>
        </div>
        <div class="form-group">
            <label for="tahun_masuk">Tahun Masuk:</label>
            <input type="text" id="tahun_masuk" name="tahun_masuk" value="<?php echo htmlspecialchars($mahasiswa['tahun_masuk']); ?>" required>
        </div>
        <div class="form-group">
            <label for="dob">DOB:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($mahasiswa['DOB']); ?>" required>
        </div>
        <div class="form-group">
            <label for="prodi">Prodi:</label>
            <div class="select-wrapper">
                <select id="prodi" name="prodi" required>
                    <option value="">-- Pilih Prodi --</option>
                    <?php
                    $prodi_list = [
                        "Informatika", "Sistem Informasi", "Teknik Elektro", "Teknik Fisika",
                        "Teknik Komputer", "Strategic Communication", "Jurnalistik", "DKV",
                        "Film & Animasi", "Arsitektur", "Perhotelan", "Manajemen", "Akuntansi"
                    ];
                    foreach ($prodi_list as $p) {
                        $selected = $mahasiswa['prodi'] === $p ? 'selected' : '';
                        echo "<option value=\"$p\" $selected>$p</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($mahasiswa['alamat']); ?>" required>
        </div>
        <div class="form-group">
            <label for="telp">Telp:</label>
            <input type="text" id="telp" name="no_telp" value="<?php echo htmlspecialchars($mahasiswa['no_telp']); ?>" required>
        </div>

        <input type="hidden" name="action" value="edit">
        <div class="button-group">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <button type="button" class="btn btn-danger" onclick="if(confirm('Yakin ingin menghapus data ini?')) window.location.href='DeleteMahasiswa.php?NIM=<?= $mahasiswa['NIM'] ?>'">Hapus</button>
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