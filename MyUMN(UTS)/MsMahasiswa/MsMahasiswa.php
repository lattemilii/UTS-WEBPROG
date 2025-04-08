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
    $email = $base . '@student.umn.ac.id';
    $counter = 1;
    $count = 0;

    $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    while ($count > 0) {
        $email = $base . $counter . '@student.umn.ac.id';
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
    $nim = $_POST['NIM'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $tahun_masuk = $_POST['tahun_masuk'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $prodi = $_POST['prodi'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $telp = $_POST['no_telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    if ($isEdit) {
        // Generate email baru
        $emailBaru = generateEmailFromName($nama, $con);

        // Update tabel mahasiswa
        $stmt = $con->prepare("UPDATE mahasiswa SET nama=?, tahun_masuk=?, DOB=?, prodi=?, alamat=?, no_telp=?, email=? WHERE NIM=?");
        $stmt->bind_param("ssssssss", $nama, $tahun_masuk, $dob, $prodi, $alamat, $telp, $emailBaru, $nim);
        if (!$stmt->execute()) {
            $error = "Data mahasiswa gagal diupdate! " . $stmt->error;
        }
        $stmt->close();

        // Update email di tabel users
        $stmt = $con->prepare("UPDATE users SET email=? WHERE NIM=?");
        $stmt->bind_param("ss", $emailBaru, $nim);
        $stmt->execute();
        $stmt->close();

        if (empty($error)) {
            header("Location: MsMahasiswa.php");
            exit();
        }
    } else {
        $password = str_replace('-', '', $dob);
        $hpass = password_hash($password, PASSWORD_DEFAULT);

        function generateEmail($nama, $con) {
            $base = strtolower(str_replace(' ', '.', $nama));
            $email = $base . '@student.umn.ac.id';
            $counter = 1;
            $count = 0;

            $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            while ($count > 0) {
                $email = $base . $counter . '@student.umn.ac.id';
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

        $emailNew = generateEmail($nama, $con);

        $cek = $con->prepare("SELECT * FROM users WHERE NIM = ?");
        $cek->bind_param("s", $nim);
        $cek->execute();
        $cek->store_result();
        $result = $cek->num_rows;
        $cek->close();

        if ($result == 0) {
            $insert = $con->prepare("INSERT INTO users (email, password, role, NIM) VALUES (?, ?, 'mahasiswa', ?)");
            $insert->bind_param("sss", $emailNew, $hpass, $nim);
            $insert->execute();
            $insert->close();
        } else {
            $error = "NIM sudah terdaftar.";
        }

        if (empty($error)) {
            $stmt = $con->prepare("INSERT INTO mahasiswa (NIM, nama, prodi, tahun_masuk, DOB, alamat, no_telp, email, user_input, tanggal_input) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssss", $nim, $nama, $prodi, $tahun_masuk, $dob, $alamat, $telp, $emailNew, $user_input, $tanggal_input);
            $stmt->execute();
            $stmt->close();
            header("Location: MsMahasiswa.php");
            exit();
        }
    }
}

$result = $con->query("SELECT * FROM mahasiswa");
$mahasiswa = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MsMahasiswa.css">
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
            <span><?= htmlspecialchars($name) ?></span>
            <div class="avatar"><img src="../assets/profile-picture.png" alt="Profile Picture"></div>
        </div>
    </div>

    <h1 class="judul">Mahasiswa</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tahun</th>
                    <th>Prodi</th>
                    <th>DOB</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Email</th>
                    <th>User Input</th>
                    <th>Tgl Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswa as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['NIM']) ?></td>
                        <td><?= htmlspecialchars($m['nama']) ?></td>
                        <td><?= htmlspecialchars($m['tahun_masuk']) ?></td>
                        <td><?= htmlspecialchars($m['prodi']) ?></td>
                        <td><?= htmlspecialchars($m['DOB']) ?></td>
                        <td><?= htmlspecialchars($m['alamat']) ?></td>
                        <td><?= htmlspecialchars($m['no_telp']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['user_input']) ?></td>
                        <td><?= htmlspecialchars($m['tanggal_input']) ?></td>
                        <td>
                            <button onclick="openEditModal('<?= $m['NIM'] ?>')" class="btn-edit">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="tambah-btn-container">
        <button id="openModal" class="btn-tambah">Tambah Mahasiswa</button>
    </div>
</div>

    <div id="modalTambah" class="modal">
        <div>
            <span class="close">&times;</span>
            <?php include 'TambahMahasiswa.php'; ?>
        </div>
    </div>

    <div id="modalEdit" class="modal" style="display: none;">
        <div id="editFormContainer"></div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalTambah = document.getElementById("modalTambah");
        const btnTambah = document.getElementById("openModal");
        const closeTambah = modalTambah.querySelector(".close");

        btnTambah.addEventListener("click", () => {
            modalTambah.style.display = "flex";
            document.body.classList.add("modal-open");
        });

        closeTambah.addEventListener("click", () => {
            modalTambah.style.display = "none";
            document.body.classList.remove("modal-open");
        });

        window.addEventListener("click", (e) => {
            if (e.target === modalTambah) {
                modalTambah.style.display = "none";
                document.body.classList.remove("modal-open");
            } else if (e.target === modalEdit) {
                modalEdit.style.display = "none";
                document.body.classList.remove("modal-open");
            }
        });

        const modalEdit = document.getElementById("modalEdit");
        const editFormContainer = document.getElementById("editFormContainer");

        window.openEditModal = function(nim) {
            fetch("EditMahasiswa.php?NIM=" + nim)
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