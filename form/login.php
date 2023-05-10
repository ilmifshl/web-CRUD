<?php
session_start();
include("../connect.php");

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($db, "SELECT username FROM user WHERE user_id = $id");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <title>Login</title>
</head>

<body class="bg-slate-100 flex justify-center items-center">
    <div class="flex justify-center items-center bg-white w-1/2 h-1/2 my-14 rounded-lg">
        <div class="w-1/2 my-24">
            <p class="  mb-6 text-center text-3xl font-bold">Login</p>

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