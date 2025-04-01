<?php
require '../db.php';

if (isset($_GET['NIM'])) {
    $nim = $_GET['NIM'];
    $stmt = $con->prepare("DELETE FROM users WHERE NIM = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $stmt = $con->prepare("DELETE FROM mahasiswa WHERE NIM = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    header("Location: MsMahasiswa.php");
    exit();
}
?>
