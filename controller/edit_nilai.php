<?php
session_start();
include("../connect.php");

$nrp = $_GET["nrp"];
$assignment_id = $_POST["assignment_id"];
$grade = $_POST["grade"];

$sql = "UPDATE SCORE SET grade='$grade' WHERE nrp = '$nrp' AND assignment_id = '$assignment_id'";

$query = mysqli_query($db, $sql);

if ($query) {
  header("Location: ../lecturer/tugas.php?assignment_id=$assignment_id");
} else {
  echo "Gagal menyimpan perubahan...";
}
?>
