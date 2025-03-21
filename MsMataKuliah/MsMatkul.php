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
        $nama_matkul = $_POST['nama_matkul'];
        $sks = $_POST['sks'];
        $semester = $_POST['semester'];
        $user_input = $_SESSION['email'];
        $tanggal_input = date('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, semester, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$kode_matkul, $nama_matkul, $sks, $semester, $user_input, $tanggal_input]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $kode_matkul = $_POST['kode_matkul'];
        $nama_matkul = $_POST['nama_matkul'];
        $sks = $_POST['sks'];
        $semester = $_POST['semester'];

        $stmt = $db->prepare("UPDATE mata_kuliah SET kode_matkul = ?, nama_matkul = ?, sks = ?, semester = ? WHERE id = ?");
        $stmt->execute([$kode_matkul, $nama_matkul, $sks, $semester, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM mata_kuliah WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$mata_kuliah = $db->query("SELECT * FROM mata_kuliah")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Subject</title>
    <link rel="stylesheet" href="MsMatkul.css">
</head>
<body>
<div class="container">
    <h1>Master Subject</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Matkul</th>
                    <th>Nama Matkul</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mata_kuliah as $mk): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mk['kode_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($mk['nama_matkul']); ?></td>
                        <td><?php echo htmlspecialchars($mk['sks']); ?></td>
                        <td><?php echo htmlspecialchars($mk['semester']); ?></td>
                        <td><?php echo htmlspecialchars($mk['user_input']); ?></td>
                        <td><?php echo htmlspecialchars($mk['tanggal_input']); ?></td>
                        <td>
                            <button onclick="editMatkul(<?php echo htmlspecialchars(json_encode($mk)); ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <form action="MsMatkul.php" method="post">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <label for="kode_matkul">Kode Matkul:</label>
            <input type="text" id="kode_matkul" name="kode_matkul" required>
        </div>
        <div class="form-group">
            <label for="nama_matkul">Nama Matkul:</label>
            <input type="text" id="nama_matkul" name="nama_matkul" required>
        </div>
        <div class="form-group">
            <label for="sks">SKS:</label>
            <input type="number" id="sks" name="sks" required>
        </div>
        <div class="form-group">
            <label for="semester">Semester:</label>
            <input type="number" id="semester" name="semester" required>
        </div>
        <button type="submit" name="add" class="btn">Tambah</button>
        <button type="submit" name="edit" class="btn">Edit</button>
        <button type="submit" name="delete" class="btn">Hapus</button>
    </form>
    <button class="btn" onclick="window.location.href='../MainMenu/MainMenu.php'">Kembali</button>
</div>

<script>
function editMatkul(matkul) {
    document.getElementById('id').value = matkul.id;
    document.getElementById('kode_matkul').value = matkul.kode_matkul;
    document.getElementById('nama_matkul').value = matkul.nama_matkul;
    document.getElementById('sks').value = matkul.sks;
    document.getElementById('semester').value = matkul.semester;
}
</script>
</body>
</html>