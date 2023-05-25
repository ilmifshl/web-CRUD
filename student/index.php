<?php
session_start();
include("../functions.php");

if (!isset($_SESSION["login"])) {
    header("Location: ../form/login.php");
    exit;
}

if ($_SESSION["role"] == "dosen") {
    header("Location: ../lecturer/");
    exit;
} else if ($_SESSION["role"] == "guest") {
    header("Location: ../guest_page.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
    header("Location: ../index.php");
    exit;
}

$email = $_SESSION["email"];
$logged = query("SELECT *, user.nama AS user_name FROM user 
                JOIN mahasiswa ON mahasiswa.email = user.email
                WHERE user.email='$email'")[0];
$students = query("SELECT * FROM MAHASISWA");
$users = query("SELECT * FROM USER");
$subjects = query("SELECT * FROM SUBJECT");
$scores = query("SELECT s.*, u.nama, sub.subject_name FROM SCORE s 
                JOIN SUBJECT sub ON s.subject_id = sub.subject_id 
                JOIN LECTURER l ON sub.nip = l.nip 
                JOIN USER u ON l.email = u.email 
                WHERE s.nrp = (SELECT nrp FROM MAHASISWA WHERE email = '$email')");


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
    <title>Student Page</title>
</head>

<body>
    <div class="flex">
        <div class="w-1/5 bg-[#161c18] h-screen fixed left-0 top-0">
            <div class="flex justify-center text-center items-center rounded-lg m-4 px-8 pt-4 pb-2 gap-x-4">
                <i class='bx bxs-graduation bx-lg text-white pb-1'></i>
                <h1 class="text-xl text-white text-center font-semibold pb-3">Learnology</h1>
            </div>
            <div class="flex justify-start items-center text-[#283c2e] mt-10 gap-2 bg-[#ebfbee] p-4 mx-4 rounded-lg transition duration-200">
                <i class='bx bxs-briefcase bx-sm'></i>
                <p class="text-md font-semibold">Dashboard</p>
            </div>
            <a href="./enroll.php" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 transition duration-200">
                <i class='bx bxs-log-in-circle bx-sm'></i>
                <p class="text-md font-semibold">Enroll</p>
            </a>
            <a href="./profile.php" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 transition duration-200">
                <i class='bx bxs-user bx-sm'></i>
                <p class="text-md font-semibold">Profile</p>
            </a>
            <div class="border border-gray-500 flex-grow mt-[230px]">

            </div>
            <a href="../controller/logout.php" class="flex justify-start items-center text-[#b7bcb8] mt-2 mb-8 gap-2 hover:bg-red-200 hover:text-red-700 p-4 mx-4 rounded-lg transition duration-200" >
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
                            <img src="../image/<?= $logged['gambar']?>" alt="" class="rounded-full w-9 mr-3">
                            <h2 class="font-semibold mr-5"><?= $logged["user_name"] ?></h2>
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

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-4">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-green-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Mata Kuliah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Dosen Pengampu
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tugas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                UTS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                UAS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scores as $score) : ?>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <?= $score['subject_name'] ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= $score['nama'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $score['tugas'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $score['uts'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $score['uas'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <button data-modal-target="popup-modal-delete-<?php echo $score['nrp'] ?>-<?php echo $score['subject_id'] ?>" data-modal-toggle="popup-modal-delete-<?php echo $score['nrp'] ?>-<?php echo $score['subject_id'] ?>" type="button" class="px-2 py-1.5 text-[#dc2626] hover:text-[#c22121] rounded">
                                        <p>Drop Matkul</p>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Drop Matkul -->
                            <div id="popup-modal-delete-<?php echo $score['nrp'] ?>-<?php echo $score['subject_id'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center transition duration-200" data-modal-hide="popup-modal-delete-<?php echo $score['nrp'] ?>-<?php echo $score['subject_id'] ?>">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-6 text-center">
                                            <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 ">Apakah Anda yakin ingin menghapus data ini?</h3>
                                            <a href="../controller/drop_matkul.php?subject_id=<?= $score["subject_id"] ?>">
                                                <button data-modal-hide="popup-modal-delete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 transition duration-200">
                                                    Ya, saya yakin.
                                                </button>
                                            </a>
                                            <button data-modal-hide="popup-modal-delete-<?php echo $score['nrp'] ?>-<?php echo $score['subject_id'] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition duration-200">Tidak, batalkan.</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>