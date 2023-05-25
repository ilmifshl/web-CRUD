<?php
session_start();
include("../functions.php");

if (isset($_POST["tambah_dosen"])) {
  $nip = $_POST["nip"];
  $email = $_POST["email"];

  try {
    $gambar = upload();
  } catch (Exception $e) {
    return array("status" => -1, "result" => $e->getMessage());
  }

  $sql = "INSERT INTO LECTURER (nip, email, gambar) VALUES ('$nip', '$email', '$gambar')";
  $query = mysqli_query($db, $sql);
  if ($query) {
    header("Location: ../index.php");
  } else {
    header("Gagal menyimpan perubahan...");
  }
} else {
  die("Akses dilarang...");
}
