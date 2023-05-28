<?php
session_start();
include("../functions.php");

if (isset($_POST["tambah_tugas"])) {

    $subject_id = $_POST["subject_id"];
    $nama = $_POST["nama"];
    $deskripsi = $_POST["deskripsi"];

    $sql = "INSERT INTO ASSIGNMENT (subject_id, assignment_name, assignment_desc) VALUES ('$subject_id', '$nama', '$deskripsi')";
    $query = mysqli_query($db, $sql);
    if ($query) {
        header("Location: ../lecturer/subject.php?subject_id=$subject_id");
    } else {
        header("Gagal menyimpan perubahan...");
    }
} else {
    die("Akses dilarang...");
}
