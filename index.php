<?php
session_start();
include("functions.php");

if (!isset($_SESSION["login"])) {

  header("Location: ./form/login.php");
  exit;
}

if ($_SESSION["role"] == "mahasiswa") {
    header("Location: mahasiswa_page.php");
    exit;
} else if ($_SESSION["role"] == "guest") {
    header("Location: guest_page.php");
    exit;
} else if ($_SESSION["role"] == "dosen") {
    header("Location: dosen_page.php");
    exit;
} 

$students = query("SELECT * FROM MAHASISWA");
$users = query("SELECT * FROM USER");
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
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <div class="flex">
    <div class="h-screen w-1/5 border-r border-slate-300">
      <!-- Logo -->
      <div class="flex text-center items-center justify-center pt-6 pb-4 px-4 gap-x-2">
        <img class="h-14 w-14" src="./image/school.png" alt="">
        <h1 class="text-2xl text-slate-700 text-center font-semibold">Learnology</h1>
      </div>

      <!-- Menu -->
      <div class="">
        <div class="flex items-center pl-6 py-3 text-[#51DD90] w-full h-full border-[#51DD90] border-l-4">
          <i class='bx bx-file-blank text-xl'></i>
          <p class="px-2 font-semibold">Database</p>
        </div>
        <div class="flex items-center pl-6 py-3 text-slate-400 hover:text-[#51DD90] w-full h-full">
          <i class='bx bx-file-blank text-xl'></i>
          <p class="px-2 font-semibold ">Database</p>
        </div>
        <div class="flex items-center pl-6 py-3 text-slate-400 hover:text-[#51DD90] w-full h-full">
          <i class='bx bx-file-blank text-xl'></i>
          <p class="px-2 font-semibold ">Database</p>
        </div>
      </div>
    </div>

    <div class="w-full p-6">
      <div class="flex justify-between">
        <div class="relative">
          <input type="text" id="keyword" class="w-80 rounded border border-[#bfbfbf] bg-[#F5F5F5] h-full pl-8 py-2 focus:outline-none" placeholder="Cari data disini..." autocomplete="off">
          <button id="search-button" class="absolute inset-y-[20%] left-2 text-lg"><i class='bx bx-search'></i></button>
        </div>

        <div class="flex items-center gap-x-4 mr-4">
          <button id="dropdownDefaultButton" class="flex items-center" data-dropdown-toggle="dropdown">
            <img src="https://www.gravatar.com/avatar/2c7d99fe281ecd3bcd65ab915bac6dd5?s=250" alt="" class="rounded-full w-9 mr-3">
            <h2 class="font-semibold mr-5"><?= $_SESSION["username"] ?></h2>
            <i class='bx bxs-chevron-down rounded cursor-pointer text-[#4b5563] pt-1'></i>
          </button>
          <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-[0_5px_20px_rgba(92,99,105,0.3)] w-44" style="left: -32px !important">
            <ul class="py-2 text-sm" aria-labelledby="dropdownDefaultButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
              </li>
              <li>
                <a href="./controller/logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
              </li>
            </ul>
          </div>
        </div>

      </div>
      <div class="flex mt-10 mb-4 justify-between">
        <p class="font-bold text-2xl w-10/12">Database</p>
        <div class="flex gap-x-2">
          <a href="https://google.com" class="flex justify-center items-center text-slate-400 bg-slate-200 hover:text-slate-600 hover:bg-slate-400 px-3 py-1 gap-x-1 rounded-md">
            <p>Sort</p>
            <i class='bx bx-sort-down pt-1'></i>
          </a>
          <a href="./form/tambah.php" class="flex justify-center items-center bg-slate-200 text-slate-400 hover:text-slate-600 hover:bg-slate-400 px-3 py-1 gap-x-1 rounded-md">
            <p>Add</p>
            <i class='bx bx-plus pt-1'></i>
          </a>
        </div>
      </div>


      <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg aria-selected:text-[#51DD90] aria-selected:border-b-2 aria-selected:border-[#51DD90] hover:aria-selected:text-[#51DD90] hover:text-[#40b374]" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Mahasiswa</button>
          </li>
          <li class="mr-2" role="presentation">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 aria-selected:text-[#51DD90] aria-selected:border-b-2 aria-selected:border-[#51DD90] hover:aria-selected:text-[#51DD90] hover:text-[#40b374]" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">User</button>
          </li>

        </ul>
      </div>
      <div id="myTabContent">
        <!-- Tabel Mahasiswa -->
        <div class="hidden" id="profile" role="tabpanel" aria-labelledby="profile-tab">

          <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-gray-700 uppercase bg-white">
                <tr>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Nama
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    NRP
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Kelamin
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Jurusan
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Email
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm text-center">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                <?php foreach ($students as $student) : ?>
                  <tr class="bg-<?= $i % 2 == 1 ? 'white' : '[#F1F9F6]' ?>">
                    <td class="px-6 py-4 inline-flex items-center gap-x-3">
                      <img src="./image/<?= $student["gambar"] ?>" alt="" class="w-10 rounded-full">
                      <p><?= $student["nama"] ?></p>
                    </td>
                    <td class="px-6 py-4">
                      <?= $student["nrp"] ?>
                    </td>
                    <td class="px-6 py-4">
                      <?= $student["jenis_kelamin"] ?>
                    </td>
                    <td class="px-6 py-4">
                      <?= $student["jurusan"] ?>
                    </td>
                    <td class="px-6 py-4">
                      <?= $student["email"] ?>
                    </td>
                    <td class="px-6 py-4 flex justify-center gap-x-2">
                      <a href="" class="px-2 py-1.5 bg-[#20a85e] hover:bg-[#1a9653] rounded">
                        <i class='bx bxs-download text-white'></i>
                      </a>
                      <a href="./form/edit.php?nrp=<?= $student['nrp'] ?>" class="px-2 py-1.5 bg-[#20a85e] hover:bg-[#1a9653] rounded">
                        <i class='bx bxs-edit text-white'></i>
                      </a>
                      <button data-modal-target="popup-modal-delete-<?php echo $student['nrp'] ?>" data-modal-toggle="popup-modal-delete-<?php echo $student['nrp'] ?>" type="button" class="px-2 py-1.5 bg-[#dc2626] hover:bg-[#c22121] rounded"><i class='bx bxs-trash text-white'></i></button>
                    </td>
                  </tr>

                  <!-- Modal Delete -->
                  <div id="popup-modal-delete-<?php echo $student['nrp'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                      <div class="relative bg-white rounded-lg shadow">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="popup-modal-delete-<?php echo $student['nrp'] ?>">
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
                          <a href="controller/hapus.php?nrp=<?= $student["nrp"] ?>">
                            <button data-modal-hide="popup-modal-delete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                              Ya, saya yakin.
                            </button>
                          </a>
                          <button data-modal-hide="popup-modal-delete-<?php echo $student['nrp'] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Tidak, batalkan.</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php $i++; ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Tabel Admin -->
        <div class="hidden" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
          <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-gray-700 uppercase bg-white">
                <tr>
                  <th scope="col" class="px-6 py-4 text-sm">
                    No
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Nama
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Username
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Email
                  </th>
                  <th scope="col" class="px-6 py-4 text-sm">
                    Role
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php $j = 1; ?>
                <?php foreach ($users as $user) : ?>
                  <tr class="bg-<?= $j % 2 == 0 ? 'white' : '[#F1F9F6]' ?>">
                    <td class="px-6 py-4 inline-flex items-center gap-x-3">
                      <?= $j++ ?>
                    </td>
                    <td class="px-6 py-4">
                      <?= $user["nama"] ?>
                    </td>
                    <td class="px-6 py-4">
                      <?= $user["username"] ?>
                    </td>
                    <td class="px-6 py-4">
                      <?= $user["email"] ?>
                    </td>
                    <td class="px-6 py-4">
                      <form action="">
                        <label for="role" class="block text-sm font-medium text-gray-900"></label>
                        <select id="role" name="role" class="block w-full p-1  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 ">
                          <option <?= $user["role"] == "guest" ? "selected" : "" ?>>guest</option>
                          <option <?= $user["role"] == "mahasiswa" ? "selected" : "" ?>>Mahasiwa</option>
                          <option <?= $user["role"] == "dosen" ? "selected" : "" ?>>Dosen</option>
                        </select>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>