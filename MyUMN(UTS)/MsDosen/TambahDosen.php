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
    <title>Tambah Dosen</title>
    <link rel="stylesheet" href="MsDosen.css">
</head>
<body>
    <div class="modal" id="tambahModal">
        <div class="modal-content">
            <h2 class="judul">Tambah Dosen</h2>

            <form method="POST" action="MsDosen.php" id="formTambahDosen" enctype="multipart/form-data" class="form-tambah">
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" id="nik" name="NIK" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="dob">DOB:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="gelar">Gelar:</label>
                    <input type="text" id="gelar" name="gelar" required>
                </div>
                <div class="form-group">
                    <label for="lulusan">Lulusan:</label>
                    <input type="text" id="lulusan" name="lulusan" required>
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
            window.location.href = "MsDosen.php";
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