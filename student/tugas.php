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

if (!isset($_GET["subject_id"])) {
    header("Location: ../admin.php");
} else {
    $subject_id = $_GET["subject_id"];
    $email = $_SESSION["email"];
    $logged = query("SELECT *, user.nama AS user_name FROM user 
                JOIN mahasiswa ON mahasiswa.email = user.email
                WHERE user.email='$email'")[0];
    $nrp = $logged["nrp"];
    $subject = query("SELECT * FROM subject WHERE subject_id = $subject_id")[0];
    $assignments = query("SELECT a.* FROM assignment a
                            JOIN subject s ON a.subject_id = s.subject_id
                            JOIN enrollment e ON s.subject_id = e.subject_id
                            WHERE e.nrp = '$nrp' AND a.subject_id = '$subject_id'");
    if (empty($assignments)) {
        $message = "Belum ada tugas yang aktif!";
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

<body class="bg-slate-50">
    <nav class="bg-[#161c18] border-gray-200 fixed w-full top-0">
        <div class=" flex justify-between items-center  mx-auto p-4">
            <div class="flex">
                <a href="./index.php" class="flex items-center ">
                    <i class='bx bx-left-arrow-circle bx-md text-[#ebfbee] hover:text-[#91b397] transition duration-200'></i>
                </a>
                <p class="text-[#ebfbee] text-2xl font-bold ml-4">
                    <?= $subject['subject_name'] ?>
                </p>
            </div>
        </div>
    </nav>
    <?php if (!empty($message)) : ?>
        <div class="text-center mt-8">
            <p class="font-bold text-lg mt-28"><?= $message ?></p>
        </div>
    <?php else : ?>
        <div class="grid grid-cols-3  gap-x-2 gap-y-6 mb-4 mx-4 mt-[6%]">
            <?php foreach ($assignments as $assignment) : ?>
                <?php
                include("../connect.php");
                $assignmentId = $assignment["assignment_id"];
                $submit = query("SELECT file FROM SCORE s
                            JOIN assignment a ON s.assignment_id = a.assignment_id
                            WHERE a.assignment_id = '$assignmentId'");
                $nilai = query("SELECT grade FROM SCORE
                            WHERE assignment_id = '$assignmentId'");
                ?>
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="bg-slate-300 rounded-t-lg">
                        <p class="font-bold text-xl p-4"><?= $assignment['assignment_name'] ?></p>
                    </div>
                    <div class="flex flex-col justify-between h-full pb-16 px-2">
                        <p class="pt-2 px-2"><?= $assignment['assignment_desc'] ?></p>
                        <div>
                            <div>
                                <?php if (empty($nilai)) : ?>
                                    <p><span class="font-bold">Nilai: </span>-</p>
                                <?php else : ?>
                                    <p><span class="font-bold">Nilai: </span><?= $nilai[0]['grade'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="flex justify-between items-start mb-2">
                                <?php if ($submit != null) : ?>
                                    <div class="flex justify-between items-center p-2 mt-2 border border-green-500 border-2 rounded-lg text-green-500">
                                        <i class='bx bx-check mt-0.5 mr-2'></i>
                                        <p class="text-sm">Sudah Mengumpulkan</p>
                                    </div>
                                <?php else : ?>
                                    <div class="flex justify-between items-center p-2 mt-2 border border-red-500 border-2 rounded-lg text-red-500">
                                        <i class='bx bxs-x-circle mt-0.5 mr-2'></i>
                                        <p class="text-sm">Belum Mengumpulkan</p>
                                    </div>

                                <?php endif ?>

                                <button data-modal-target="modal-<?= $assignment['assignment_id'] ?>" data-modal-toggle="modal-<?= $assignment['assignment_id'] ?>" type="button" class="flex justify-between items-center p-2 mt-2 border border-blue-500 text-blue-500 border-2 hover:bg-blue-500 hover:text-white rounded-lg transition duration-200">
                                    <i class='bx bx-right-arrow-alt mt-0.5 mr-1'></i>
                                    <p class="text-sm">Submit Tugas</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main modal -->
                <div id="modal-<?= $assignment['assignment_id'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center transition duration-200" data-modal-hide="modal-<?= $assignment['assignment_id'] ?>">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="px-6 py-6 lg:px-8">
                                <h3 class="mb-4 text-xl font-medium text-gray-900 ">Submit <?= $assignment["assignment_name"] ?></h3>
                                <form class="space-y-6" action="../controller/submit_tugas.php" method="POST" enctype="multipart/form-data">
                                    <input class="hidden" type="text" id="subject_id" name="subject_id" value="<?= $subject_id ?>">
                                    <input class="hidden" type="text" id="nrp" name="nrp" value="<?= $nrp ?>">
                                    <input class="hidden" type="text" id="assignment_id" name="assignment_id" value="<?= $assignment['assignment_id'] ?>">

                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-900 " for="file_input">Upload file</label>
                                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="file_input_help" id="file_input" type="file" name="file">
                                        <p class="mt-1 text-sm text-gray-500 " id="file_input_help">PDF, DOC, DOCX, or PPTX</p>
                                    </div>

                                    <button type="submit" name="submit_tugas" class="w-full hover:text-white hover:bg-blue-700 bg-white text-blue-800 border border-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-200">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>