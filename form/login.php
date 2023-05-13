<?php
session_start();
include("../connect.php");

if (isset($_COOKIE["email"]) && isset($_COOKIE["key"])) {
    $email = $_COOKIE["email"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($db, "SELECT username FROM user WHERE email = $email");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash("sha256", $row["username"])) {
        $_SESSION["login"] = true;
    }
}

if (isset($_SESSION["login"])) {
    if (isset($_SESSION["role"]) == 'guest') {
        $_SESSION["role"] = 'guest';
        header("Location: ../guest_page.php");
        exit;
    } else if ($row["role"] == "dosen") {
        $_SESSION["role"] = "dosen";
        header("Location: ../dosen_page.php");
        exit;
    } else if ($row["role"] == "mahasiswa") {
        $_SESSION["role"] = "mahasiswa";
        header("Location: ../mahasiswa_page.php");
        exit;
    }
    header("Location: ../index.php");
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <title>Login</title>
</head>

<body class="bg-slate-100 flex justify-center items-center relative">
    <?php if (isset($_SESSION["logout_message"])) : ?>
        <div id="toast-success" class="absolute top-4 right-2 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow " role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg ">
                <i class='bx bx-check text-2xl'></i>
            </div>
            <div class="ml-3 text-sm font-normal"><?= $_SESSION["logout_message"] ?></div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 " data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    <?php endif ?>
    <div class="flex justify-center items-center bg-white w-1/2 h-1/2 my-14 rounded-lg">
        <div class="w-1/2 my-24">
            <p class=" text-center text-3xl font-bold">Login</p>
            <?php if (isset($_SESSION["error_message"])) : ?>
                <p class="mt-2 mb-4 text-red-600 text-center"><?= $_SESSION["error_message"] ?></p>
            <?php endif ?>
            <form class="" action="../controller/login.php" method="POST" enctype="multipart/form-data">
                <div class="my-4">
                    <div class="relative">
                        <input type="email" name="email" id="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " required />
                        <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                    </div>
                </div>

                <div class="my-4">
                    <div class="relative">
                        <input type="password" name="password" id="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer" placeholder=" " required />
                        <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
                    </div>
                </div>
                <div class="flex items-center mr-4 mb-4">
                    <input name="remember" id="green-checkbox" type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="green-checkbox" class="ml-2 text-sm font-medium text-slate-700">Ingat saya</label>
                </div>

                <div class="flex justify-center items-center">
                    <button type="submit" name="login" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-16 py-2.5 text-center ">Login</button>
                </div>
                <div class="flex items-center m-2">
                    <div class="border border-gray-500 flex-grow"></div>
                    <div class="mx-4 text-gray-500">atau</div>
                    <div class="border border-gray-500 flex-grow"></div>
                </div>
                <h2 class="text-center">Belum punya akun? <a href="./register.php" class="text-green-600 hover:text-green-800">Daftar</a></h2>
            </form>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>

<?php
unset($_SESSION["logout_message"]);
unset($_SESSION["error_message"]);
?>