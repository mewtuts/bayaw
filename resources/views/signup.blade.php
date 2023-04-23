<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        <style>
        #show1Student{
            display: none;
        }
        #show2Student{
            display: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <title>Home</title>
</head>
<body >

    <header class="w-full h-16 bg-green-800 drop-shadow-lg">
        <div class="container px-4 md:px-0 h-full mx-auto flex justify-between items-center">
            <!-- Logo Here -->
            <a class="text-yellow-600 text-2xl font-bold italic" href="#">COMPUTER <span
                    class="text-white">LABORATORY</span></a>

            <!-- Menu links here -->
            <ul id="menu" class="hidden fixed top-0 right-0 px-10 py-16 bg-gray-800 z-50
                md:relative md:flex md:p-0 md:bg-transparent md:flex-row md:space-x-6">

                <li class="md:hidden z-90 fixed top-4 right-6">
                    <a href="javascript:void(0)" class="text-right text-white text-4xl"
                        onclick="toggleMenu()">&times;</a>
                </li>
                <li>
                    <a class="text-white opacity-80 hover:opacity-100" href="{{ '/' }}">LOGIN</a>
                </li>
                <li>
                    <a class="px-10 py-2 bg-blue-600 text-white rounded-md
                    hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" href="{{ 'signup' }}">SIGNUP</a>
                </li>
            </ul>

            <!-- This is used to open the menu on mobile devices -->
            <div class="flex items-center md:hidden">
                <button class="text-white text-4xl font-bold opacity-70 hover:opacity-100 duration-300"
                    onclick="toggleMenu()">
                    &#9776;
                </button>
            </div>
        </div>

    </header>

    <div class="flex justify-center items-center bg-slate-500 py-24">
        
        <form class="p-5 bg-white rounded-xl drop-shadow-lg space-y-2" action="{{ route('updateinfo') }}" method="POST">
            @csrf
            
            <h1 class="text-center text-4xl">Sign up</h1>
            @if (Session::has('fail'))
                <div class="flex justify-center p-5 bg-red-600 text-white">
                    {{ session('fail') }}
                </div>
            @endif
            <div class="flex flex-col">
                <label class="text-base font-semibold" for="">Email</label>
                <input class="w-96 px-2 py-1 rounded-md border border-slate-400" type="email"
                    placeholder="tau@edu.ph" name="email" id="email" required>
            </div>
            <div class="flex flex-col">
                <label class="text-base font-semibold" for="">ID Number</label>
                <input class="w-96 px-2 py-1 rounded-md border border-slate-400" type="number"
                placeholder="20******85" name="id_number" id="id_number" required>
            </div>                        
            <div class="flex flex-col">
                <label class=" font-semibold" for="">Username</label>
                <input class="w-96 px-2 py-1 rounded-md border border-slate-400" type="text" placeholder="Username" name="username" id="username" required>
            </div>
            <div class="flex flex-col">
                <label class="text-base font-semibold" for="">Password</label>
                <input class="w-96 px-2 py-1 rounded-md border border-slate-400" type="password" placeholder="Your Password" name="password" id="password" required>
            </div>
            <input class="w-full px-10 py-2 bg-blue-600 text-white rounded-md
            hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" type="submit" name="update" value="Sign up"></input>
        </form>
    </div>

    <!-- Javascript Code -->
    <script>
        var menu = document.getElementById('menu');
        function toggleMenu() {
            menu.classList.toggle('hidden');
            menu.classList.toggle('w-full');
            menu.classList.toggle('h-screen');
        }
        $(document).ready(function(){
            $('#user_type').on('change', function(){
                var demovalue = $(this).val(); 
                $("div.course_container1").hide();
                $("div.course_container2").hide();
                $("#show1"+demovalue).show();
                $("#show2"+demovalue).show();   
            });
        });
    </script>
</body>
</html>