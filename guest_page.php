<?php
session_start();
include("./functions.php");

if (!isset($_SESSION["login"])) {
  header("Location: ./form/login.php");
  exit;
}
if ($_SESSION["role"] == "mahasiswa") {
  header("Location: ./student");
  exit;
} else if ($_SESSION["role"] == "dosen") {
  header("Location: ./lecturer");
  exit;
} else if ($_SESSION["role"] == "admin") {
  header("Location: admin.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

  <title>Guest Page</title>
</head>

<body>
  <div class="flex justify-center items-center mt-[100px] ml-[420px] w-[28rem]">
    <img class="" src="./image/undraw_feeling_blue_4b7q.png" alt="">
  </div>
  <div class="font-semibold text-lg text-center">
    <p>Maaf, Anda tidak mempunyai akses apapun.</p>
    <p>Harap menghubungi admin untuk mengganti role Anda.</p>
  </div>
  <div class="flex justify-center items-center mt-4">
    <a href="./controller/logout.php" class="text-slate-600 border border-slate-200 bg-white hover:bg-red-600  hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 shadow-lg transition duration-300">Logout</a>
  </div>
</body>

</html>