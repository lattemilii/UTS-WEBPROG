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
    <title>Tambah KRS</title>
    <link rel="stylesheet" href="MsKRS.css">
</head>
<body>
    <div class="modal" id="tambahModal">
        <div class="modal-content">
            <h2 class="judul">Tambah KRS</h2>

            <form method="POST" action="MsKRS.php" id="formTambahKRS" enctype="multipart/form-data" class="form-tambah">
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
            window.location.href = "MsKRS.php";
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