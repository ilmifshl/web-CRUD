<?php
session_start();
include("../functions.php");

if (!isset($_SESSION["login"])) {
    header("Location: ../form/login.php");
    exit;
}

if ($_SESSION["role"] == "mahasiswa") {
    header("Location: ../student/");
    exit;
} else if ($_SESSION["role"] == "guest") {
    header("Location: ../guest_page.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
    header("Location: ../index.php");
    exit;
}



date_default_timezone_set('Asia/Jakarta');

// Mendapatkan tanggal hari ini
$tanggal = date('d F Y');

// Mendapatkan nama hari pada tanggal hari ini
$hari = date('l', strtotime($tanggal));


$email = $_SESSION["email"];
$logged = query("SELECT * FROM user WHERE email='$email'")[0];
$nipResult = query("SELECT nip FROM LECTURER WHERE email='$email'");
$nip = $nipResult[0]['nip'];
$students = query("SELECT * FROM MAHASISWA");
$users = query("SELECT * FROM USER");
$jumlahMhs = query("SELECT DISTINCT nrp FROM enrollment e
                    JOIN subject s ON e.subject_id = s.subject_id
                    JOIN lecturer l ON s.nip = l.nip
                    WHERE l.nip = '$nip'");
$subjects = query("SELECT * FROM SUBJECT 
                    JOIN LECTURER ON subject.nip=lecturer.nip
                    JOIN USER ON lecturer.email=user.email
                    WHERE user.email='$email'");

$lecturer = query("SELECT * FROM LECTURER WHERE email='$email'")[0];

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
    <title>Lecturer Page</title>
</head>

<body>
    <div class="flex">
        <div class="w-1/5 bg-[#161c18] h-screen fixed left-0 top-0">
            <div class="flex justify-center text-center items-center rounded-lg m-4 px-8 pt-4 pb-2 gap-x-4">
                <i class='bx bxs-graduation bx-lg text-white pb-1'></i>
                <h1 class="text-xl text-white text-center font-semibold pb-3">Learnology</h1>
            </div>
            <div class="flex justify-start items-center text-[#283c2e] mt-10 gap-2 bg-[#ebfbee] p-4 mx-4 rounded-lg transition duration-300">
                <i class='bx bxs-briefcase bx-sm'></i>
                <p class="text-md font-semibold">Dashboard</p>
            </div>
            <a href="./daftar_matkul.php" class="flex justify-start items-center fill-current text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 transition duration-300">
                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-google-classroom" viewBox="0 0 24 24">
                    <path d="M23,2H1A1,1 0 0,0 0,3V21A1,1 0 0,0 1,22H23A1,1 0 0,0 24,21V3A1,1 0 0,0 23,2M22,20H20V19H15V20H2V4H22V20M10.29,9.71A1.71,1.71 0 0,1 12,8C12.95,8 13.71,8.77 13.71,9.71C13.71,10.66 12.95,11.43 12,11.43C11.05,11.43 10.29,10.66 10.29,9.71M5.71,11.29C5.71,10.58 6.29,10 7,10A1.29,1.29 0 0,1 8.29,11.29C8.29,12 7.71,12.57 7,12.57C6.29,12.57 5.71,12 5.71,11.29M15.71,11.29A1.29,1.29 0 0,1 17,10A1.29,1.29 0 0,1 18.29,11.29C18.29,12 17.71,12.57 17,12.57C16.29,12.57 15.71,12 15.71,11.29M20,15.14V16H16L14,16H10L8,16H4V15.14C4,14.2 5.55,13.43 7,13.43C7.55,13.43 8.11,13.54 8.6,13.73C9.35,13.04 10.7,12.57 12,12.57C13.3,12.57 14.65,13.04 15.4,13.73C15.89,13.54 16.45,13.43 17,13.43C18.45,13.43 20,14.2 20,15.14Z" />
                </svg>
                <p class="text-md font-semibold">Daftar Mata Kuliah</p>
            </a>
            <a href="./profile.php" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-3 gap-2 transition duration-300">
                <i class='bx bxs-user bx-sm'></i>
                <p class="text-md font-semibold">Profile</p>
            </a>
            <div class="border border-gray-500 flex-grow mt-[240px]">

            </div>
            <a href="../controller/logout.php" class="flex justify-start items-center text-[#b7bcb8] mt-2 mb-8 gap-2 hover:bg-red-200 hover:text-red-700 p-4 mx-4 rounded-lg transition duration-300">
                <i class='bx bxs-log-out bx-sm'></i>
                <p class="text-md font-semibold pb-[4px]">Logout</p>
            </a>

        </div>
        <div class="w-full ml-[20%] bg-slate-50 h-screen">
            <div class="mt-4 mx-8 flex justify-between">
                <div>
                    <p class="font-bold text-3xl">Dashboard</p>
                    <p class="font-normal text-md text-slate-500">Halo, <?= $_SESSION["username"] ?>!</p>
                </div>
                <div class="flex">
                    <button type="button" class="relative inline-flex items-center mr-4 mt-3 px-2 h-10 text-sm font-medium text-center text-white rounded-lg hover:bg-slate-200 focus:ring-1 focus:outline-none focus:ring-slate-500  border border-gray-100">
                        <i class='bx bxs-bell bx-sm text-[#161c18]'></i>
                        <span class="sr-only">Notifications</span>
                        <div class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-medium text-white bg-red-500 border-2 border-white rounded-full -top-0 right-0"> </div>
                    </button>
                    <div class="flex items-center gap-x-4 mr-4">
                        <button id="dropdownDefaultButton" class="flex items-center" data-dropdown-toggle="dropdown">
                            <img src="../image/<?= $lecturer['gambar'] ?>" alt="" class="rounded-full w-9 mr-3">
                            <h2 class="font-semibold mr-5"><?= $logged["nama"] ?></h2>
                            <i class='bx bxs-chevron-down rounded cursor-pointer text-[#4b5563] pt-1'></i>
                        </button>
                        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-[0_5px_20px_rgba(92,99,105,0.3)] w-44" style="left: -32px !important">
                            <ul class="py-2 text-sm" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="./profile.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                                </li>
                                <li>
                                    <a href="../controller/logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-5 mx-8 my-4">
                <div class="flex justify-between items-center items-center bg-green-50 shadow-lg rounded-lg py-6 px-8">
                    <div class="bg-white p-2 rounded-lg shadow">
                        <svg class="w-8 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-account-multiple" viewBox="0 0 24 24">
                            <path d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z" />
                        </svg>
                    </div>
                    <div class="mt-2 ml-6">
                        <p class="font-semibold text-sm">Jumlah Mahasiswa</p>
                        <p class="font-bold text-md text-slate-900"><?= count($jumlahMhs)?> Orang</p>
                    </div>
                </div>
                <div class="flex justify-between items-center items-center bg-green-50 shadow-lg rounded-lg p-6 px-8">
                    <div class="flex justify-center items-center bg-white p-2 rounded-lg shadow text-3xl w-12 h-12">
                        <i class='bx bxs-book'></i>
                    </div>
                    <div class="mt-2 ml-6">
                        <p class="font-semibold text-sm">Jumlah Mata Kuliah</p>
                        <p class="font-bold text-md text-slate-900"><?= count($subjects) ?></p>
                    </div>
                </div>
                <div class="flex justify-between items-center items-center bg-green-50 shadow-lg rounded-lg p-6 px-8">
                    <div class="flex justify-center items-center bg-white p-2 rounded-lg shadow text-3xl w-12 h-12">
                    <i class='bx bxs-calendar' ></i>
                    </div>
                    <div class="mt-2 ml-4 mr-4">
                        <p class="font-semibold text-sm"><?= $hari ?>,</p>
                        <p class="font-bold text-md text-slate-900"><?= $tanggal?></p>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <div class="flex justify-between mx-8 ">
                    <p class="font-bold text-2xl">Mata Kuliah</p>
                    <a href="./daftar_matkul.php" class="mt-1 text-[#31553b] hover:text-[#161c18]">Lihat Detail</a>
                </div>
                <div class="gap-5 my-4 mx-8 grid grid-cols-3">
                    <?php $counter = 0; ?>

                    <?php foreach ($subjects as $subject) : ?>
                        <?php if ($counter >= 6) break; ?>

                        <a href="./daftar_matkul.php" class="gap-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-[#31553b] hover:text-white transition duration-200">
                            <div>
                                <p class="font-bold text-lg"><?= $subject["subject_name"] ?></p>
                                <p class="font-light text-sm"><?= $subject["major"] ?></p>
                            </div>
                        </a>

                        <?php $counter++; ?>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>

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
                    <form class="space-y-4" action="../controller/tambah_subject.php" method="POST">
                        <div class="relative">
                            <input type="text" id="subject_name" name="subject_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " required />
                            <label for="subject_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama Mata Kuliah</label>
                        </div>
                        <div>
                            <label for="class" class="block mb-2 text-sm font-medium text-gray-900"></label>
                            <select id="class" name="class" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                                <option value="" selected>Pilih Kelas</option>
                                <option value="1 D4 Sains Data Terapan A">1 D4 Sains Data Terapan A</option>
                                <option value="1 D4 Teknik Informatika A">1 D4 Teknik Informatika A</option>
                                <option value="1 D4 Teknik Informatika B">1 D4 Teknik Informatika B</option>
                                <option value="1 D3 Teknik Informatika A">1 D3 Teknik Informatika A</option>
                                <option value="1 D3 Teknik Informatika B">1 D3 Teknik Informatika B</option>
                                <option value="2 D4 Teknik Informatika A">2 D4 Teknik Informatika A</option>
                                <option value="2 D4 Teknik Informatika B">2 D4 Teknik Informatika B</option>
                                <option value="2 D3 Teknik Informatika A">2 D3 Teknik Informatika A</option>
                                <option value="2 D3 Teknik Informatika B">2 D3 Teknik Informatika B</option>
                                <option value="3 D4 Teknik Informatika A">3 D4 Teknik Informatika A</option>
                                <option value="3 D4 Teknik Informatika B">3 D4 Teknik Informatika B</option>
                                <option value="3 D3 Teknik Informatika A">3 D3 Teknik Informatika A</option>
                                <option value="3 D3 Teknik Informatika B">3 D3 Teknik Informatika B</option>
                                <option value="4 D4 Teknik Informatika A">4 D4 Teknik Informatika A</option>
                                <option value="4 D4 Teknik Informatika B">4 D4 Teknik Informatika B</option>
                                <option value="4 D3 Teknik Informatika A">4 D3 Teknik Informatika A</option>
                                <option value="4 D3 Teknik Informatika B">4 D3 Teknik Informatika B</option>
                            </select>
                        </div>
                        <button type="submit" name="tambah_subject" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-1 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- </div> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>