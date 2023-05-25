<?php
session_start();
include("../connect.php");

$nip = $_POST["nip"];
$alamat = $_POST["alamat"];
$no_hp = $_POST["no_hp"];

$sql = "UPDATE lecturer l SET alamat = '$alamat', no_hp = '$no_hp' WHERE nip = '$nip'";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../lecturer/profile.php");
} else {
  header("Gagal menyimpan perubahan...");
}
