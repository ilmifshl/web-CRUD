<?php

$server = "127.0.0.1:3307";
$user = "root";
$password = "";
$database = "mahasiswa";
$db =  mysqli_connect($server, $user, $password, $database);

if (!$db) {
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}