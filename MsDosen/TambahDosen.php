<?php
session_start();
require '../db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../LoginPage/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['NIK'] ?? '';
    $nama = $_POST['Nama'] ?? '';
    $gelar = $_POST['Gelar'] ?? '';
    $lulusan = $_POST['Lulusan'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $email = $_POST['email'] ?? '';
    $telp = $_POST['Telp'] ?? '';
    $user_input = $_SESSION['email'] ?? '';
    $tanggal_input = date('Y-m-d H:i:s');
    $password = str_replace('-', '', $dob);
    $hpass = password_hash($password, PASSWORD_DEFAULT);

    function generateEmail($nama, $con){
        $new_email = strtolower(str_replace(' ', '.', $nama)) . '@lecturer.umn.ac.id';
        $email = $new_email;
        $counter = 1;

        $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        while ($count > 0) {
            $email = strtolower(str_replace(' ', '.', $nama)) . $counter . '@lecturer.umn.ac.id';
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

    $email = generateEmail($nama, $con);

    $cek = $con->prepare("SELECT * FROM users WHERE NIK = ?");
    $cek->bind_param("s", $nik);
    $cek->execute();
    $cek->store_result();
    $result = $cek->num_rows;

    //insert to users
    if ($result == 0) {
        $insert = $con->prepare("INSERT INTO users (email, password, role, NIK) VALUES (?, ?, 'dosen', ?)");
        $insert->bind_param("sss", $email, $hpass, $nik);
        if($insert->execute()) {
            header("Location: MsDosen.php");
        } else {
            echo "Data gagal masuk " . $insert->error;
        }
    }  

    //insert to dosen
    $stmt = $con->prepare("INSERT INTO dosen (NIK, Nama, dob, Gelar, Lulusan, email, Telp, User_Input, Tanggal_Input) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nik, $nama,$dob, $gelar, $lulusan, $email, $telp, $user_input, $tanggal_input);
    if($stmt->execute()) {
        header("Location: MsDosen.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
    <link rel="stylesheet" href="MsDosen.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Dosen</h1>
        <form action="TambahDosen.php" method="post">
        <div class="form-group">
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="NIK" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="Nama" required>
        </div>
        <div class="form-group">
            <label for="dob">DOB:</label>
            <input type="date" id="dob" name="dob" required>
        </div>
        <div class="form-group">
            <label for="gelar">Gelar:</label>
            <input type="text" id="gelar" name="Gelar" required>
        </div>
        <div class="form-group">
            <label for="lulusan">Lulusan:</label>
            <input type="text" id="lulusan" name="Lulusan" required>
        </div>
        <div class="form-group">
            <label for="telp">Telp:</label>
            <input type="text" id="telp" name="Telp" required>
        </div>
        <button type="submit" class="btn">Tambah</button>
        <button type="button" class="btn" onclick="window.location.href='MsDosen.php'">Batal</button>
    </form>
    </div>
</body>
</html>

