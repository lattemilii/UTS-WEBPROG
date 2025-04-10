<?php
$con = mysqli_connect("localhost", "root", "", "uts_webprog");
//if in hosting username, password, db name is different and will be attached in submission.txt
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>
