<?php
$con = mysqli_connect("localhost", "root", "", "uts_webprog");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>