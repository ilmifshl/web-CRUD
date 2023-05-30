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
    header("Location: ../admin.php");
    exit;
}

if (!isset($_GET["subject_id"])) {
    header("Location: ../index.php");
} else {
    $subject_id = $_GET["subject_id"];
    $subject = query("SELECT * FROM subject WHERE subject_id = $subject_id")[0];
    $assignments = query("SELECT a.*, COUNT(s.nrp) AS submission_count FROM assignment a
                        LEFT JOIN score s ON s.assignment_id = a.assignment_id
                        WHERE a.subject_id = $subject_id
                        GROUP BY a.assignment_id");

    if (empty($assignments)) {
        $message = "Tidak ada tugas yang aktif </br> Harap tambah tugas terlebih dahulu!";
    }
}
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
    <title>Lecturer Subject Page</title>
</head>

<body class="bg-slate-50">
    <nav class="bg-[#161c18] border-gray-200 ">
        <div class=" flex justify-between items-center  mx-auto p-4">
            <div class="flex">
                <a href="./daftar_matkul.php" class="flex items-center ">
                    <i class='bx bx-left-arrow-circle bx-md text-[#ebfbee] hover:text-[#91b397]'></i>
                </a>
                <p class="text-[#ebfbee] text-2xl font-bold ml-4">
                    <?= $subject["subject_name"] ?>
                </p>
            </div>
            <div>
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-[#31553b] bg-white hover:bg-[#31553b] hover:text-white focus:ring focus:outline-none focus:ring-[#31553b] font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-300" type="button">
                    Tambah Tugas
                </button>
            </div>
        </div>
    </nav>
    
    <?php if (!empty($message)) : ?>
        <div class="flex justify-center items-center text-center mt-8">
            <p class="font-bold text-2xl"><?= $message ?></p>
        </div>
    <?php else : ?>
        <div class="grid grid-cols-4 gap-4 mt-4 mx-6">
            <?php foreach ($assignments as $assignment) : ?>
                <a href="./tugas.php?assignment_id=<?= $assignment['assignment_id'] ?>" class="group flex flex-col justify-between bg-white shadow-lg p-4 rounded-lg hover:text-white hover:bg-[#31552b] transition duration-200">
                    <div>
                        <p class="font-bold text-xl mb-1"><?= $assignment["assignment_name"] ?></p>
                        <div class="border  w-full"></div>
                        <p class="mt-1"><?= $assignment["assignment_desc"] ?></p>
                    </div>
                    <div class="bg-[#31553b] text-white py-2 px-4 mt-4   rounded-lg group-hover:bg-white group-hover:text-[#31553b]">
                        <p><?= $assignment["submission_count"] ?> Terkumpul</p>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    <?php endif; ?>


    <!-- Modal Tambah Tugas -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="authentication-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-5 text-xl font-medium text-gray-900 ">Tambah Tugas</h3>
                    <form class="space-y-3" action="../controller/tambah_tugas.php" method="POST">
                        <div class="relative hidden">
                            <input type="text" id="subject_id" name="subject_id" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $subject['subject_id'] ?>" />
                            <label for="subject_id" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama Tugas</label>
                        </div>
                        <div class="relative">
                            <input type="text" id="nama" name="nama" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " />
                            <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama Tugas</label>
                        </div>

                        <div>
                            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 ">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 " placeholder="Tambah deskripsi tugas"></textarea>
                        </div>

                        <button type="submit" name="tambah_tugas" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>