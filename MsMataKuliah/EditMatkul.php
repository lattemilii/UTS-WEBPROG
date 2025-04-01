<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (isset($_GET['Kode_Matkul'])) {
    $kode_matkul = $_GET['Kode_Matkul'];
    $stmt = $con->prepare("SELECT * FROM mata_kuliah WHERE Kode_Matkul = ?");
    $stmt->bind_param("s", $kode_matkul);
    $stmt->execute();
    $result = $stmt->get_result();
    $matkul = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nama_matkul = $_POST['Nama_Matkul'] ?? '';
    $sks = $_POST['sks'] ?? '';
    $semester = $_POST['Semester'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');    
    
    $stmt = $con->prepare("UPDATE mata_kuliah SET Kode_Matkul = ?, Nama_Matkul = ?, SKS = ?, Semester = ?, User_Input = 'admin', Tanggal_Input = ? WHERE Kode_Matkul = ?");
    $stmt->bind_param("ssssss", $kode_matkul, $nama_matkul, $sks, $semester, $tanggal_input, $kode_matkul);
    
    if ($stmt->execute()) {
        header("Location: MsMatkul.php");
    } else {
        echo "Data gagal masuk " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <link rel="stylesheet" href="MsMatkul.css">
</head>
<body>
    <div class="container">
        <h1>Edit Mata Kuliah</h1>
        <form action="EditMatkul.php" method="post">
        <input type="hidden" name="id" id="id" value="<?php echo $matkul['Kode_Matkul']; ?>">
        <div class="form-group">
            <label for="kode_matkul">Kode Matkul:</label>
            <input type="text" id="kode_matkul" name="Kode_Matkul" value="<?php echo $matkul['Kode_Matkul']; ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_matkul">Nama Matkul:</label>
            <input type="text" id="nama_matkul" name="Nama_Matkul" value="<?php echo $matkul['Nama_Matkul']; ?>" required>
        </div>
        <div class="form-group">
            <label for="sks">SKS:</label>
            <input type="number" id="sks" name="sks" value="<?php echo $matkul['sks']; ?>" required>
        </div>
        <div class="form-group">
            <label for="semester">Semester:</label>
            <input type="number" id="semester" name="Semester" value="<?php echo $matkul['Semester']; ?>" required>
        </div>
        <button type="submit" name="edit" class="btn">Simpan Perubahan</button>
        <button type="button" class="btn" onclick="window.location.href='DeleteMatkul.php?Kode_Matkul=<?php echo $matkul['Kode_Matkul']; ?>'">Hapus</button>
        <button type="button" class="btn" onclick="window.location.href='MsMatkul.php'">Batal</button>
    </form>
    </div>
</body>
</html>