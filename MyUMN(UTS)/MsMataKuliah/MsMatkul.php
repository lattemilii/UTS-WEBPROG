<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

function formatName($name) {
    $parts = explode('.', $name);
    $formattedParts = array_map('ucfirst', $parts);
    return implode(' ', $formattedParts);
}

$email = $_SESSION['email'] ?? '';
$name = formatName(explode('@', $email)[0]);

$error = '';
$isEdit = isset($_POST['action']) && $_POST['action'] === 'edit';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nama_matkul = $_POST['Nama_Matkul'] ?? '';
    $sks = $_POST['sks'] ?? '';
    $semester = $_POST['Semester'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    if ($isEdit) {
        $stmt = $con->prepare("UPDATE mata_kuliah SET Nama_Matkul = ?, SKS = ?, Semester = ?, User_Input = ?, Tanggal_Input = ? WHERE Kode_Matkul = ?");
        $stmt->bind_param("ssssss", $nama_matkul, $sks, $semester, $user_input, $tanggal_input, $kode_matkul);
        if (!$stmt->execute()) {
            $error = "Data gagal diedit: " . $stmt->error;
        } else {
            header("Location: MsMatkul.php");
            exit();
        }
        $stmt->close();
    } else {
        try {
            $stmt = $con->prepare("INSERT INTO mata_kuliah (Kode_Matkul, Nama_Matkul, SKS, Semester, User_Input, Tanggal_Input) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $kode_matkul, $nama_matkul, $sks, $semester, $user_input, $tanggal_input);
            $stmt->execute();
            header("Location: MsMatkul.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = "Kode Mata Kuliah sudah ada. Silakan gunakan kode yang berbeda.";
            } else {
                $error = "Terjadi kesalahan: " . $e->getMessage();
            }
        }
    }
}

$result = $con->query("SELECT * FROM mata_kuliah");
$mata_kuliah = $result->fetch_all(MYSQLI_ASSOC);
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
    <?php if (!empty($error)): ?>
        <div class="floating-alert show" id="notifBox"><?= $error ?></div>
    <?php endif; ?>

    <div class="navbar">
        <div class="navbar-left">
            <div class="logo">
                <img src="../assets/UMN.png" alt="UMN Logo">
            </div>
            <div class="links">
                <a href="../MainMenu/MainMenu.php">Back</a>
            </div>
        </div>
        <div class="profile">
            <span><?php echo htmlspecialchars($name); ?></span>
            <div class="avatar">
                <img src="../assets/profile-picture.png" alt="Profile Picture">
            </div>
        </div>
    </div>

    <h1 class="judul">Mata Kuliah</h1>
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
                            <button onclick="openEditModal('<?= $mk['kode_matkul'] ?>')" class="btn-edit">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="tambah-btn-container">
        <button id="openModal" class="btn-tambah">Tambah Mata Kuliah</button>
    </div>
</div>

    <div id="modalTambah" class="modal">
        <div>
            <span class="close">&times;</span>
            <?php include 'TambahMatkul.php'; ?>
        </div>
    </div>

    <div id="modalEdit" class="modal" style="display: none;">
        <div id="editFormContainer"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById("modalTambah");
            var btn = document.getElementById("openModal");
            var span = document.querySelector(".close");

            if (btn && modal && span) {
                btn.addEventListener('click', function () {
                    modal.style.display = "flex";
                    document.body.classList.add("modal-open");
                });

                span.addEventListener('click', function () {
                    modal.style.display = "none";
                    document.body.classList.remove("modal-open");
                });

                window.addEventListener('click', function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        document.body.classList.remove("modal-open");
                    }
                });
            }

            const modalEdit = document.getElementById("modalEdit");
            const editFormContainer = document.getElementById("editFormContainer");

            window.openEditModal = function(kode) {
                fetch("EditMatkul.php?Kode_Matkul=" + kode)
                    .then(res => res.text())
                    .then(html => {
                        editFormContainer.innerHTML = html;
                        modalEdit.style.display = "flex";
                        document.body.classList.add("modal-open");
                    });
            };
        });

        const notif = document.getElementById('notifBox');
        if (notif) {
            setTimeout(() => notif.classList.remove('show'), 4000);
        }
    </script>
</body>
</html>