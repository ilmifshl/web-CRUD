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
    header("Location: ../admin.php");
    exit;
}

$email = $_SESSION["email"];
$logged = query("SELECT *, user.nama AS user_name FROM user 
                JOIN mahasiswa ON mahasiswa.email = user.email
                WHERE user.email='$email'")[0];
$nrp = $logged["nrp"];

$enrolls = query("SELECT *, u.nama AS nama_dosen FROM ENROLLMENT e
                    JOIN SUBJECT s ON e.subject_id = s.subject_id
                    JOIN LECTURER l ON s.nip = l.nip
                    JOIN USER u ON l.email = u.email
                    JOIN MAHASISWA m ON e.nrp = m.nrp
                      WHERE e.nrp = '$nrp'");

if (empty($enrolls)) {
    $message = "Anda belum terdaftar ke kelas apapun!";
}

$students = query("SELECT * FROM mahasiswa");
$users = query("SELECT * FROM user");
$subjects = query("SELECT * FROM subject");


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
            <a href="../controller/logout.php" class="flex justify-start items-center text-[#b7bcb8] mt-2 mb-8 gap-2 hover:bg-red-200 hover:text-red-700 p-4 mx-4 rounded-lg transition duration-200">
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
                            <img src="../image/<?= $logged['gambar'] ?>" alt="" class="rounded-full w-9 mr-3">
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

            <?php if (!empty($message)) : ?>
                <div class="text-center mt-8">
                    <p class="font-bold text-lg mt-2"><?= $message ?></p>
                </div>
            <?php else : ?>
                <div class="grid grid-cols-3">

                    <?php foreach ($enrolls as $enroll) : ?>
                        <?php
                        // Menghitung jumlah tugas pada subject_id tertentu di tabel Assignment
                        include("../connect.php");
                        $tugasId = $enroll['subject_id'];
                        $query = "SELECT COUNT(DISTINCT assignment_id) AS total_tugas FROM ASSIGNMENT WHERE subject_id = '$tugasId'";
                        $result = mysqli_query($db, $query);
                        $row = mysqli_fetch_assoc($result);
                        $totalTugas = $row['total_tugas'];
                        ?>
                        <a href="./tugas.php?subject_id=<?= $enroll['subject_id'] ?>" class="group flex flex-col justify-between m-4 p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-[#31553b] hover:text-slate-200 transition duration-200">
                            <div class="flex justify-between ">
                                <div class="pr-2">
                                    <p class="font-bold text-lg"><?= $enroll["subject_name"] ?></p>
                                    <p class="font-light text-sm"><?= $enroll["nama_dosen"] ?></p>
                                </div>
                                <div class="flex">
                                    <button onclick="return false;" data-modal-target="popup-modal-delete-<?php echo $enroll['nrp'] ?>-<?php echo $enroll['subject_id'] ?>" data-modal-toggle="popup-modal-delete-<?php echo $enroll['nrp'] ?>-<?php echo $enroll['subject_id'] ?>" type="button" class="group/delete flex justify-center items-center ml-1 bg-white shadow-lg rounded-lg h-8 w-8 text-grey-900 hover:bg-red-600 group-hover:text-[#31553b] duration-200">
                                        <i class='bx bxs-trash text-lg group-hover/delete:text-white'></i>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-[#31553b] w-32 h-8 text-white py-1 px-3 mt-2 rounded-lg group-hover:bg-white group-hover:text-[#31553b] transition duration-200">
                                <p class="text-sm flex justify-between"><i class='bx bxs-book-alt pt-1'></i><?= $totalTugas ?> Tugas</p>
                            </div>
                        </a>
                        <!-- Modal Drop Matkul -->
                        <div id="popup-modal-delete-<?php echo $enroll['nrp'] ?>-<?php echo $enroll['subject_id'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center transition duration-200" data-modal-hide="popup-modal-delete-<?php echo $enroll['nrp'] ?>-<?php echo $enroll['subject_id'] ?>">
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
                                        <a href="../controller/drop_matkul.php?subject_id=<?= $enroll["subject_id"] ?>">
                                            <button data-modal-hide="popup-modal-delete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 transition duration-200">
                                                Ya, saya yakin.
                                            </button>
                                        </a>
                                        <button data-modal-hide="popup-modal-delete-<?php echo $enroll['nrp'] ?>-<?php echo $enroll['subject_id'] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition duration-200">Tidak, batalkan.</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>