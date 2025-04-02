<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if (isset($_GET['NIM'])) {
    $nim = $_GET['NIM'];
    $stmt = $con->prepare("SELECT * FROM mahasiswa WHERE NIM = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    $mahasiswa = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['NIM'] ??'';
    $nama = $_POST['Nama'] ?? '';
    $tahun_masuk = $_POST['Tahun_Masuk'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $prodi = $_POST['Prodi'] ?? '';
    $alamat = $_POST['Alamat'] ?? '';
    $telp = $_POST['Telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $email = $_POST['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    $stmt = $con->prepare("UPDATE mahasiswa SET Nama = ?, Prodi = ?, Tahun_Masuk = ?, dob = ?, Alamat = ?, Telp = ?, User_Input = ?, Tanggal_Input = ? WHERE NIM = ?");
    $stmt->bind_param("sssssssss", $nama, $prodi, $tahun_masuk, $dob, $alamat, $telp, $user_input, $tanggal_input, $nim);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data mahasiswa berhasil diupdate!'); window.location.href = 'MsMahasiswa.php';</script>";
    } else {
        echo "<script>alert('Data mahasiswa gagal diupdate!'); window.location.href = 'MsMahasiswa.php';</script>";
    }
    header("Location: MsMahasiswa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="MsMahasiswa.css">
</head>
<body>
<div class="container">
    <h1>Edit Mahasiswa</h1>
    <form method="POST" action="EditMahasiswa.php">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="NIM" value="<?php echo $mahasiswa['NIM']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="Nama" value="<?php echo $mahasiswa['Nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun_masuk">Tahun Masuk:</label>
                <input type="text" id="tahun_masuk" name="Tahun_Masuk" value="<?php echo $mahasiswa['Tahun_Masuk']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">DOB:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $mahasiswa['dob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="prodi">Prodi:</label>
                <div class="select-wrapper">
                    <select id="prodi" name="Prodi" required>
                        <option value="">-- Pilih Prodi --</option>
                        <?php
                        $prodi_list = [
                            "Informatika", "Sistem Informasi", "Teknik Elektro", "Teknik Fisika",
                            "Teknik Komputer", "Strategic Communication", "Jurnalistik", "DKV",
                            "Film & Animasi", "Arsitektur", "Perhotelan", "Manajemen", "Akuntansi"
                        ];
                        foreach ($prodi_list as $p) {
                            echo '<option value="' . $p . '" ' . (($_POST['Prodi'] ?? '') == $p ? 'selected' : '') . '>' . $p . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="Alamat" value="<?php echo $mahasiswa['Alamat']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telp">Telp:</label>
                <input type="text" id="telp" name="Telp" value="<?php echo $mahasiswa['Telp']; ?>" required>
            </div>
            <button type="submit" class="btn">Simpan Perubahan</button>
            <button type="button" class="btn" onclick="window.location.href='DeleteMahasiswa.php?NIM=<?php echo $mahasiswa['NIM']; ?>'">Hapus</button>
            <button type="button" class="btn" onclick="window.location.href='MsMahasiswa.php'">Batal</button>
        </form>
    </div>
</body>
</html>

