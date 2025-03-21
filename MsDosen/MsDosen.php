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
        $nik = $_POST['nik'];
        $nama = $_POST['nama'];
        $gelar = $_POST['gelar'];
        $lulusan = $_POST['lulusan'];
        $telp = $_POST['telp'];
        $user_input = $_SESSION['email'];
        $tanggal_input = date('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO dosen (nik, nama, gelar, lulusan, telp, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nik, $nama, $gelar, $lulusan, $telp, $user_input, $tanggal_input]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nik = $_POST['nik'];
        $nama = $_POST['nama'];
        $gelar = $_POST['gelar'];
        $lulusan = $_POST['lulusan'];
        $telp = $_POST['telp'];

        $stmt = $db->prepare("UPDATE dosen SET nik = ?, nama = ?, gelar = ?, lulusan = ?, telp = ? WHERE id = ?");
        $stmt->execute([$nik, $nama, $gelar, $lulusan, $telp, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM dosen WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$dosen = $db->query("SELECT * FROM dosen")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Lecturer</title>
    <link rel="stylesheet" href="MsDosen.css">
</head>
<body>
<div class="container">
    <h1>Master Lecturer</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gelar</th>
                    <th>Lulusan</th>
                    <th>Telp</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dosen as $d): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($d['nik']); ?></td>
                        <td><?php echo htmlspecialchars($d['nama']); ?></td>
                        <td><?php echo htmlspecialchars($d['gelar']); ?></td>
                        <td><?php echo htmlspecialchars($d['lulusan']); ?></td>
                        <td><?php echo htmlspecialchars($d['telp']); ?></td>
                        <td><?php echo htmlspecialchars($d['user_input']); ?></td>
                        <td><?php echo htmlspecialchars($d['tanggal_input']); ?></td>
                        <td>
                            <button onclick="editDosen(<?php echo htmlspecialchars(json_encode($d)); ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <form action="MsDosen.php" method="post">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="nik" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
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
            <input type="text" id="telp" name="telp" required>
        </div>
        <button type="submit" name="add" class="btn">Tambah</button>
        <button type="submit" name="edit" class="btn">Edit</button>
        <button type="submit" name="delete" class="btn">Hapus</button>
    </form>
    <button class="btn" onclick="window.location.href='../MainMenu/MainMenu.php'">Kembali</button>
</div>

<script>
function editDosen(dosen) {
    document.getElementById('id').value = dosen.id;
    document.getElementById('nik').value = dosen.nik;
    document.getElementById('nama').value = dosen.nama;
    document.getElementById('gelar').value = dosen.gelar;
    document.getElementById('lulusan').value = dosen.lulusan;
    document.getElementById('telp').value = dosen.telp;
}
</script>
</body>
</html>