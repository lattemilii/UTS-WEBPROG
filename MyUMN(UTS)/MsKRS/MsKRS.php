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
$showModal = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isEdit = isset($_POST['action']) && $_POST['action'] === 'edit';

    $kode_matkul = $_POST['Kode_Matkul'] ?? '';
    $nik_dosen = $_POST['NIK_Dosen'] ?? '';
    $nim_mahasiswa = $_POST['NIM_Mahasiswa'] ?? '';
    $hari_matkul = $_POST['hari_matkul'] ?? '';
    $jam_matkul = $_POST['jam_matkul'] ?? '';
    $ruangan = $_POST['ruangan'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');

    if ($isEdit) {
        $stmt = $con->prepare("UPDATE krs SET NIK_Dosen = ?, NIM_Mahasiswa = ?, Hari_Matkul = ?, Ruangan = ?, User_Input = ?, Tanggal_Input = ? WHERE Kode_Matkul = ?");
        $stmt->bind_param("sssssss", $nik_dosen, $nim_mahasiswa, $hari_matkul, $ruangan, $user_input, $tanggal_input, $kode_matkul);
        if ($stmt->execute()) {
            header("Location: MsKRS.php");
            exit();
        } else {
            $error = "Data gagal diupdate: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $cek_krs = $con->prepare("SELECT 1 FROM krs WHERE Kode_Matkul = ? AND NIK_Dosen = ? AND NIM_Mahasiswa = ?");
        $cek_krs->bind_param("sss", $kode_matkul, $nik_dosen, $nim_mahasiswa);
        $cek_krs->execute();
        $cek_krs->store_result();
        if ($cek_krs->num_rows > 0) {
            $error = "Data KRS dengan kombinasi yang sama sudah ada.";
        } else {
            $insert = $con->prepare("INSERT INTO krs (Kode_Matkul, NIK_Dosen, NIM_Mahasiswa, hari_matkul, jam_matkul, ruangan, user_input, tanggal_input) VALUES (?,?,?,?,?,?,?,?)");
            $insert->bind_param("ssssssss", $kode_matkul, $nik_dosen, $nim_mahasiswa, $hari_matkul, $jam_matkul, $ruangan, $user_input, $tanggal_input);
            if ($insert->execute()) {
                header("Location: MsKRS.php");
                exit();
            } else {
                $error = "Data gagal masuk: " . $insert->error;
            }
        }
        $cek_krs->close();
    }
}

$result = $con->query("
    SELECT krs.*, mata_kuliah.SKS 
    FROM krs 
    JOIN mata_kuliah ON krs.Kode_Matkul = mata_kuliah.Kode_Matkul
");
$krs = $result->fetch_all(MYSQLI_ASSOC);


function calculateTimeRange($startTime, $sks) {
    $start = new DateTime($startTime);
    $end = clone $start;
    $end->modify('+' . ($sks * 1) . ' hours');
    return $start->format('H:i:s') . '-' . $end->format('H:i:s');
}
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
        <?php if (!empty($error)): ?>
            <div class="floating-alert show" id="notifBox"><?= htmlspecialchars($error) ?></div>
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

        <h1 class="judul">KRS</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Kode Matkul</th>
                        <th>NIK Dosen</th>
                        <th>NIM Mahasiswa</th>
                        <th>Hari Matkul</th>
                        <th>Ruangan</th>
                        <th>Jam</th>
                        <th>User Input</th>
                        <th>Tanggal Input</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($krs as $k): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($k['Kode_Matkul']); ?></td>
                            <td><?php echo htmlspecialchars($k['NIK_Dosen']); ?></td>
                            <td><?php echo htmlspecialchars($k['NIM_Mahasiswa']); ?></td>
                            <td><?php echo htmlspecialchars($k['hari_matkul']); ?></td>
                            <td><?php echo htmlspecialchars($k['ruangan']); ?></td>
                            <td>
                                <?php 
                                    echo calculateTimeRange($k['jam_matkul'], $k['SKS']); 
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($k['user_input']); ?></td>
                            <td><?php echo htmlspecialchars($k['tanggal_input']); ?></td>
                            <td>
                                <button onclick="openEditModal('<?php echo $k['Kode_Matkul']; ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>    
        <div class="tambah-btn-container">
            <button id="openModal" class="btn-tambah">Tambah KRS</button>
        </div>
    </div>

    <div id="modalTambah" class="modal">
        <div>
            <span class="close">&times;</span>
            <?php include 'TambahKRS.php'; ?>
        </div>
    </div>

    <div id="modalEdit" class="modal" style="display: none;">
        <div id="editFormContainer"></div>
    </div>

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

            window.openEditModal = function(kodeMatkul) {
                fetch("EditKRS.php?kode_matkul=" + kodeMatkul)
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