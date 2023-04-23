{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Document</title>
</head>
<body class="w-full h-16 bg-green-800 drop-shadow-lg">
    <header class="w-full h-16 bg-slate-500 drop-shadow-lg">
        <div class="container px-4 md:px-0 h-full mx-auto flex justify-between items-center">
            <!-- Logo Here -->
            <h1 class="text-yellow-500 text-2xl font-bold italic">Welcome <span
                class="text-white">{{ Session::get('user_firstname') }}</span></h1>

            <!-- Menu links here -->
            <ul id="menu" class="hidden fixed top-0 right-0 px-10 py-16 bg-gray-800 z-50
                md:relative md:flex md:p-0 md:bg-transparent md:flex-row md:space-x-6">

                <li class="md:hidden z-90 fixed top-4 right-6">
                    <a href="javascript:void(0)" class="text-right text-white text-4xl"
                        onclick="toggleMenu()">&times;</a>
                </li>

                <li>
                    <a class="px-10 py-2 text-white rounded-md
                    hover:text-blue-500-blue duration-300 ease-in" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>

    </header>
</body>
</html> --}}