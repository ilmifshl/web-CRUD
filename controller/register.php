<?php
include("../functions.php");

if (isset($_POST["register"])) {
    $result = registration($_POST);
    if ($result > 0)
         header("Location: ../form/login.php");
     else
         header("Location: ../form/register.php");
} else {
     header("Location: ../form/register.php");
}
