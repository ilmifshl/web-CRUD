<?php

include("../connect.php");

$nrp = $_POST["nrp"];
$nama = $_POST["nama"];
$jenis_kelamin = $_POST["jenis_kelamin"];
$jurusan = $_POST["jurusan"];
$email = $_POST["email"];
$alamat = $_POST["alamat"];
$no_hp = $_POST["no_hp"];
$status = $_POST["status"];

$sql = "INSERT INTO MAHASISWA (nrp, nama, jenis_kelamin, jurusan, email, alamat, no_hp, status) VALUES ('$nrp', '$nama', '$jenis_kelamin', '$jurusan', '$email', '$alamat', '$no_hp', '$status')";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../index.php?status=sukses");
} else {
  header("Location: ../index.php?status=gagal");
}
