<?php
session_start();
include("../connect.php");

$nrp = $_POST["nrp"];
$nama = $_POST["nama"];
$jenis_kelamin = $_POST["jenis_kelamin"];
$jurusan = $_POST["jurusan"];
$email = $_POST["email"];
$gambar = $_POST["gambar"];

$sql = "UPDATE mahasiswa SET nrp='$nrp', nama = '$nama', jenis_kelamin = '$jenis_kelamin', jurusan = '$jurusan', email = '$email', gambar = '$gambar' WHERE nrp = '$nrp'";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../index.php");
} else {
  header("Gagal menyimpan perubahan...");
}
