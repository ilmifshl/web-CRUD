<?php
session_start();
include("../connect.php");

$subject_id = $_POST["subject_id"];
$subject_name = $_POST["subject_name"];
$major = $_POST["major"];

$sql = "UPDATE subject SET subject_name='$subject_name', major = '$major' WHERE subject_id = '$subject_id'";

$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../lecturer/daftar_matkul.php");
} else {
  header("Gagal menyimpan perubahan...");
}
