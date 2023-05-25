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

$email = $_SESSION["email"];
$students = query("SELECT * FROM MAHASISWA");
$users = query("SELECT * FROM USER");
$subjects = query("SELECT * FROM SUBJECT 
                    JOIN LECTURER ON subject.nip=lecturer.nip
                    JOIN USER ON lecturer.email=user.email
                    WHERE user.email='$email'");

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
            <a href="./index.php" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] mt-10 gap-2  p-4 mx-4 rounded-lg transition duration-300">
                <i class='bx bxs-briefcase bx-sm'></i>
                <p class="text-md font-semibold">Dashboard</p>
            </a>
            <a href="./daftar_matkul.php" class="flex justify-start items-center fill-current text-[#283c2e] bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 ">
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
                    <p class="font-bold text-3xl">Daftar Mata Kuliah</p>
                </div>
                <div class="flex">
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="flex items-center text-gray-900 bg-white border border-gray-100 focus:outline-none hover:bg-green-700 hover:text-white focus:bg-green-700 focus:text-white focus:ring-1 focus:ring-gray-200 font-medium rounded-lg text-sm px-5  h-10  mb-2 ml-4 shadow-lg transition duration-300" type="button">
                        <i class='bx bx-plus'></i>
                        <p>Tambah Matkul</p>
                    </button>
                </div>
            </div>
            <div class="gap-4 my-4 mx-8 grid grid-cols-3">
                <?php
                // Query untuk mendapatkan semua data subjek dari tabel subject
                include("../connect.php");
                $query = "SELECT * FROM SUBJECT 
                JOIN LECTURER ON subject.nip=lecturer.nip
                JOIN USER ON lecturer.email=user.email
                WHERE user.email='$email'";
                $result = mysqli_query($db, $query);
                $subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                <?php foreach ($subjects as $subject) : ?>
                    <?php
                    // Menghitung jumlah mahasiswa pada subject_id tertentu di tabel Score
                    include("../connect.php");
                    $subjectId = $subject['subject_id'];
                    $query = "SELECT COUNT(DISTINCT nrp) AS total_mahasiswa FROM Score WHERE subject_id = '$subjectId'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_assoc($result);
                    $totalMahasiswa = $row['total_mahasiswa'];
                    ?>

                    <a href="./subject.php?subject_id=<?= $subject['subject_id'] ?>" class="group flex flex-col justify-between p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-[#31553b] hover:text-slate-200 transition duration-200">
                        <div class="flex justify-between ">
                            <div class="pr-2">
                                <p class="font-bold text-lg"><?= $subject["subject_name"] ?></p>
                                <p class="font-light text-sm"><?= $subject["major"] ?></p>
                            </div>
                            <div class="flex">
                                <button onclick="return false;" data-modal-target="popup-modal-edit-<?php echo $subject['subject_id'] ?>" data-modal-toggle="popup-modal-edit-<?php echo $subject['subject_id'] ?>" type="button" class="group/edit flex justify-center items-center mx-1 bg-white shadow-lg rounded-lg h-8 w-8 text-grey-900 hover:bg-green-600 hover:text-green-800 group-hover:text-[#31553b] transition duration-200">
                                    <i class='bx bxs-edit-alt text-lg group-hover/edit:text-white'></i>
                                </button>
                                <button onclick="return false;" data-modal-target="popup-modal-delete-<?php echo $subject['subject_id'] ?>" data-modal-toggle="popup-modal-delete-<?php echo $subject['subject_id'] ?>" type="button" class="group/delete flex justify-center items-center ml-1 bg-white shadow-lg rounded-lg h-8 w-8 text-grey-900 hover:bg-red-600 group-hover:text-[#31553b] duration-200">
                                    <i class='bx bxs-trash text-lg group-hover/delete:text-white'></i>
                                </button>
                            </div>
                        </div>
                        <div class="bg-[#31553b] w-32 h-8 text-white py-1 px-3 mt-2 rounded-lg group-hover:bg-white group-hover:text-[#31553b] transition duration-200">
                            <p class="text-sm flex justify-between"><i class='bx bxs-user pt-1'></i><?= $totalMahasiswa ?> Orang</p>
                        </div>
                    </a>
                    <!-- Modal Delete -->
                    <div id="popup-modal-delete-<?php echo $subject['subject_id'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="popup-modal-delete-<?php echo $subject['subject_id'] ?>">
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
                                    <a href="../controller/hapus_matkul.php?subject_id=<?= $subject["subject_id"] ?>">
                                        <button data-modal-hide="popup-modal-delete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 transition duration-300">
                                            Ya, saya yakin.
                                        </button>
                                    </a>
                                    <button data-modal-hide="popup-modal-delete-<?php echo $subject['subject_id'] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition duration-300">Tidak, batalkan.</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div id="popup-modal-edit-<?php echo $subject['subject_id'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="authentication-modal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="px-6 py-6 lg:px-8">
                                    <h3 class="mb-4 text-xl font-medium text-gray-900 ">Edit Mata Kuliah</h3>
                                    <form class="space-y-4" action="../controller/edit_matkul.php" method="POST">

                                        <input class="absolute hidden" type="text" name="subject_id" id="subject_id" value="<?= $subject["subject_id"] ?>">
                                        <div class="relative">
                                            <input type="text" id="subject_name" name="subject_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $subject["subject_name"] ?>" required />
                                            <label for="subject_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama Mata Kuliah</label>
                                        </div>
                                        <div>
                                            <label for="major" class="block mb-2 text-sm font-medium text-gray-900"></label>
                                            <select id="major" name="major" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                                                <option selected>Pilih Jurusan</option>
                                                <option <?= $subject["major"] == "Teknik Informatika" ? "selected" : "" ?>>Teknik Informatika</option>
                                                <option <?= $subject["major"] == "Sains Data Terapan" ? "selected" : "" ?>>Sains Data Terapan</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="edit_matkul" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-1 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-300">Edit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
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
                            <label for="major" class="block mb-2 text-sm font-medium text-gray-900"></label>
                            <select id="major" name="major" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                                <option value="" selected>Pilih Jurusan</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sains Data Terapan">Sains Data Terapan</option>
                            </select>
                        </div>
                        <button type="submit" name="tambah_subject" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-1 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>