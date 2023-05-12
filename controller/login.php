<?php
session_start();
include("../connect.php");

if (isset($_POST["login"])) {
  global $db;
  $email = $_POST["email"];
  $password = $_POST["password"];
  $result = mysqli_query($db, "SELECT * FROM USER WHERE email = '$email'");
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;
      $_SESSION["username"] = $row["username"];
      $_SESSION["email"] = $row["email"];

      if (isset($_POST["remember"])) {
        setcookie("email", $row["email"], time() + 86400, "/");
        setcookie("key", hash("sha256", $row["username"]), time() + 86400, "/");
      }

      if ($row["role"] == "guest"){
        $_SESSION["role"] = "guest";
        header("Location: ../guest_page.php");
        exit;
      } else if ($row["role"] == "dosen"){
        $_SESSION["role"] = "dosen";
        header("Location: ../dosen_page.php");
        exit;
      } else if ($row["role"] == "mahasiswa"){
        $_SESSION["role"] = "mahasiswa";
        header("Location: ../mahasiswa_page.php");
        exit;
      } else {
        $_SESSION["role"] = "admin";
        header("Location: ../index.php");
        exit;
      }
    } else {
      $_SESSION["error_message"] = "Username atau password salah";
      header("Location: ../form/login.php");
    }
  } else {
    $_SESSION["error_message"] = "Username/email tidak ditemukan";
    header("Location: ../form/login.php");
  }
} else {
  die("Akses dilarang...");
}