<?php
session_start();
include("../connect.php");

if (isset($_GET["nip"])) {
  $nip = $_GET["nip"];
  $sql = "DELETE FROM LECTURER WHERE nip = '$nip'";
  $query = mysqli_query($db, $sql);

  if ($query) {
    header("Location: ../index.php");
  } else {
    die("Gagal menghapus...");
  }
} else {
  die("Akses dilarang...");
}