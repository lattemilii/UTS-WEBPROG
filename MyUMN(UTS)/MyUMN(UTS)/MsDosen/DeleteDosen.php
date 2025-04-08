<?php
require '../db.php';

if (isset($_GET['NIK'])) {
    $nik = $_GET['NIK'];
    $stmt = $con->prepare("DELETE FROM users WHERE NIK = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $stmt = $con->prepare("DELETE FROM dosen WHERE NIK = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    header("Location: MsDosen.php");
    exit();
}
?>