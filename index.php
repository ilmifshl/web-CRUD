<?php
include('connect.php');

// if (!isset($_GET["nrp"])) {
//   header("Location: index.php");
// }

if (isset($_GET['nrp'])) {
  $nrp = $_GET["nrp"];
  $sql = "SELECT * FROM STUDENT WHERE nrp = $nrp";
  $query = mysqli_query($db, $sql);
  $mahasiswa = mysqli_fetch_assoc($query);
  echo $mahasiswa;
  if (mysqli_num_rows($query) < 1) {
    die("Data tidak ditemukan...");
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body class="bg-[#C0C9BA]">
  <div class="bg-white m-4 rounded-md drop-shadow-md">
    <header class="flex justify-between items-center mb-2 ">
      <div class="">
        <div class="sm:w-screen md:w-auto">
          <h1 class="font-bold md:text-3xl md:mx-4 md:mt-4 sm:mx-auto sm:text-center md:text-left text-4xl whitespace-nowrap ">Daftar Mahasiswa</h1>
        </div>
        <div>
          <h3 class="font-normal md:text-md md:ml-4 sm:text-center md:text-left md:pt-0 md:text-gray-600">Daftar seluruh mahasiswa DTIK</h3>
        </div>
        <div class="pl-4 px-1">
          <a class="md:hidden inline-block bg-[#61764B] hover:bg-[#42542e] text-white px-4 py-2 rounded mr-8 show-modal-new" href="#">Tambah Data</a>
        </div>
      </div>
      <a class="sm:hidden md:inline-block md:bg-[#61764B] md:hover:bg-[#42542e] md:text-white md:px-4 md:py-2 md:rounded md:mr-8 show-modal-new " href="#">Tambah Data</a>
    </header>
    <div class="px-5 pb-2 ">
      <div class="sm:items-center overflow-auto sm:w-full sm:border ">
        <table class="border container table-auto">
          <thead class="table-auto">
            <tr>
              <th scope="col" class="py-2 border-r border">No</th>
              <th scope="col" class="py-2 border-r border">NRP</th>
              <th scope="col" class="py-2 border-r border">Nama</th>
              <th scope="col" class="py-2 border-r border">Jenis Kelamin</th>
              <th scope="col" class="py-2 border-r border">Jurusan</th>
              <th scope="col" class="py-2 border-r border">Email</th>
              <th scope="col" class="py-2 border-r border">Alamat</th>
              <th scope="col" class="py-2 border-r border">No HP</th>
              <th scope="col" class="py-2 border-r border">Status</th>
              <th scope="col" class="py-2 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            $sql = "SELECT * FROM mahasiswa";
            $query = mysqli_query($db, $sql);

            while ($mahasiswa = mysqli_fetch_array($query)) {
              echo "<tr>";

              echo "<th scope='row' class='whitespace-nowrap py-2 border-r border-b px-2'>" . $i . "</th>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['nrp'] . "</td>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['nama'] . "</td>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['jenis_kelamin'] . "</td>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['jurusan'] . "</td>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['email'] . "</td>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['alamat'] . "</td>";
              echo "<td class='whitespace-nowrap py-2 border-r border-b px-2'>" . $mahasiswa['no_hp'] . "</td>";

              if ($mahasiswa['status'] == 'Aktif') {
                echo "<td class='flex justify-center items-center whitespace-nowrap py-2 border-r border-b px-2'> <span class='inline-block bg-green-200 p-2 bg-opacity-50 text-green-800 rounded-lg'>Aktif</span></td>";
              } else {
                echo "<td class='flex justify-center whitespace-nowrap py-2 border-r border-b px-2'> <span class='inline-block bg-red-200 p-2 bg-opacity-50 text-red-800 rounded-lg'>Cuti</span></td>";
              }

              echo "<td class='text-center border-b px-2'>";
              echo "<a class='font-semibold text-yellow-600 hover:text-yellow-900 show-modal-edit' data-nrp='" . $mahasiswa['nrp'] . "' data-nama='" . $mahasiswa['nama'] . "'data-jenis_kelamin='" . $mahasiswa['jenis_kelamin'] . "'data-jurusan='" . $mahasiswa['jurusan'] . "'data-email='" . $mahasiswa['email'] . "'data-alamat='" . $mahasiswa['alamat'] . "'data-no_hp='" . $mahasiswa['no_hp'] . "'data-status='" . $mahasiswa['status'] . "' href=''>Edit</a> <span class='sm:hidden md:inline'>|</span> ";
              echo "<a class='font-semibold text-red-600 hover:text-red-900' href='controller/hapus.php?nrp=" . $mahasiswa['nrp'] . "'>Hapus</a>";
              echo "</td>";

              echo "</tr>";
              $i++;
            }

            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Data Start -->
  <div class="modal-new fixed left-0 top-0 h-full w-full flex justify-center items-center hidden">
    <form class="flex md:w-2/6 justify-center items-center" action="controller/tambah.php" method="POST">
      <div class="bg-white w-full rounded shadow-lg place-content-center">
        <div class="border-b px-4 py-2">
          <h1 class="font-bold text-xl">Tambah Data</h1>
        </div>
        <div class="p-3">
          <div>
            <label for="nrp"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" type="number" name="nrp" placeholder="NRP" required />
          </div>
          <div>
            <label for="nama"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" type="text" pattern="[A-Za-z ]+" name="nama" placeholder="Nama Lengkap" required />
          </div>
          <label for="jenis_kelamin">Jenis Kelamin:</label>

          <div class="flex my-4 px-4">
            <div class="w-1/2 text-center">
              <input class="hidden peer" type="radio" name="jenis_kelamin" value="laki-laki" checked>
              <label for="jenis_kelamin" class="label_jenis_kelamin text-black w-full max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-sky-600 hover:ring-blue-400 hover:ring-offset-2 peer-checked:bg-blue-900 peer-checked:text-white mx-2">Laki-Laki</label>
            </div>
            <div class="w-1/2 text-center">
              <input class="hidden peer" type="radio" name="jenis_kelamin" value="perempuan" >
              <label for="jenis_kelamin" class="label_jenis_kelamin text-black w-full max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-sky-600 hover:ring-blue-400 hover:ring-offset-2 peer-checked:bg-blue-900 peer-checked:text-white mx-2">Perempuan</label>
            </div>
          </div>

          <div>
            <label for="jurusan"></label>
            <select class="border border-b p-2 w-full my-1" name="jurusan" required>
              <option value="">-- Pilih Jurusan --</option>
              <option value="Teknik Informatika">Teknik Informatika</option>
              <option value="Sains Data Terapan">Sains Data Terapan</option>
            </select>
          </div>
          <div>
            <label for="email"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" type="email" name="email" placeholder="Email" required/>
          </div>
          <div>
            <label for="alamat"></label>
            <textarea class="border border-grey-400 py-2 px-2 w-full my-1" name="alamat" placeholder="Alamat" required></textarea>
          </div>
          <div>
            <label for="no_hp"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" type="number" name="no_hp" min="12" placeholder="No HP" required />
          </div>
          <div>
            <label for="status">Status: </label>
            <div class="flex my-4 px-4">
              <div class="w-1/2 text-center">
                <input class="hidden peer" type="radio" name="status" value="Aktif" checked>
                <label for="status" class="label_status text-black w-72 max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-green-400 hover:ring-emerald-400 hover:ring-offset-2 peer-checked:bg-green-900 peer-checked:text-white mx-2">Aktif</label>
              </div>
              <div class="w-1/2 text-center">
                <input class="hidden peer" type="radio" name="status" value="Cuti">
                <label for="status" class="label_status text-black w-72 max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-red-400 hover:ring-rose-400 hover:ring-offset-2 peer-checked:bg-red-900 peer-checked:text-white mx-2">Cuti</label>
              </div>
            </div>
          </div>
          <div class="flex justify-end items-center w-100 border-t p-3">
            <a class="close-modal-new inline-block bg-red-200 p-2 rounded bg-opacity-50 text-red-500 font-medium hover:bg-red-400 hover:text-red-700 hover:bg-opacity-50 m-1" href="#">Batal</a>
            <button class="inline-block bg-green-200 p-2 rounded bg-opacity-50 text-green-500 font-medium hover:bg-green-400 hover:text-green-700 hover:bg-opacity-50 m-1" href="#" type="submit" name="tambah">Tambah</button>
          </div>
        </div>
      </div>
    </form>
    <div class="close-modal-new bg-edit bg-black w-full h-full bg-opacity-50 absolute -z-10">
    </div>
  </div>
  <!-- Modal Tambah Data End -->
  <!-- Modal Edit Data Start -->
  <div class="modal-edit fixed left-0 top-0 h-full w-full flex justify-center items-center hidden">
    <form class="flex md:w-2/6 justify-center items-center" action="controller/edit.php" method="POST">
      <div class="bg-white w-full rounded shadow-lg place-content-center">
        <div class="border-b px-4 py-2">
          <h1 class="font-bold text-xl">Edit Data</h1>
        </div>
        <div class="p-3">
          <input type="number" class="hidden" name="nrp_awal" id="nrp_awal" placeholder="Masukkan NRP..." />

          <div>
            <label for="nrp"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" id="nrp" type="number" name="nrp" placeholder="Masukkan NRP..." />
          </div>
          <div>
            <label for="nama"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" id="nama" type="text" pattern="[A-Za-z ]+" name="nama" placeholder="Masukkan Nama Lengkap..." />

          </div>
          <label for="edit_jenis_kelamin">Jenis Kelamin:</label>

          <div class="flex my-4 px-4">
            <div class="w-1/2 text-center">
              <input class="hidden peer" type="radio" name="edit_jenis_kelamin" value="laki-laki" checked>
              <label for="edit_jenis_kelamin" class="label_edit_jenis_kelamin text-black w-full max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-sky-600 hover:ring-blue-400 hover:ring-offset-2 peer-checked:bg-blue-900 peer-checked:text-white mx-2">Laki-Laki</label>
            </div>
            <div class="w-1/2 text-center">
              <input class="hidden peer" type="radio" name="edit_jenis_kelamin" value="perempuan" >
              <label for="edit_jenis_kelamin" class="label_edit_jenis_kelamin text-black w-full max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-sky-600 hover:ring-blue-400 hover:ring-offset-2 peer-checked:bg-blue-900 peer-checked:text-white mx-2">Perempuan</label>
            </div>
          </div>

          <div>
            <label for="jurusan"></label>
            <select class="border border-b p-2 w-full my-1" id="jurusan" name="jurusan">
              <option value="Teknik Informatika">Teknik Informatika</option>
              <option value="Sains Data Terapan">Sains Data Terapan</option>
            </select>
          </div>
          <div>
            <label for="email"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" id="email" type="email" name="email" placeholder="Masukkan email ..." />
          </div>
          <div>
            <label for="alamat"></label>
            <textarea class="border border-grey-400 py-2 px-2 w-full my-1" id="alamat" name="alamat" placeholder="Masukkan Alamat..."></textarea>
          </div>
          <div>
            <label for="no_hp"></label>
            <input class="border border-grey-400 py-2 px-2 w-full my-1" id="no_hp" type="number" name="no_hp" placeholder="Masukkan No HP..." />
          </div>
          <label for="edit_status">Status: </label>
            <div class="flex my-4 px-4">
              <div class="w-1/2 text-center">
                <input class="hidden peer" type="radio" name="edit_status" value="Aktif">
                <label for="edit_status" class="label_edit_status text-black w-72 max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-green-400 hover:ring-emerald-400 hover:ring-offset-2 peer-checked:bg-green-900 peer-checked:text-white mx-2">Aktif</label>
              </div>
              <div class="w-1/2 text-center">
                <input class="hidden peer" type="radio" name="edit_status" value="Cuti">
                <label for="edit_status" class="label_edit_status text-black w-72 max-w-xl rounded-md bg-white p-3 text-gray-600 ring-2 ring-transparent transition-all hover:shadow hover:text-red-400 hover:ring-rose-400 hover:ring-offset-2 peer-checked:bg-red-900 peer-checked:text-white mx-2">Cuti</label>
              </div>
            </div>
          <div class="flex justify-end items-center w-100 border-t p-3">
            <a class="close-modal-edit inline-block bg-red-200 p-2 rounded bg-opacity-50 text-red-500 font-medium hover:bg-red-400 hover:text-red-700 hover:bg-opacity-50 m-1" href="#">Batal</a>
            <button class="inline-block bg-green-200 p-2 rounded bg-opacity-50 text-green-500 font-medium hover:bg-green-400 hover:text-green-700 hover:bg-opacity-50 m-1" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
    <div class="close-modal-edit bg-edit bg-black w-full h-full bg-opacity-50 absolute -z-10">
    </div>

  </div>
  <!-- Modal Edit Data End -->

  <script>
    // Modal New
    const modalNew = document.querySelector('.modal-new');

    const showModalNew = document.querySelectorAll('.show-modal-new');
    for (var i = 0; i < showModalNew.length; i++) {
      showModalNew[i].addEventListener('click', function() {
        modalNew.classList.remove('hidden');
      });
    }

    const closeModalNew = document.querySelectorAll('.close-modal-new');
    for (var i = 0; i < closeModalNew.length; i++) {
      document.querySelectorAll('.bg-edit')[i].addEventListener('click', function() {
        modalNew.classList.add('hidden')

      });
      closeModalNew[i].addEventListener('click', function() {
        modalNew.classList.add('hidden')
      });
    }

    const jkButton = document.getElementsByName('jenis_kelamin');
    const labelJk = document.getElementsByClassName('label_jenis_kelamin');
    labelJk[0].addEventListener('click', function() {
      jkButton[0].checked = true;
      jkButton[1].checked = false;
    });

    labelJk[1].addEventListener('click', function() {
      jkButton[1].checked = true;
      jkButton[0].checked = false;
    });

    const statusButton = document.getElementsByName('status');
    const labelStatus = document.getElementsByClassName('label_status');
    labelStatus[0].addEventListener('click', function() {
      statusButton[0].checked = true;
      statusButton[1].checked = false;
    });

    labelStatus[1].addEventListener('click', function() {
      statusButton[1].checked = true;
      statusButton[0].checked = false;
    });
    // Modal Edit
    const modalEdit = document.querySelector('.modal-edit');

    const showModalEdit = document.querySelectorAll('.show-modal-edit');
    for (var i = 0; i < showModalEdit.length; i++) {
      console.log('index', i);
      const nrp = showModalEdit[i].getAttribute('data-nrp');
      const nama = showModalEdit[i].getAttribute('data-nama');
      const email = showModalEdit[i].getAttribute('data-email');
      const alamat = showModalEdit[i].getAttribute('data-alamat');
      const no_hp = showModalEdit[i].getAttribute('data-no_hp');
      const jenis_kelamin = showModalEdit[i].getAttribute('data-jenis_kelamin');
      const jurusan = showModalEdit[i].getAttribute('data-jurusan');
      const status = showModalEdit[i].getAttribute('data-status');

      showModalEdit[i].addEventListener('click', function(event) {
        event.preventDefault();
        modalEdit.setAttribute('data', "nrp: " + nrp);
        modalEdit.classList.remove('hidden');
        document.getElementById('nrp').setAttribute('value', nrp);
        document.getElementById('nrp_awal').setAttribute('value', nrp);
        document.getElementById('nama').setAttribute('value', nama);
        document.getElementById('email').setAttribute('value', email);
        document.getElementById('alamat').value = alamat;
        document.getElementById('no_hp').setAttribute('value', no_hp);

        var index = jenis_kelamin == 'Laki-laki' ? 0 : 1;
        document.getElementsByName('edit_jenis_kelamin')[index == 0 ? 1 : 0].checked = false;
        document.getElementsByName('edit_jenis_kelamin')[index].checked = true;

        index = status == 'Aktif' ? 0 : 1;
        console.log('testing',document.getElementsByName('edit_status'));
        document.getElementsByName('edit_status')[index == 0 ? 1 : 0].checked = false;
        document.getElementsByName('edit_status')[index].checked = true;
        document.getElementById('jurusan').value = jurusan;


        console.log('test');
      });
    }

    const closeModalEdit = document.querySelectorAll('.close-modal-edit');
    for (var i = 0; i < closeModalEdit.length; i++) {
      document.querySelectorAll('.bg-edit')[i].addEventListener('click', function() {
        modalEdit.classList.add('hidden')

      });
      closeModalEdit[i].addEventListener('click', function() {
        modalEdit.classList.add('hidden')
      });
    }

    const jkButtonEdit = document.getElementsByName('edit_jenis_kelamin');
    const labelJkEdit = document.getElementsByClassName('label_edit_jenis_kelamin');
    labelJkEdit[0].addEventListener('click', function() {
      jkButtonEdit[0].checked = true;
      jkButtonEdit[1].checked = false;
    });

    labelJkEdit[1].addEventListener('click', function() {
      jkButtonEdit[1].checked = true;
      jkButtonEdit[0].checked = false;
    });

    const statusButtonEdit = document.getElementsByName('edit_status');
    const labelStatusEdit = document.getElementsByClassName('label_edit_status');
    labelStatusEdit[0].addEventListener('click', function() {
      console.log('hello');
    console.log('edit status',statusButtonEdit[0]);
      statusButtonEdit[0].checked = true;
      statusButtonEdit[1].checked = false;
    });

    labelStatusEdit[1].addEventListener('click', function() {
      statusButtonEdit[1].checked = true;
      statusButtonEdit[0].checked = false;
    });
  </script>
</body>

</html>