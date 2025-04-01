<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (isset($_GET['NIK'])) {
    $nik = $_GET['NIK'];
    $stmt = $con->prepare("SELECT * FROM dosen WHERE NIK = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
    $dosen = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['NIK'] ?? '';
    $nama = $_POST['Nama'] ?? '';
    $gelar = $_POST['Gelar'] ?? '';
    $lulusan = $_POST['Lulusan'] ?? '';
    $email = $_POST['email'] ?? '';
    $telp = $_POST['Telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    $stmt = $con->prepare("UPDATE dosen SET Nama = ?, Gelar = ?, Lulusan = ?, email = ?, Telp = ?, User_Input = 'admin', Tanggal_Input = ? WHERE NIK = ?");
    $stmt->bind_param("sssssss", $nama, $gelar, $lulusan, $email, $telp, $tanggal_input, $nik);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data dosen berhasil diupdate!'); window.location.href = 'MsDosen.php';</script>";
    } else {
        echo "<script>alert('Data dosen gagal diupdate!'); window.location.href = 'MsDosen.php';</script>";
    }
    header("Location: MsDosen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>
    <link rel="stylesheet" href="MsDosen.css">
</head>
<body>
<div class="container">
    <h1>Edit Dosen</h1>
    <form action="EditDosen.php?NIK=<?php echo htmlspecialchars($nik); ?>" method="post">
        <div class="form-group">
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="NIK" value="<?php echo htmlspecialchars($dosen['NIK']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="Nama" value="<?php echo htmlspecialchars($dosen['Nama']); ?>" required>
        </div>
        <div class="form-group">
            <label for="dob">DOB:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dosen['dob']); ?>" required>
        </div>
        <div class="form-group">
            <label for="gelar">Gelar:</label>
            <input type="text" id="gelar" name="Gelar" value="<?php echo htmlspecialchars($dosen['Gelar']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lulusan">Lulusan:</label>
            <input type="text" id="lulusan" name="Lulusan" value="<?php echo htmlspecialchars($dosen['Lulusan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($dosen['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="telp">Telp:</label>
            <input type="text" id="telp" name="Telp" value="<?php echo htmlspecialchars($dosen['Telp']); ?>" required>
        </div>
        <button type="submit" name="edit" class="btn">Simpan Perubahan</button>
        <button type="button" class="btn" onclick="window.location.href='DeleteDosen.php?NIK=<?php echo htmlspecialchars($nik); ?>'">Hapus</button>
        <button type="button" class="btn" onclick="window.location.href='MsDosen.php'">Batal</button>
    </form>
</div>
</body>
</html>

