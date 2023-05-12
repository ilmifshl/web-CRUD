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
$subjects = query("SELECT * FROM SUBJECT");

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
        <div class="w-1/5 bg-[#161c18] h-screen fixed left-0 top-0">
                <div class="flex justify-center text-center items-center rounded-lg m-4 px-8 pt-4 pb-2 gap-x-4">
                    <i class='bx bxs-graduation bx-lg text-white pb-1'></i>
                    <h1 class="text-xl text-white text-center font-semibold pb-3">Learnology</h1>
                </div>
                <div class="flex justify-start items-center text-[#283c2e] mt-10 gap-2 bg-[#ebfbee] p-4 mx-4 rounded-lg">
                    <i class='bx bxs-briefcase bx-sm'></i>
                    <p class="text-md font-semibold">Dashboard</p>
                </div>
                <div class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 ">
                <i class='bx bxs-user bx-sm'></i>
                    <p class="text-md font-semibold">Profile</p>
                </div>
                <div class="border border-gray-500 flex-grow mt-[305px]">

                </div>
                <a href="./controller/logout.php" class="flex justify-start items-center text-[#b7bcb8] mt-2 mb-8 gap-2 hover:bg-red-200 hover:text-red-700 p-4 mx-4 rounded-lg">
                    <i class='bx bxs-log-out bx-sm'></i>
                    <p class="text-md font-semibold pb-[4px]">Logout</p>
                </a>

        </div>
        <div class="w-full ml-[20%] bg-slate-50">
            <div class="mt-4 mx-8 flex justify-between">
                <div>
                    <p class="font-bold text-3xl">Lecturer Dashboard</p>
                    <p class="font-normal text-sm text-slate-500">Halo, User!</p>
                </div>
                <div class="flex">
                    <button type="button" class="relative inline-flex items-center px-2 h-10 text-sm font-medium text-center text-white bg-white rounded-lg hover:bg-slate-200 focus:ring-4 focus:outline-none focus:ring-slate-500 shadow-lg border border-gray-100">
                        <i class='bx bxs-bell bx-sm text-[#161c18]'></i>
                        <span class="sr-only">Notifications</span>
                        <div class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-medium text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2"> </div>
                    </button>
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="flex items-center text-gray-900 bg-white border border-gray-100 focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5  h-10  mb-2 ml-4 shadow-lg" type="button">
                        <i class='bx bx-plus'></i>
                        <p>Tambah Matkul</p>
                    </button>
                    <!-- <button type="button" class="flex text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5  mb-2 ml-4">

                    </button> -->
                </div>
            </div>
            <div class="grid grid-cols-3 gap-7 mx-8 my-4">
                <div class="bg-white shadow shadow-lg rounded-lg h-24">

                </div>
                <div class="bg-white shadow shadow-lg rounded-lg h-24">

                </div>
                <div class="bg-white shadow shadow-lg rounded-lg h-24">.
                </div>
            </div>
            <div class="mt-8">
                <div class="mx-8 font-bold text-2xl">
                    Mata Kuliah
                </div>
                <div class="flex justify-center items-center gap-4 mt-4 mx-8 grid grid-cols-3">
                    <?php foreach ($subjects as $subject) : ?>
                        <a href="#" class="gap-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-[#62a374] hover:text-white">
                            <div>
                                <p class="font-bold text-lg"><?= $subject["subject_name"] ?></p>
                                <p class="font-light text-sm"><?= $subject["major"] ?></p>
                            </div>
                            <div class="bg-[#31553b] w-32 h-8 text-white py-1 px-3 mt-2 rounded-lg">
                                
                                <p class="text-sm flex justify-between ietms-center "><i class='bx bxs-user pt-1'></i>24 Orang</p>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="flex">
        <div class="h-screen w-1/5 border-r border-slate-300">
            <div class="flex text-center items-center justify-center pt-6 pb-4 px-4 gap-x-2">
                <img class="h-14 w-14" src="./image/school.png" alt="">
                <h1 class="text-2xl text-slate-700 text-center font-semibold">Learnology</h1>
            </div>

            <div class="">
                <div class="flex items-center pl-6 py-3 text-[#51DD90] w-full h-full border-[#51DD90] border-l-4">
                    <i class='bx bx-file-blank text-xl'></i>
                    <p class="px-2 font-semibold">Mata Kuliah</p>
                </div>
            </div>
        </div>

        <div class="w-full p-6 bg-[#fbfcfa]"> -->
    <!-- <div class="flex justify-between"> -->
    <!-- Add Subject Button -->
    <!-- <div class="relative">
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="flex justify-center items-center bg-[#20a85e] text-white hover:text-white hover:bg-[#1a9653] px-4 py-2 gap-x-1 rounded-md" type="button">
                        <p>Tambah Mata Kuliah</p>
                        <i class='bx bx-plus pt-1'></i>
                    </button>
                </div> -->

    <!-- User Profile -->
    <!-- <div class="flex items-center gap-x-4 mr-4">
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

            </div> -->


    <!-- <div class="grid-cols-4 mt-4">
                <div class="flex justify-between items-center gap-2 w-48 h-28 bg-white shadow-md px-1.5 py-4 rounded rounded-lg">
                    <div class="ml-3">
                        <i class='bx bxs-book bx-lg'></i>
                    </div>
                    <div class="mx-1">
                        <p class="font-bold text-lg no">Mata Kuliah</p>
                        <p>10</p>
                    </div>
                </div>
                <div class="flex justify-between items-center w-48 h-28 bg-white shadow-md px-1 py-4 rounded rounded-lg">
                    <div class="ml-1">
                    <i class='bx bxs-user bx-lg'></i>
                    </div>
                    <div class="mr-4">
                        <p class="font-bold text-lg no">Mahasiswa</p>
                        <p>10</p>
                    </div>
                </div><div class="flex justify-between items-center gap-2 w-48 h-28 bg-white shadow-md px-1 py-4 rounded rounded-lg">
                    <div class="mx-1">
                    <i class='bx bx-plus bx-lg'></i>
                    </div>
                    <div class="mx-1">
                        <p class="font-bold text-lg no">Tambah Mata Kuliah</p>
                        <p></p>
                    </div>
                </div><div class="flex justify-between items-center gap-2 w-48 h-28 bg-white shadow-md px-1 py-4 rounded rounded-lg">
                    <div class="mx-1">
                        <img src="./image/profile.png" alt="" class="w-12">
                    </div>
                    <div class="mx-1">
                        <p class="font-bold text-lg no">Mata Kuliah</p>
                        <p>10</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center gap-4 mt-8 grid grid-cols-3">
                <?php foreach ($subjects as $subject) : ?>
                    <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                        <div>
                            <p class="font-bold text-lg"><?= $subject["subject_name"] ?></p>
                            <p class="font-light text-sm"><?= $subject["major"] ?></p>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>

        </div>
    </div> -->

    <!-- Modal Add Subject -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="authentication-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 ">Tambah Mata Kuliah</h3>
                    <form class="space-y-4" action="./controller/tambah_subject.php" method="POST">
                        <div class="relative">
                            <input type="text" id="subject_name" name="subject_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " />
                            <label for="subject_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama Mata Kuliah</label>
                        </div>
                        <div>
                            <label for="major" class="block mb-2 text-sm font-medium text-gray-900"></label>
                            <select id="major" name="major" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                <option value=" " selected>Pilih Jurusan</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sains Data Terapan">Sains Data Terapan</option>
                            </select>
                        </div>
                        <button type="submit" name="tambah_subject" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- </div> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>