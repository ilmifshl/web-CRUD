<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Landing Page</title>
</head>

<body>
    <section class="bg-gray-200 min-h-screen flex justify-center items-center">
        <!-- Login container -->
        <div class="bg-[#C0C9BA] flex rounded-2xl shadow-xl max-w-3xl">
            <!-- form -->
            <div class="w-1/2 px-16 mt-24 items-center">
                <h2 class="font-bold text-2xl pt-2">Login</h2>
                <p class="text-sm mt-2">Isi dengan Email dan Password yang sudah terdaftar.</p>

                <form action="" class="flex flex-col gap-2.5">
                    <input class="p-2 mt-4 rounded-xl borber" type="email" name="email" id="email" placeholder="Email">
                    <input class="p-2 rounded-xl borber" type="password" name="password" placeholder="Password">
                    <button class="bg-green-800 rounded-xl text-white py-2">Login</button>
                </form>
                <div class="flex items-center m-2">
                    <div class="border border-gray-500 flex-grow"></div>
                    <div class="mx-4 text-gray-500">atau</div>
                    <div class="border border-gray-500 flex-grow"></div>
                </div>
                <h2 class="text-center">Belum punya akun? <a href="#" class="text-green-800">Daftar</a></h2>
            </div>

            <!-- image -->
            <div class="w-1/2">
                <img class=" rounded-2xl" src="../image/image.jpg" alt="">
            </div>
        </div>
    </section>
</body>

</html>