<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
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
    <h1>KRS Transaction</h1>
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
                        <td><?php echo htmlspecialchars($k['Hari_Matkul']); ?></td>
                        <td><?php echo htmlspecialchars($k['Ruangan']); ?></td>
                        <td>
                            <?php 
                                echo calculateTimeRange($k['Jam_Matkul'], $k['SKS']); 
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($k['User_Input']); ?></td>
                        <td><?php echo htmlspecialchars($k['Tanggal_Input']); ?></td>
                        <td>
                            <button onclick="location.href='EditKRS.php?Kode_Matkul=<?php echo $k['Kode_Matkul']; ?>'">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>    
    <button onclick="location.href='TambahKRS.php'" class="btn">Tambah KRS</button>
    <button onclick="location.href='../MainMenu/MainMenu.php'" class="btn">Kembali</button>   
</div>
</body>
</html>