<?php
session_start();
include("../functions.php");

if (!isset($_SESSION["login"])) {
    header("Location: ../form/login.php");
    exit;
}
if (isset($_SESSION["role"]) == "guest") {
    header("Location: ../guest_page.php");
    exit;
} else if (isset($_SESSION["role"]) == "dosen") {
    header("Location: ../dosen_page.php");
    exit;
} else if (isset($_SESSION["role"]) == "mahasiswa") {
    header("Location: ../mahasiswa_page.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <title>Tambah Data</title>
</head>

<body class="">
    <div class="flex justify-center items-center">
        <div class="w-1/2 my-14">
            <p class="mt-4  mb-6 text-center text-3xl font-bold">Tambah Data Mahasiswa</p>

            <form class="" action="../controller/tambah.php" method="POST" enctype="multipart/form-data">
                <div class="grid gap-6 md:grid-cols-2 mb-4 mt-4">
                    <div class="relative">
                        <input type="text" id="nrp" name="nrp" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " required />
                        <label for="nrp" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">NRP</label>
                    </div>
                    <div class="relative">
                        <input type="text" id="nama" name="nama" pattern="[A-Za-z ]+" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " required />
                        <label for="nama" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama</label>
                    </div>
                </div>

                <div class="grid w-full gap-2 my-2">
                    <div class="flex gap-x-6">
                        <label class="w-2/5 flex justify-center items-center font-medium text-md text-grey-900" for="jenis_kelamin">Jenis Kelamin</label>

                        <div class="w-full">
                            <input type="radio" id="laki_laki" name="jenis_kelamin" value="laki-laki" class="hidden peer" required>
                            <label for="laki_laki" class="inline-flex items-center justify-between w-full p-2  text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-green-600 peer-checked:text-green-600 hover:text-gray-600 hover:bg-gray-100">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="w-full">
                            <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" class="hidden peer">
                            <label for="perempuan" class="inline-flex items-center justify-between w-full p-2.5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-green-600 peer-checked:text-green-600 hover:text-gray-600 hover:bg-gray-100">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>

                <div class="my-4">

                    <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-900"></label>
                    <select id="countries" name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                        <option selected>Pilih Jurusan</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sains Data Terapan">Sains Data Terapan</option>
                    </select>
                </div>

                <div class="my-4">
                    <div class="relative">
                        <input type="email" name="email" id="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " required />
                        <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                    </div>
                </div>

                <div class="mt-2 mb-4 ">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="gambar">Foto Profile</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none" id="file_input" type="file" name="gambar">
                    <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG, atau JPEG (MAX. 3 MB).</p>
                </div>


                <button type="submit" name="tambah" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Submit</button>
                <a href="../index.php" class="ml-4 text-slate-400 hover:text-red-600 hover:underline">Kembali</a>
            </form>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>