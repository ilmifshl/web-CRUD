<?php
session_start();
include("../functions.php");

if (isset($_POST["tambah_subject"])) {
  $result = addSubject($_POST);
  $_SESSION["message"] = $result["result"];
  if ($result["status"] < 0)
    $_SESSION["error"] = "error";
  header("Location: ../dosen_page.php");
} else {
  die("Akses dilarang...");
}