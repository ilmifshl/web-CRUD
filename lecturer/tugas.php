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


if (!isset($_GET["assignment_id"])) {
    header("Location: ../index.php");
} else {
    $assignment_id = $_GET["assignment_id"];
    $tugas = query("SELECT * FROM assignment WHERE assignment_id = '$assignment_id'")[0];
    $scores = query("SELECT * FROM score s
                    JOIN mahasiswa m ON s.nrp = m.nrp
                    WHERE s.assignment_id = '$assignment_id'");
    if (empty($scores)) {
        $message = "Belum ada mahasiswa yang mengumpulkan tugas";
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
    <title>Score Page</title>
</head>

<body>
    <nav class="bg-[#161c18] border-gray-200 ">
        <div class=" flex justify-between items-center  mx-auto p-4">
            <div class="flex">
                <a href="./subject.php?subject_id=<?= $tugas['subject_id'] ?>" class="flex items-center ">
                    <i class='bx bx-left-arrow-circle bx-md text-[#ebfbee] hover:text-[#91b397]'></i>
                </a>
                <p class="text-[#ebfbee] text-2xl font-bold ml-4">
                    <?= $tugas['assignment_name'] ?>
                </p>
            </div>
        </div>
    </nav>
    <div class="relative overflow-x-auto shadow-md border mt-4 mx-4 rounded-lg">
        <table class="w-full text-sm text-left  text-gray-500 rounded-lg">
            <thead class="text-sm text-gray-700 uppercase bg-gray-50 ">

                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NRP
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Kelamin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tugas
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nilai Tugas
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($message)) : ?>
                    <tr class="text-center mt-8">
                        <td class="font-semibold text-lg mt-2" colspan="6"><?= $message ?></td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($scores as $score) : ?>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 inline-flex items-center gap-x-3">
                                <img src="../image/<?= $score["gambar"] ?>" alt="" class="w-10 rounded-full">
                                <p><?= $score["nama"] ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <?= $score["nrp"] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $score["jenis_kelamin"] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $score["file"] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $score["grade"] ?>
                            </td>
                            <td class="flex justify-start px-6 py-4">
                                <a href="../controller/download_tugas.php?file=<?= $score['file'] ?>" class="px-2 py-1.5 bg-white text-green-800 hover:bg-green-800 hover:text-white shadow-lg rounded trasnsition duration-200 ml-2">
                                    <i class='bx bxs-download bx-sm'></i>
                                </a>
                                <button data-modal-target="popup-modal-edit-<?php echo $score['nrp'] ?>" data-modal-toggle="popup-modal-edit-<?php echo $score['nrp'] ?>" type="button" class="px-2 py-1.5 bg-white text-green-800 hover:bg-green-800 hover:text-white shadow-lg rounded trasnsition duration-200 ml-2">
                                    <i class='bx bxs-edit-alt bx-sm'></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal Edit -->
                        <div id="popup-modal-edit-<?php echo $score['nrp'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="authentication-modal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="px-6 py-6 lg:px-8">
                                        <h3 class="mb-4 text-xl font-medium text-gray-900 ">Edit Nilai</h3>
                                        <form class="space-y-4" action="../controller/edit_nilai.php?nrp=<?= $score['nrp'] ?>" method="POST">

                                            <input class="absolute hidden" type="text" name="assignment_id" id="assignment_id" value="<?= $score["assignment_id"] ?>">
                                            <div class="relative">
                                                <input type="text" id="grade" name="grade" class="block mt-4 px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $score["grade"] ?>" required />
                                                <label for="grade" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nilai grade</label>
                                            </div>
                                            <button type="submit" name="edit_nilai" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-1 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm mt-2 px-5 py-2.5 text-center">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
            </tbody>
        <?php endif; ?>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>