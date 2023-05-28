<?php
session_start();
include("../functions.php");

if (isset($_POST["submit_tugas"])) {
  $subject_id = $_POST["subject_id"];
  $nrp = $_POST["nrp"];
  $assignment_id = $_POST["assignment_id"];

  try {
    $file = uploadFile();
  } catch (Exception $e) {
    return array("status" => -1, "result" => $e->getMessage());
  }

  $sql = "INSERT INTO SCORE (assignment_id, nrp, file, grade) VALUES ('$assignment_id', '$nrp', '$file', '-')";
  $query = mysqli_query($db, $sql);
  if ($query) {
    header("Location: ../student/tugas.php?subject_id=$subject_id");
  } else {
    header("Gagal menyimpan perubahan...");
  }
} else {
  die("Akses dilarang...");
}
