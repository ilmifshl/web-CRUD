<?php
session_start();
include("../connect.php");

if(isset($_POST["edit_role"])) {
    global $db;
    $email = $_GET["email"];
    $role = $_POST["role"];
    
    $sql = "UPDATE USER SET role='$role' WHERE email='$email'";
    $query = mysqli_query($db, $sql);
    
    if ($query) {
      header("Location: ../");
    } else {
      header("Gagal menyimpan perubahan...");
    }
}
