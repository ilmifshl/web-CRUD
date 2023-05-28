<?php
session_start();
include("../functions.php");

if (!isset($_SESSION["login"])) {
    header("Location: ../form/login.php");
    exit;
}

if ($_SESSION["role"] == "dosen") {
    header("Location: ../student");
    exit;
} else if ($_SESSION["role"] == "guest") {
    header("Location: ../guest_page.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
    header("Location: ../index.php");
    exit;
}

$email = $_SESSION["email"];
$student = query("SELECT * FROM MAHASISWA 
                JOIN USER ON mahasiswa.email = user.email
                WHERE mahasiswa.email = '$email'")[0];
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
    <title>student Profile Page</title>
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
            
            <a href="./enroll.php" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 transition duration-200">
                <i class='bx bxs-log-in-circle bx-sm'></i>
                <p class="text-md font-semibold">Enroll</p>
            </a>
            <a href="./profile.php" class="flex justify-start items-center text-[#283c2e] mt-4 gap-2 bg-[#ebfbee] p-4 mx-4 rounded-lg transition duration-200">
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
                    <p class="font-bold text-3xl">My profile</p>
                </div>
            </div>
            <div class="flex justify-between mt-8 border mx-4 rounded rounded-lg p-4 bg-white">
                <div class="flex justify-center items-center">
                    <img class="w-12 rounded-full" src="../image/<?= $student['gambar']?>" alt="">
                    <div class="ml-4">
                        <p class="font-bold text-md"><?= $_SESSION["username"] ?></p>
                        <p class="text-slate-500"><?= $student["nrp"] ?></p>
                    </div>
                </div>
                <div class="">
                    

                </div>
            </div>
            <div class="bg-white border mt-4 rounded-lg px-4 mx-4">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-xl ">Personal Information</p>
                    
                </div>
                <div class="flex gap-[26rem] ">
                    <div>
                        <p class="font-medium text-slate-500">Nama</p>
                        <p class="font-medium"><?= $student["nama"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">NRP</p>
                        <p class="font-medium"><?= $student["nrp"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">jurusan</p>
                        <p class="font-medium"><?= $student["jurusan"] ?></p>
                    </div>
                    <div class="ml-">
                        <p class="font-medium text-slate-500">Username</p>
                        <p class="font-medium"><?= $student["username"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">Email</p>
                        <p class="font-medium"><?= $student["email"] ?></p>
                    </div>
                </div>
                <div class="flex gap-[26rem] mt-4">
                    <div>

                    </div>
                    <div </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="popup-modal-edit-<?php echo $student['nrp'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="popup-modal-edit-<?php echo $student['nrp'] ?>">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 ">Edit Profile</h3>
                        <form class="space-y-4" action="../controller/edit_student_profile.php" method="POST">
                            <div class="relative">
                                <input type="text" id="nrp" name="nrp" class="block hidden px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $student["nrp"] ?>"  />
                                <label for="nrp" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">nrp</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="nrp" name="nrp" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $student["nrp"] ?>" disabled />
                                <label for="nrp" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">nrp</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="nama" name="nama" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $student["nama"] ?>" disabled />
                                <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="jurusan" name="jurusan" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $student["jurusan"] ?>" required />
                                <label for="jurusan" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">jurusan</label>
                            </div>
                            
                            <button type="submit" name="edit_matkul" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-1 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>