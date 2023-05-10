<?php
session_start();
include("functions.php");

if (!isset($_SESSION["login"])) {
    header("Location: ./form/login.php");
    exit;
}

if ($_SESSION["role"] == "mahasiswa") {
    header("Location: mahasiswa_page.php");
    exit;
} else if ($_SESSION["role"] == "guest") {
    header("Location: guest_page.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
    header("Location: index.php");
    exit;
}

$students = query("SELECT * FROM MAHASISWA");
$users = query("SELECT * FROM USER");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
</head>

<body>
    <div class="flex">
        <div class="h-screen w-1/5 border-r border-slate-300">
            <!-- Logo -->
            <div class="flex text-center items-center justify-center pt-6 pb-4 px-4 gap-x-2">
                <img class="h-14 w-14" src="./image/school.png" alt="">
                <h1 class="text-2xl text-slate-700 text-center font-semibold">Learnology</h1>
            </div>

            <!-- Menu -->
            <div class="">
                <div class="flex items-center pl-6 py-3 text-[#51DD90] w-full h-full border-[#51DD90] border-l-4">
                    <i class='bx bx-file-blank text-xl'></i>
                    <p class="px-2 font-semibold">Mata Kuliah</p>
                </div>
                <div class="flex items-center pl-6 py-3 text-slate-400 hover:text-[#51DD90] w-full h-full">
                    <i class='bx bx-file-blank text-xl'></i>
                    <p class="px-2 font-semibold ">Database</p>
                </div>
                <div class="flex items-center pl-6 py-3 text-slate-400 hover:text-[#51DD90] w-full h-full">
                    <i class='bx bx-file-blank text-xl'></i>
                    <p class="px-2 font-semibold ">Database</p>
                </div>
            </div>
        </div>

        <div class="w-full p-6">
            <div class="flex justify-between">
                <div class="relative">
                    <p> </p>
                    <!-- <input type="text" id="keyword" class="w-80 rounded border border-[#bfbfbf] bg-[#F5F5F5] h-full pl-8 py-2 focus:outline-none" placeholder="Cari data disini..." autocomplete="off">
          <button id="search-button" class="absolute inset-y-[20%] left-2 text-lg"><i class='bx bx-search'></i></button> -->
                </div>

                <div class="flex items-center gap-x-4">
                    <button id="dropdownDefaultButton" class="flex items-center" data-dropdown-toggle="dropdown">
                        <img src="https://www.gravatar.com/avatar/2c7d99fe281ecd3bcd65ab915bac6dd5?s=250" alt="" class="rounded-full w-9 mr-3">
                        <h2 class="font-semibold mr-5"><?= $_SESSION["username"] ?></h2>
                        <i class='bx bxs-chevron-down rounded cursor-pointer text-[#4b5563] pt-1'></i>
                    </button>
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-[0_5px_20px_rgba(92,99,105,0.3)] w-44" style="left: -32px !important">
                        <ul class="py-2 text-sm" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                            </li>
                            <li>
                                <a href="./controller/logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="flex justify-center items-center gap-4 mt-8 ">
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div>
                        <p class="font-bold text-lg">Mata Kuliah 1</p>
                        <p class="font-light text-sm">Dosen Pengampu</p>
                    </div>
                </a>
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div>
                        <p class="font-bold text-lg">Mata Kuliah 1</p>
                        <p class="font-light text-sm">Dosen Pengampu</p>
                    </div>
                </a>
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div>
                        <p class="font-bold text-lg">Mata Kuliah 1</p>
                        <p class="font-light text-sm">Dosen Pengampu</p>
                    </div>
                </a>
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div>
                        <p class="font-bold text-lg">Mata Kuliah 1</p>
                        <p class="font-light text-sm">Dosen Pengampu</p>
                    </div>
                </a>
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div>
                        <p class="font-bold text-lg">Mata Kuliah 1</p>
                        <p class="font-light text-sm">Dosen Pengampu</p>
                    </div>
                </a>
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div>
                        <p class="font-bold text-lg">Mata Kuliah 1</p>
                        <p class="font-light text-sm">Dosen Pengampu</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>