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

function generateEmailFromName($nama, $con) {
    $base = strtolower(str_replace(' ', '.', $nama));
    $email = $base . '@lecturer.umn.ac.id';
    $counter = 1;
    $count = 0;

    $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    while ($count > 0) {
        $email = $base . $counter . '@lecturer.umn.ac.id';
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

$email = $_SESSION['email'] ?? '';
$name = formatName(explode('@', $email)[0]);

$error = '';
$isEdit = isset($_POST['action']) && $_POST['action'] === 'edit';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['NIK'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $gelar = $_POST['gelar'] ?? '';
    $lulusan = $_POST['lulusan'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $telp = $_POST['no_telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');
    
    if ($isEdit) {
        $stmt = $con->prepare("UPDATE dosen SET nama = ?, gelar = ?, lulusan = ?, email = ?, no_telp = ?, user_input = ?, tanggal_input = ? WHERE NIK = ?");
        $stmt->bind_param("ssssssss", $nama, $gelar, $lulusan, $email, $telp, $user_input, $tanggal_input, $nik);
        if (!$stmt->execute()) {
            $error = "Data dosen gagal diupdate! " . $stmt->error;
        } else {
            header("Location: MsDosen.php");
            exit();
        }
        $stmt->close();
    } else {
        $password = str_replace('-', '', $dob);
        $hpass = password_hash($password, PASSWORD_DEFAULT);

        function generateEmail($nama, $con){
            $base_email = strtolower(str_replace(' ', '.', $nama)) . '@lecturer.umn.ac.id';
            $email = $base_email;
            $counter = 1;
            $count = 0;

            do {
                $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {
                    $email = strtolower(str_replace(' ', '.', $nama)) . $counter . '@lecturer.umn.ac.id';
                    $counter++;
                }
            } while ($count > 0);

            return $email;
        }

        $emailNew = generateEmail($nama, $con);

        $cek = $con->prepare("SELECT * FROM users WHERE NIK = ?");
        $cek->bind_param("s", $nik);
        $cek->execute();
        $cek->store_result();
        $result = $cek->num_rows;
        $cek->close();

        if ($result == 0) {
            $insert = $con->prepare("INSERT INTO users (email, password, role, NIK) VALUES (?, ?, 'dosen', ?)");
            $insert->bind_param("sss", $emailNew, $hpass, $nik);
            if (!$insert->execute()) {
                $error = "Data gagal masuk ke tabel users: " . $insert->error;
            }
            $insert->close();
        } else {
            $error = "NIK sudah terdaftar.";
        }

        if (empty($error)) {
            $stmt = $con->prepare("INSERT INTO dosen (NIK, nama, DOB, gelar, lulusan, email, no_telp, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $nik, $nama, $dob, $gelar, $lulusan, $emailNew, $telp, $user_input, $tanggal_input);
            if (!$stmt->execute()) {
                $error = "Data gagal masuk ke tabel dosen: " . $stmt->error;
            } else {
                header("Location: MsDosen.php");
                exit();
            }
            $stmt->close();
        }
    }
}

$result = $con->query("SELECT * FROM dosen");
$dosen = $result->fetch_all(MYSQLI_ASSOC);
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
    <?php if (!empty($error)): ?>
        <div class="floating-alert show" id="notifBox"><?= $error ?></div>
    <?php endif; ?>

        <div class="navbar">
            <div class="navbar-left">
                <div class="logo">
                    <img src="../assets/UMN.png" alt="UMN Logo">
                </div>
                <div class="links">
                    <a href="../MainMenu/MainMenu.php">Menu</a>
                </div>
            </div>
            <div class="profile">
                <span><?php echo htmlspecialchars($name); ?></span>
                <div class="avatar">
                    <img src="../assets/profile-picture.png" alt="Profile Picture">
                </div>
            </div>
        </div>

        <h1 class="judul">Dosen</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>DOB</th>
                        <th>Gelar</th>
                        <th>Lulusan</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>User Input</th>
                        <th>Tanggal Input</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dosen as $d): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($d['NIK']); ?></td>
                            <td><?php echo htmlspecialchars($d['nama']); ?></td>
                            <td><?php echo htmlspecialchars($d['DOB']); ?></td>
                            <td><?php echo htmlspecialchars($d['gelar']); ?></td>
                            <td><?php echo htmlspecialchars($d['lulusan']); ?></td>
                            <td><?php echo htmlspecialchars($d['email']); ?></td>
                            <td><?php echo htmlspecialchars($d['no_telp']); ?></td>
                            <td><?php echo htmlspecialchars($d['user_input']); ?></td>
                            <td><?php echo htmlspecialchars($d['tanggal_input']); ?></td>
                            <td>
                                <button onclick="openEditModal('<?= $d['NIK'] ?>')" class="btn-edit">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="tambah-btn-container">
            <button id="openModal" class="btn-tambah">Tambah Dosen</button>
        </div>
    </div>

    <div id="modalTambah" class="modal">
        <div>
            <span class="close">&times;</span>
            <?php include 'TambahDosen.php'; ?>
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

            window.openEditModal = function(nik) {
                fetch("EditDosen.php?NIK=" + nik)
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