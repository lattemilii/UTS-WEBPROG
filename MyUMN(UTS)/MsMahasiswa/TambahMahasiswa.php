<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="MsMahasiswa.css">
</head>
<body>
    <div class="modal" id="tambahModal">
        <div class="modal-content">
            <h2 class="judul">Tambah Mahasiswa</h2>

            <form method="POST" action="MsMahasiswa.php" id="formTambahMahasiswa" enctype="multipart/form-data" class="form-tambah">
                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="NIM" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="tahun_masuk">Tahun Masuk:</label>
                    <input type="text" id="tahun_masuk" name="tahun_masuk" required>
                </div>
                <div class="form-group">
                    <label for="dob">DOB:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="prodi">Prodi:</label>
                    <select id="prodi" name="prodi" required>
                        <option value="">-- Pilih Prodi --</option>
                        <?php
                        $prodi_list = [
                            "Informatika", "Sistem Informasi", "Teknik Elektro", "Teknik Fisika",
                            "Teknik Komputer", "Strategic Communication", "Jurnalistik", "DKV",
                            "Film & Animasi", "Arsitektur", "Perhotelan", "Manajemen", "Akuntansi"
                        ];
                        foreach ($prodi_list as $p) {
                            echo '<option value="' . $p . '">' . $p . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" required>
                </div>
                <div class="form-group">
                    <label for="telp">Telp:</label>
                    <input type="text" id="telp" name="no_telp" required>
                </div>
                <div class="btn-wrapper">
                    <button type="submit" class="btn">Tambah</button>
                </div>
            </form>
            <img src="../assets/cross-mark.png" alt="Close" class="close-img" onclick="closeModal()">
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById("tambahModal").style.display = "none";
            window.location.href = "MsMahasiswa.php";
        }

        window.onload = function() {
            const modal = document.getElementById("tambahModal");
            const content = modal.querySelector(".modal-content");

            modal.style.display = "flex";
            content.style.display = "block";
        };
    </script>
</body>
</html>