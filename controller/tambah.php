<?php

include("../connect.php");

$nrp = $_POST["nrp"];
$nama = $_POST["nama"];
$jenis_kelamin = $_POST["jenis_kelamin"];
$jurusan = $_POST["jurusan"];
$email = $_POST["email"];


// upload gambar
$gambar  = upload();
if(!$gambar){
  return false;
}


$sql = "INSERT INTO MAHASISWA (nrp, nama, jenis_kelamin, jurusan, email, gambar) VALUES ('$nrp', '$nama', '$jenis_kelamin', '$jurusan', '$email', '$gambar')";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../index.php?status=sukses");
} else {
  header("Location: ../index.php?status=gagal");
}

function upload(){
  $fileName = $_FILES["gambar"]["name"];
  $fileSize = $_FILES["gambar"]["size"];
  $error = $_FILES["gambar"]["error"];
  $tmpName = $_FILES["gambar"]["tmp_name"];
  $validExt = ['png', 'jpg', 'jpeg'];
  $tmp = explode(".", $fileName);
  $fileExt = strtolower(end($tmp));

  $flag = false;
if ($error === 4) {
    echo "<script>
      alert('Upload file gambar terlebih dahulu!');
    </script>";
$flag = true;
  }

  if (!in_array($fileExt, $validExt)) {
    echo "<script>
      alert('File gambar harus berekstensi jpg, jpeg, atau png.');
    </script>";
$flag = true;
  }

  if ($fileSize > 3145728) {
    echo "<script>
      alert('Ukuran gambar tidak boleh melebihi 3 MB.');
  </script>";
$flag = true;
}

if ($flag) {
header("Location: ../index.php");
}

  $newFileName = uniqid() . "." . $fileExt;
  move_uploaded_file($tmpName, "../image/" . $newFileName);
  return $newFileName;
}