<?php
session_start();
session_destroy();
header("Location: ../LoginPage/Login.php");
exit();