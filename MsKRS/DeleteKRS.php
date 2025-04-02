<?php
require '../db.php';

if (isset($_GET['Kode_Matkul'])) {
    $kode_matkul = $_GET['Kode_Matkul'];
    $stmt = $con->prepare("DELETE FROM krs WHERE Kode_Matkul = ?");
    $stmt->bind_param("s", $kode_matkul);
    $stmt->execute();
    header("Location: MsKRS.php");
    exit();
}
?>
