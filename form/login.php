<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />

    <title>Landing Page</title>
</head>

<body>
    <section class="bg-gray-200 min-h-screen flex justify-center items-center">
        <!-- Login container -->
        <div class="bg-[#C0C9BA] flex rounded-2xl shadow-xl max-w-3xl">
            <!-- form -->
            <div class="w-1/2 px-16 mt-24 items-center">
                <h2 class="font-bold text-2xl pt-2">Login</h2>
                <p class="text-sm mt-2">Lorem, ipsum dolor sit amet consectetur adipisicing.</p>

                <form action="" class="flex flex-col gap-2.5">
                    <input class="p-2 mt-4 rounded-xl border" type="email" name="email" id="email" placeholder="Email">
                    <input class="p-2 rounded-xl border" type="password" name="password" placeholder="Password">
                    <div class="flex items-center mr-4">
                        <input checked id="green-checkbox" type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                        <label for="green-checkbox" class="ml-2 text-sm font-medium text-slate-700">Ingat saya</label>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>