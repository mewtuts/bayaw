<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        <style>
        #show1Student{
            display: none;
        }
        #show2Student{
            display: none;
        }
        #display1Student{
            display: none;
        }
        #display2Student{
            display: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
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
        
        <div class="item-center flex items-center sm:flex justify-between md:w-4/5 mt-2 ml-60" >
            {{-- modal button --}}
            <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add User</button>

            <h1 class="flex justify-center items-center text-gray-500 text-4xl font-bold italic">Users</h1>

            <div class="bg-green-700 px-5 rounded-md">
                <form action="{{ '/save/import/users' }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <label for="upload" class="cursor-pointer underline italic uppercase w-full flex justify-center text-white">Upload File</label>
                    <input type="file" name="import_file" id="upload" class="hidden italic uppercase w-full text-white" accept=".xlsx,.xls,.csv" required>
                    <input type="submit" value="Import" name="submit" class="cursor-pointer italic font-semibold underline w-full text-white hover:text-blue-300 p-1" >
                </form>
            </div>
            
            
            
        </div>

        <div class="flex justify-end mt-5 mr-10">
        
        {{-- Modal Content --}}
        <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden absolute w-full p-4 z-10 overflow-x-hidden overflow-y-auto">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Register User
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-3 space-y-3">
                        <form class="p-3 bg-white rounded-xl drop-shadow-lg space-y-3" action="{{ '/register' }}" method="POST">
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                    First Name
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-first-name" name="fname" type="text" placeholder="First Name" required>
                                </div>
                                <div class="w-full md:w-1/3 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-middle-name">
                                    Middle Name
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" name="mname" type="text" placeholder="Middle Name" required>
                                </div>
                                <div class="w-full md:w-1/3 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    Last Name
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Last Name" name="lname" required>
                                </div>          
                            </div>
                            {{-- second row --}}
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                    ID Number
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly id="grid-first-name" name="idnumber" type="number" value="{{ $idnumber }}" placeholder="2019****85" required>
                                </div>
                                <div class="w-full md:w-1/3 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                    User type
                                    </label>
                                    <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="user_type" id="user_type" required>
                                        <option value="none" disabled selected>select</option>
                                        <option value="Student" id="student">Student</option>
                                        <option value="Instructor" id="instructor">Instructor</option>
                                        <option value="Admin" id="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="w-full md:w-1/3 px-3">
                                    <div id="display1Student" class="display_container1">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" id="display1">Section</label>
                                    </div>
                                    <div id="display2Student" class="display_container2">
                                        <select name="section" id="showOne" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="none" disabled selected>select</option>
                                            @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" id="">{{ $section->section}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full px-3">
                                    <div id="show1Student" class="course_container1">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" id="showOne">Course</label>
                                    </div>
                                    <div id="show2Student" class="course_container2">
                                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" id="showOne" name="course" placeholder="Course">
                                    </div>
                                </div>
                                
                            </div>
                            <input class="w-full px-10 py-3 bg-blue-600 text-white text-lg rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" type="submit" name="signup" value="Register"></input>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        {{-- TABLE --}}
        <div class="overflow-y-auto shadow-md sm:rounded-lg md:w-4/5">
            
            <div class="flex flex-row-reverse justify-between pb-2">
                {{-- search --}}
                <div class="relative">
                    <label for="table-search relative" class="sr-only">Search</label>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="myInput" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 italic" placeholder="Search">
                </div>
                {{-- dropdown filter --}}
                <div class="flex justify-start w-full">
                    <select class="block text-center text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 italic" name="user_types" id="filter" required>
                        <option value="none" disabled selected>User type</option>
                        <option value="Student" id="student">Student</option>
                        <option value="Instructor" id="instructor">Instructor</option>
                        <option value="Admin" id="admin">Admin</option>
                    </select>
                </div>
                
                
            </div>
            <div class="overflow-y-auto h-96">
                @if(session::has('success'))
                    <div class="flex justify-center p-5 bg-red-600 text-white">
                        {{ session('success') }}
                    </div>
                    @elseif(session::has('updated'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('updated') }}
                        </div>
                    @elseif(session::has('imported'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('imported') }}
                        </div>
                @endif
                <table class="w-full text-sm text-start text-gray-500 dark:text-gray-400" id="table1">
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
                            <th scope="col" class="py-3 text-left pl-2">
                                User type
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @foreach ($users as $user)
                            <tr class="content bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-3 pl-2">
                                    {{ $user->fname }}
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $user->mname }}
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $user->lname }}
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $user->usertype }}
                                </td>
                                </td>
                                <td class="py-3 pl-2">
                                    <a href="{{ '/users/delete/'.$user->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">delete |</a>
                                    
                                    <a href="{{ '/edit/user/'.$user->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">edit</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                </table>
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
            $("div.section_container1").hide();
            $("div.section_container2").hide();
            $("#show1"+demovalue).show();
            $("#show2"+demovalue).show();   
            $("#display1"+demovalue).show();
            $("#display2"+demovalue).show();
        });
    });
    
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function($) {
        $('#filter').change(function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

        });
    })

</script>