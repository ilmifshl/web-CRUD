<?php
session_start();
include("../functions.php");

$email = $_SESSION["email"];
$nrp = query("SELECT nrp FROM MAHASISWA WHERE email='$email'");
$nrp = $nrp[0]['nrp'];
$subject_id = $_GET["subject_id"];

$sql = "INSERT INTO ENROLLMENT VALUES ('', '$subject_id', '$nrp')";
$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../student/enroll.php");
} else {
  header("Gagal menyimpan perubahan...");
}
?>