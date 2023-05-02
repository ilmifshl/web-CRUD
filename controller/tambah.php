<?php

include("../connect.php");

$nrp = $_POST["nrp"];
$nama = $_POST["nama"];
$jenis_kelamin = $_POST["jenis_kelamin"];
$jurusan = $_POST["jurusan"];
$email = $_POST["email"];
$alamat = $_POST["alamat"];
$no_hp = $_POST["no_hp"];

// upload foto
$foto  = upload();
if(!$foto){
  return false;
}


$sql = "INSERT INTO MAHASISWA (nrp, nama, jenis_kelamin, jurusan, email, alamat, no_hp, foto) VALUES ('$nrp', '$nama', '$jenis_kelamin', '$jurusan', '$email', '$alamat', '$no_hp', '$foto')";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../index.php?status=sukses");
} else {
  header("Location: ../index.php?status=gagal");
}

function upload(){
  $fileName = $_FILES["foto"]["name"];
  $fileSize = $_FILES["foto"]["size"];
  $error = $_FILES["foto"]["error"];
  $tmpName = $_FILES["foto"]["tmp_name"];
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
      alert('File foto harus berekstensi jpg, jpeg, atau png.');
    </script>";
$flag = true;
  }

  if ($fileSize > 3145728) {
    echo "<script>
      alert('Ukuran foto tidak boleh melebihi 3 MB.');
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