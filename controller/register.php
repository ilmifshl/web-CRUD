<?php
session_start();
include("../functions.php");

if (isset($_POST["register"])) {
    $result = registration($_POST);
    if ($result["status"] === "error") {
        $_SESSION["message"] = $result["message"];
        header("Location: ../form/register.php");
        exit;
    } elseif ($result["status"] === "success") {
        $_SESSION["message"] = $result["message"];
        header("Location: ../form/login.php");
        exit;
    } else {
        $_SESSION["message"] = "Registration failed";
        header("Location: ../form/register.php");
        exit;
    }
} else {
    header("Location: ../form/register.php");
    exit;
}
?>
