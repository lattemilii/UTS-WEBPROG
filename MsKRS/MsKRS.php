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
        $kode_matkul = $_POST['kode_matkul'];
        $nik_dosen = $_POST['nik_dosen'];
        $nim_mahasiswa = $_POST['nim_mahasiswa'];
        $hari_matkul = $_POST['hari_matkul'];
        $ruangan = $_POST['ruangan'];
        $user_input = $_SESSION['email'];
        $tanggal_input = date('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO krs (kode_matkul, nik_dosen, nim_mahasiswa, hari_matkul, ruangan, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$kode_matkul, $nik_dosen, $nim_mahasiswa, $hari_matkul, $ruangan, $user_input, $tanggal_input]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $kode_matkul = $_POST['kode_matkul'];
        $nik_dosen = $_POST['nik_dosen'];
        $nim_mahasiswa = $_POST['nim_mahasiswa'];
        $hari_matkul = $_POST['hari_matkul'];
        $ruangan = $_POST['ruangan'];

        $stmt = $db->prepare("UPDATE krs SET kode_matkul = ?, nik_dosen = ?, nim_mahasiswa = ?, hari_matkul = ?, ruangan = ? WHERE id = ?");
        $stmt->execute([$kode_matkul, $nik_dosen, $nim_mahasiswa, $hari_matkul, $ruangan, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM krs WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$krs = $db->query("SELECT * FROM krs")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRS Transaction</title>
    <link rel="stylesheet" href="MsKRS.css">
</head>
<body>
<div class="container">
    <h1>KRS Transaction</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Matkul</th>
                    <th>NIK Dosen</th>
                    <th>NIM Mahasiswa</th>
                    <th>Hari Matkul</th>
                    <th>Ruangan</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($krs as $k): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($k['id']); ?></td>
                        <td><?php echo htmlspecialchars($k['kode_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($k['nik_dosen']); ?></td>
                        <td><?php echo htmlspecialchars($k['nim_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($k['hari_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($k['ruangan']); ?></td>
                        <td><?php echo htmlspecialchars($k['user_input']); ?></td>
                        <td><?php echo htmlspecialchars($k['tanggal_input']); ?></td>
                        <td>
                            <button onclick="editKRS(<?php echo htmlspecialchars(json_encode($k)); ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <form action="MsKRS.php" method="post">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <label for="kode_matkul">Kode Matkul:</label>
            <input type="text" id="kode_matkul" name="kode_matkul" required>
        </div>
        <div class="form-group">
            <label for="nik_dosen">NIK Dosen:</label>
            <input type="text" id="nik_dosen" name="nik_dosen" required>
        </div>
        <div class="form-group">
            <label for="nim_mahasiswa">NIM Mahasiswa:</label>
            <input type="text" id="nim_mahasiswa" name="nim_mahasiswa" required>
        </div>
        <div class="form-group">
            <label for="hari_matkul">Hari Matkul:</label>
            <input type="text" id="hari_matkul" name="hari_matkul" required>
        </div>
        <div class="form-group">
            <label for="ruangan">Ruangan:</label>
            <input type="text" id="ruangan" name="ruangan" required>
        </div>
        <button type="submit" name="add" class="btn">Tambah</button>
        <button type="submit" name="edit" class="btn">Edit</button>
        <button type="submit" name="delete" class="btn">Hapus</button>
    </form>
    <button class="btn" onclick="window.location.href='../MainMenu/MainMenu.php'">Kembali</button>
</div>

<script>
function editKRS(krs) {
    document.getElementById('id').value = krs.id;
    document.getElementById('kode_matkul').value = krs.kode_matkul;
    document.getElementById('nik_dosen').value = krs.nik_dosen;
    document.getElementById('nim_mahasiswa').value = krs.nim_mahasiswa;
    document.getElementById('hari_matkul').value = krs.hari_matkul;
    document.getElementById('ruangan').value = krs.ruangan;
}
</script>
</body>
</html>