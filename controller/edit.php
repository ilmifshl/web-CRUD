<?php

include("../connect.php");

$nrp = $_POST["nrp"];
$nrpAwal = $_POST["nrp_awal"];
$nama = $_POST["nama"];
$jenis_kelamin = $_POST["edit_jenis_kelamin"];
$jurusan = $_POST["jurusan"];
$email = $_POST["email"];
$alamat = $_POST["alamat"];
$no_hp = $_POST["no_hp"];
$status = $_POST["edit_status"];

$sql = "UPDATE mahasiswa SET nrp='$nrp', nama = '$nama', jenis_kelamin = '$jenis_kelamin', jurusan = '$jurusan', email = '$email', alamat = '$alamat', no_hp = '$no_hp', status = '$status' WHERE nrp = '$nrpAwal'";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../index.php");
} else {
  header("Gagal menyimpan perubahan...");
}
