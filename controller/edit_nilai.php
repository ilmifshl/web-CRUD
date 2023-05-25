<?php
session_start();
include("../connect.php");

$nrp = $_GET["nrp"];
$subject_id = $_POST["subject_id"];
$tugas = $_POST["tugas"];
$uts = $_POST["uts"];
$uas = $_POST["uas"];

$sql = "UPDATE SCORE SET tugas='$tugas', uts = '$uts', uas = '$uas' WHERE nrp = '$nrp' AND subject_id = '$subject_id'";

$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../lecturer/subject.php?subject_id='$subject_id'");
} else {
  header("Gagal menyimpan perubahan...");
}
