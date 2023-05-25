<?php
session_start();
include("../functions.php");

if (!isset($_SESSION["login"])) {
    header("Location: ../form/login.php");
    exit;
}

if ($_SESSION["role"] == "mahasiswa") {
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
$user = query("SELECT * FROM USER WHERE email='$email'");
$lecturer = query("SELECT * FROM LECTURER 
                    JOIN USER ON lecturer.email=user.email 
                    WHERE lecturer.email = '$email'")[0];
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
    <title>Lecturer Profile Page</title>
</head>

<body>

    <div class="flex">
        <div class="w-1/5 bg-[#161c18] h-screen fixed left-0 top-0">
            <div class="flex justify-center text-center items-center rounded-lg m-4 px-8 pt-4 pb-2 gap-x-4">
                <i class='bx bxs-graduation bx-lg text-white pb-1'></i>
                <h1 class="text-xl text-white text-center font-semibold pb-3">Learnology</h1>
            </div>
            <a href="./" class="flex justify-start items-center text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-10 gap-2 transition duration-300">
                <i class='bx bxs-briefcase bx-sm'></i>
                <p class="text-md font-semibold">Dashboard</p>
            </a>
            <a href="./daftar_matkul.php" class="flex justify-start items-center fill-current text-[#b7bcb8] hover:text-[#283c2e] hover:bg-[#ebfbee] p-4 mx-4 rounded-lg mt-4 gap-2 transition duration-300">
                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-google-classroom" viewBox="0 0 24 24">
                    <path d="M23,2H1A1,1 0 0,0 0,3V21A1,1 0 0,0 1,22H23A1,1 0 0,0 24,21V3A1,1 0 0,0 23,2M22,20H20V19H15V20H2V4H22V20M10.29,9.71A1.71,1.71 0 0,1 12,8C12.95,8 13.71,8.77 13.71,9.71C13.71,10.66 12.95,11.43 12,11.43C11.05,11.43 10.29,10.66 10.29,9.71M5.71,11.29C5.71,10.58 6.29,10 7,10A1.29,1.29 0 0,1 8.29,11.29C8.29,12 7.71,12.57 7,12.57C6.29,12.57 5.71,12 5.71,11.29M15.71,11.29A1.29,1.29 0 0,1 17,10A1.29,1.29 0 0,1 18.29,11.29C18.29,12 17.71,12.57 17,12.57C16.29,12.57 15.71,12 15.71,11.29M20,15.14V16H16L14,16H10L8,16H4V15.14C4,14.2 5.55,13.43 7,13.43C7.55,13.43 8.11,13.54 8.6,13.73C9.35,13.04 10.7,12.57 12,12.57C13.3,12.57 14.65,13.04 15.4,13.73C15.89,13.54 16.45,13.43 17,13.43C18.45,13.43 20,14.2 20,15.14Z" />
                </svg>
                <p class="text-md font-semibold">Daftar Mata Kuliah</p>
            </a>
            <div class="flex justify-start items-center text-[#283c2e] mt-4 gap-2 bg-[#ebfbee] p-4 mx-4 rounded-lg">
                <i class='bx bxs-user bx-sm'></i>
                <p class="text-md font-semibold">Profile</p>
            </div>
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
                    <p class="font-bold text-3xl">My profile</p>
                </div>
            </div>
            <div class="flex justify-between mt-8 border mx-4 rounded rounded-lg p-4 bg-white">
                <div class="flex justify-center items-center">
                    <img class="w-12 rounded-full" src="../image/<?= $lecturer['gambar']?>" alt="">
                    <div class="ml-4">
                        <p class="font-bold text-md"><?= $_SESSION["username"] ?></p>
                        <p class="text-slate-500"><?= $lecturer["nip"] ?></p>
                    </div>
                </div>
                <div class="">
                    <button data-modal-target="popup-modal-edit-<?php echo $lecturer['nip'] ?>" data-modal-toggle="popup-modal-edit-<?php echo $lecturer['nip'] ?>" type="button" class="flex justify-center items-center border border-slate-100 shadow shadow-lg hover:text-white text-slate-700 bg-white hover:bg-green-800 focus:outline-none focus:ring-1 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 transition duration-300">
                        <p>Edit</p>
                        <i class='bx bx-edit-alt ml-1'></i>
                    </button>

                </div>
            </div>
            <div class="bg-white border mt-4 rounded-lg px-4 mx-4">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-xl ">Personal Information</p>
                    <button data-modal-target="popup-modal-edit-<?php echo $lecturer['nip'] ?>" data-modal-toggle="popup-modal-edit-<?php echo $lecturer['nip'] ?>" type="button" class="flex justify-center items-center border border-slate-100 shadow shadow-lg hover:text-white text-slate-700 bg-white hover:bg-green-800 focus:outline-none focus:ring-1 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 mt-4 transition duration-300">
                        <p>Edit</p>
                        <i class='bx bx-edit-alt ml-1'></i>
                    </button>
                </div>
                <div class="flex gap-[26rem] ">
                    <div>
                        <p class="font-medium text-slate-500">Nama</p>
                        <p class="font-medium"><?= $lecturer["nama"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">NIP</p>
                        <p class="font-medium"><?= $lecturer["nip"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">Alamat</p>
                        <p class="font-medium"><?= $lecturer["alamat"] ?></p>
                    </div>
                    <div class="ml-">
                        <p class="font-medium text-slate-500">Username</p>
                        <p class="font-medium"><?= $lecturer["username"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">Email</p>
                        <p class="font-medium"><?= $lecturer["email"] ?></p>
                        <p class="font-medium text-slate-500 mt-4">No HP</p>
                        <p class="font-medium"><?= $lecturer["no_hp"] ?></p>
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
        <div id="popup-modal-edit-<?php echo $lecturer['nip'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="authentication-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 ">Edit Profile</h3>
                        <form class="space-y-4" action="../controller/edit_lecturer_profile.php" method="POST">
                            <div class="relative">
                                <input type="text" id="nip" name="nip" class="block hidden px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $lecturer["nip"] ?>"  />
                                <label for="nip" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">NIP</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="nip" name="nip" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $lecturer["nip"] ?>" disabled />
                                <label for="nip" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">NIP</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="nama" name="nama" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $lecturer["nama"] ?>" disabled />
                                <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="alamat" name="alamat" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $lecturer["alamat"] ?>" required />
                                <label for="alamat" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Alamat</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="no_hp" name="no_hp" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " value="<?= $lecturer["no_hp"] ?>" required />
                                <label for="no_hp" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">No HP</label>
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