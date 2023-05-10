<?php
session_start();
include("../functions.php");

if (isset($_POST["tambah"])) {
  $result = addData($_POST);
  if ($result["status"] > 0)
    header("Location: ../index.php");
  else {
    $_SESSION["error"] = "error";
    header("Location: ../form/tambah.php");
  }
} else {
  die("Akses dilarang...");
}