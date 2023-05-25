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
$nrpResult = query("SELECT nrp FROM MAHASISWA WHERE email='$email'");
$nrp = $nrpResult[0]['nrp'];
$jurusanMhsResult = query("SELECT jurusan FROM mahasiswa WHERE email='$email'");
$jurusanMhs = $jurusanMhsResult[0]['jurusan'];
$users = query("SELECT * FROM USER");
$subjects = query("SELECT s.subject_id, u.nama, s.subject_name
                    FROM SUBJECT s
                    JOIN LECTURER l ON s.nip = l.nip
                    JOIN USER u ON l.email = u.email
                    LEFT JOIN ENROLLMENT e ON s.subject_id = e.subject_id AND e.nrp = '$nrp'
                    WHERE e.nrp IS NULL AND s.major='$jurusanMhs'");


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

            <a href="./" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-10 gap-2 transition duration-200">
                <i class='bx bxs-briefcase bx-sm'></i>
                <p class="text-md font-semibold">Dashboard</p>
            </a>
            <a href="./enroll.php" class="flex justify-start items-center text-[#283c2e] mt-4 gap-2 bg-[#ebfbee] p-4 mx-4 rounded-lg transition duration-200">
                <i class='bx bxs-log-in-circle bx-sm'></i>
                <p class="text-md font-semibold">Enroll</p>
            </a>
            <a href="./profile.php" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 transition duration-200">
                <i class='bx bxs-user bx-sm'></i>
                <p class="text-md font-semibold">Profile</p>
            </a>
            <div class="border border-gray-500 flex-grow mt-[230px]">

            </div>
            <a href="../controller/logout.php" class="flex justify-start items-center text-[#b7bcb8] mt-2 mb-8 gap-2 hover:bg-red-200 hover:text-red-700 p-4 mx-4 rounded-lg transition duration-200">
                <i class='bx bxs-log-out bx-sm'></i>
                <p class="text-md font-semibold pb-[4px]">Logout</p>
            </a>

        </div>
        <div class="w-full ml-[20%] bg-slate-50 h-screen">
            <div class="mt-4 mx-8 flex justify-between">
                <div>
                    <p class="font-bold text-3xl">Enroll</p>
                </div>
            </div>
            <div class="gap-4 my-4 mx-8 grid grid-cols-4 ">

                <?php foreach ($subjects as $subject) : ?>
                    <div class="bg-[#31553b] flex flex-col justify-between rounded-lg shadow-lg p-4 text-white">
                        <div>
                            <p class="font-bold text-xl mb-1"><?= $subject["subject_name"] ?></p>
                            <p class=""><?= $subject["nama"] ?></p>
                        </div>
                        <button data-modal-target="popup-modal-<?= $subject["subject_id"] ?>" data-modal-toggle="popup-modal-<?= $subject["subject_id"] ?>" class="block bg-white hover:bg-[#161c18] hover:text-white focus:ring focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm text-black w-full mt-6 p-2 text-center transition duration-200" type="button">
                            Enroll
                        </button>
                    </div>


                    <!-- Modal Enroll -->
                    <div id="popup-modal-<?= $subject["subject_id"] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow ">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="popup-modal-<?= $subject["subject_id"] ?>">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-6 text-center">
                                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 ">Apakah anda yakin enroll <?= $subject["subject_name"] ?></h3>
                                    <a href="../controller/enroll.php?subject_id=<?= $subject['subject_id'] ?>">
                                        <button data-modal-hide="popup-modal" type="button" class="text-white bg-green-600 hover:bg-green-800 focus:ring focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 transition duration-200">
                                            Ya, Saya yakin
                                        </button>
                                    </a>
                                    <button data-modal-hide="popup-modal-<?= $subject["subject_id"] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition duration-200">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>