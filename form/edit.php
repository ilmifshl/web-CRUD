<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Data</title>
</head>

<body>
    <div class="flex justify-center">
        <div class="w-1/2 my-24">
            <p class="mt-4 text-center text-3xl font-bold">Tambah Data Mahasiswa</p>

            <form class="">
                <div class="grid gap-6 md:grid-cols-2 mb-4 mt-4">
                    <div>
                        <label for="nrp" class="block mb-2 text-sm font-medium text-gray-900 ">NRP</label>
                        <input type="number" id="nrp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 " placeholder="NRP" required>
                    </div>
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                        <input type="text" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 " pattern="[A-Za-z ]+" placeholder="Nama" required>
                    </div>
                </div>

                <div class="grid w-full gap-2 my-2">
                    <div class="flex gap-x-6">
                        <label class="w-2/5 flex justify-center items-center" for="jenis_kelamin">Jenis Kelamin</label>

                        <div class="w-full">
                            <input type="radio" id="laki_laki" name="jenis_kelamin" value="laki_laki" class="hidden peer" required>
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

                <div class="my-2">

                    <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-900">Pilih Jurusan</label>
                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>Pilih Jurusan</option>
                        <option value="teknik_informatika">Teknik Informatika</option>
                        <option value="sains_data_terapan">Sains Data Terapan</option>
                    </select>
                </div>

                <div class="mt-2 mb-4">
                <label for="nrp" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                        <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 " placeholder="Email" required>
                </div>

                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Submit</button>
            </form>

        </div>
    </div>
</body>

</html>