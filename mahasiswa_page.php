<?php
session_start();
include("functions.php");

if (!isset($_SESSION["login"])) {
  header("Location: ./form/login.php");
  exit;
}

if ($_SESSION["role"] == "dosen") {
    header("Location: dosen_page.php");
    exit;
} else if ($_SESSION["role"] == "guest") {
    header("Location: guest_page.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Mahasiswa PAGE</h2>
</body>
</html>