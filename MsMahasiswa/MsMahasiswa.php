<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/UserSelection.php");
    exit();
}

$dsn = 'mysql:host=localhost;dbname=myumn';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $tahun_masuk = $_POST['tahun_masuk'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $user_input = $_SESSION['email'];
        $tanggal_input = date('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO mahasiswa (nim, nama, tahun_masuk, alamat, telp, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nim, $nama, $tahun_masuk, $alamat, $telp, $user_input, $tanggal_input]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $tahun_masuk = $_POST['tahun_masuk'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];

        $stmt = $db->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, tahun_masuk = ?, alamat = ?, telp = ? WHERE id = ?");
        $stmt->execute([$nim, $nama, $tahun_masuk, $alamat, $telp, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM mahasiswa WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$mahasiswa = $db->query("SELECT * FROM mahasiswa")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Student</title>
    <link rel="stylesheet" href="MsMahasiswa.css">
</head>
<body>
<div class="container">
    <h1>Master Student</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tahun Masuk</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswa as $m): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($m['nim']); ?></td>
                        <td><?php echo htmlspecialchars($m['nama']); ?></td>
                        <td><?php echo htmlspecialchars($m['tahun_masuk']); ?></td>
                        <td><?php echo htmlspecialchars($m['alamat']); ?></td>
                        <td><?php echo htmlspecialchars($m['telp']); ?></td>
                        <td><?php echo htmlspecialchars($m['user_input']); ?></td>
                        <td><?php echo htmlspecialchars($m['tanggal_input']); ?></td>
                        <td>
                            <button onclick="editMahasiswa(<?php echo htmlspecialchars(json_encode($m)); ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <form action="MsMahasiswa.php" method="post">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" required>
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
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" required>
        </div>
        <div class="form-group">
            <label for="telp">Telp:</label>
            <input type="text" id="telp" name="telp" required>
        </div>
        <button type="submit" name="add" class="btn">Tambah</button>
        <button type="submit" name="edit" class="btn">Edit</button>
        <button type="submit" name="delete" class="btn">Hapus</button>
    </form>
    <button class="btn" onclick="window.location.href='../MainMenu/MainMenu.php'">Kembali</button>
</div>

<script>
function editMahasiswa(mahasiswa) {
    document.getElementById('id').value = mahasiswa.id;
    document.getElementById('nim').value = mahasiswa.nim;
    document.getElementById('nama').value = mahasiswa.nama;
    document.getElementById('tahun_masuk').value = mahasiswa.tahun_masuk;
    document.getElementById('alamat').value = mahasiswa.alamat;
    document.getElementById('telp').value = mahasiswa.telp;
}
</script>
</body>
</html>