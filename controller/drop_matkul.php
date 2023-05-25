<?php
session_start();
include("../connect.php");

$email = $_SESSION["email"];
$query = mysqli_query($db, "SELECT nrp FROM MAHASISWA WHERE email='$email'");
$row = mysqli_fetch_assoc($query);
$nrp = $row['nrp'];
$subject_id = $_GET["subject_id"];

// Hapus data dari tabel enrollments
$sql_enrollment = "DELETE FROM Enrollment WHERE nrp = '$nrp' AND subject_id = '$subject_id'";
$query_enrollment = mysqli_query($db, $sql_enrollment);

// Hapus data dari tabel score
$sql_score = "DELETE FROM Score WHERE nrp = '$nrp' AND subject_id = '$subject_id'";
$query_score = mysqli_query($db, $sql_score);

if ($query_enrollment && $query_score) {
    header("Location: ../student/");
} else {
    die("Gagal menghapus...");
}
?>
