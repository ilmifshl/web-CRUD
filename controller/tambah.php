<?php
session_start();
include("../functions.php");

if (isset($_POST["tambah"])) {
  $result = addData($_POST);
  $_SESSION["message"] = $result["result"];
  if ($result["status"] > 0)
    header("Location: ../admin.php");
  else {
    $_SESSION["error"] = "error";
    header("Location: ../form/tambah.php");
  }
} else {
  die("Akses dilarang...");
}