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
    <title>Tambah Mata Kuliah</title>
    <link rel="stylesheet" href="MsMatkul.css">
</head>
<body>
    <div class="modal" id="tambahModal">
        <div class="modal-content">
            <h2 class="judul">Tambah Mata Kuliah</h2>

            <form method="POST" action="MsMatkul.php" id="formTambahMatkul" enctype="multipart/form-data" class="form-tambah">
                <div class="form-group">
                    <label for="Kode_Matkul">Kode Mata Kuliah:</label>
                    <input type="text" id="Kode_Matkul" name="Kode_Matkul" required>
                </div>
                <div class="form-group">
                    <label for="Nama_Matkul">Nama Mata Kuliah:</label>
                    <input type="text" id="Nama_Matkul" name="Nama_Matkul" required>
                </div>
                <div class="form-group">
                    <label for="sks">SKS:</label>
                    <input type="text" id="sks" name="sks" required>
                </div>
                <div class="form-group">
                    <label for="Semester">Semester:</label>
                    <input type="text" id="Semester" name="Semester" required>
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
            window.location.href = "MsMatkul.php";
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