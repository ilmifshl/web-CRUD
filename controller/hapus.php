<?php
session_start();
include("../connect.php");

if (isset($_GET["nrp"])) {
  $nrp = $_GET["nrp"];
  $sql = "DELETE FROM MAHASISWA WHERE nrp = $nrp";
  $query = mysqli_query($db, $sql);

  if ($query) {
    header("Location: ../index.php");
  } else {
    die("Gagal menghapus...");
  }
} else {
  die("Akses dilarang...");
}