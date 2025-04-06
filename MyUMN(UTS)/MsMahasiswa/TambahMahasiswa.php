<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['NIM'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $tahun_masuk = $_POST['tahun_masuk'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $prodi = $_POST['prodi'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $telp = $_POST['no_telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $email = $_POST['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');
    $password = str_replace('-', '', $dob);
    $hpass = password_hash($password, PASSWORD_DEFAULT);

    function generateEmail($nama, $con) {
        $new_email = strtolower(str_replace(' ', '.', $nama)) . '@student.umn.ac.id';
        $email = $new_email;
        $counter = 1;
        $count = 0;

        $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        while ($count > 0) {
            $email = strtolower(str_replace(' ', '.', $nama)) . $counter . '@student.umn.ac.id';
            $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            $counter++;
        }

        return $email;
    }

    $email = generateEmail($nama, $con);

    $cek = $con->prepare("SELECT * FROM users WHERE NIM = ?");
    $cek->bind_param("s", $nim);
    $cek->execute();
    $cek->store_result();
    $result = $cek->num_rows;

    
    if ($result == 0) {
        $insert = $con->prepare("INSERT INTO users (email, password, role, NIM) VALUES (?, ?, 'mahasiswa', ?)");
        $insert->bind_param("sss", $email, $hpass, $nim);
        if (!$insert->execute()) {
            $error = "Data gagal masuk ke tabel users: " . $insert->error;
        }
    } else {
        $error = "NIM sudah terdaftar.";
    }

    
    if (empty($error)) {
        $stmt = $con->prepare("INSERT INTO mahasiswa (NIM, nama, prodi, tahun_masuk, DOB, alamat, no_telp, email, user_input, tanggal_input) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssss", $nim, $nama, $prodi, $tahun_masuk, $dob, $alamat, $telp, $email, $user_input, $tanggal_input);
        if (!$stmt->execute()) {
            $error = "Data gagal masuk ke tabel mahasiswa: " . $stmt->error;
        } else {
            header("Location: MsMahasiswa.php");
            exit();
        }
        $stmt->close();
    }
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
    <div class="container">
        <h1>Tambah Mahasiswa</h1>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="TambahMahasiswa.php">
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
                            echo '<option value="' . $p . '" ' . (($_POST['Prodi'] ?? '') == $p ? 'selected' : '') . '>' . $p . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="telp">Telp:</label>
                <input type="text" id="telp" name="no_telp" required>
            </div>
            <button type="submit" class="btn">Tambah Mahasiswa</button>
            <button type="button" class="btn" onclick="window.location.href='MsMahasiswa.php'">Batal</button>
        </form>
    </div>
</body>
</html>