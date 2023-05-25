<?php
session_start();
include("../connect.php");

if (isset($_GET["subject_id"])) {
  $subject_id = $_GET["subject_id"];
  $sql = "DELETE FROM SUBJECT WHERE subject_id = $subject_id";
  $query = mysqli_query($db, $sql);

  if ($query) {
    header("Location: ../lecturer/daftar_matkul.php");
  } else {
    die("Gagal menghapus...");
  }
} else {
  die("Akses dilarang...");
}