<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        
        <title>IT Center</title>
    </head>
    <body class="bg-white drop-shadow-lg">
        {{-- header --}}
        <div class="w-full h-16 bg-green-800 drop-shadow-lg">
            <div class="container px-4 md:px-0 h-full mx-auto flex justify-between items-center">
                <h1 class="text-yellow-500 text-2xl font-bold italic">Welcome <span class="text-white">{{ Session::get('user_firstname') }}</span>
                </h1>
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
        
        <h1 class="flex justify-center ml-32 text-gray-500 text-4xl font-bold italic"> {{ $secNum }} </h1>

        <div class="flex justify-center mt-10 ml-48">
            <div class="w-full md:w-4/5 px-3 mb-6">
                <div class="overflow-y-auto shadow-md sm:rounded-lg">
                    @if(session::has('success'))
                        <div class="flex justify-center p-5 bg-red-600 text-white">
                            {{ session('success') }}
                        </div>
                        @elseif(session::has('updated'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('updated') }}
                        </div>
                    @endif
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 text-left pl-2">
                                    First Name
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Middle Name
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Last Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $item)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    
                                    <td class="py-3 pl-2">
                                        {{ $item->fname }}
                                    </td>
                                    <td class="py-3 pl-2">
                                        {{ $item->mname }}
                                    </td>
                                    <td class="py-3 pl-2">
                                        {{ $item->lname }}
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        
        </div>
        
        {{-- sidebar --}}
        <aside id="default-sidebar" class="fixed top-16 left-0 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
            <div class="h-screen px-3 py-4 overflow-y-auto bg-gray-100 text-black font-serif">
                <h1 class="flex items-center p-2 text-3xl font-serif text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</h1><br>
                <ul class="space-y-2">
                    <li>
                        <a href="/dashboard" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white">
                        <span class="ml-3">Logs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/import/form" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex-1 ml-3 whitespace-nowrap">Rooms</span>
                        </a>
                    </li>
                    <li>
                        <a href="/section" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex-1 ml-3 whitespace-nowrap">Sections</span>
                        </a>
                    </li>
                    <li>
                        <a href="/subject" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex-1 ml-3 whitespace-nowrap">Subjects</span>
                        </a>
                    </li>
                    <li>
                        <a href="/users" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex-1 ml-3 whitespace-nowrap">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="/addsched" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span class="flex-1 ml-3 whitespace-nowrap">Schedules</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>

    </body>
</html>

<script>
    var menu = document.getElementById('menu');
    function toggleMenu() {
        menu.classList.toggle('hidden');
        menu.classList.toggle('w-full');
        menu.classList.toggle('h-screen');
    }

    $(document).ready(function(){
        $('#status').on('change', function(){
            var demovalue = $(this).val(); 
            $("div.course_container1").hide();
            $("div.course_container2").hide();
            $("div.section_container1").hide();
            $("div.section_container2").hide();
            $("#showOne"+demovalue).show();
            $("#show2"+demovalue).show();   
            $("#display1"+demovalue).show();
            $("#display2"+demovalue).show();
        });
    });
</script>
