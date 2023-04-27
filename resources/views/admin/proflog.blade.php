<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

        <title>IT Center</title>
        
        <style>
            table {
        table-layout: fixed;
        }

        td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        }

        tr:hover,
        td:hover {
        white-space: normal;
        overflow: visible;
        }
        </style>
        
        

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
        {{-- end of header --}}
        <h1 class="flex justify-center ml-36 text-gray-500 text-4xl font-bold italic">Instructor Logs</h1>


        <div class="flex justify-end mt-5 mr-10">
            <div class="overflow-y-auto shadow-md sm:rounded-lg md:w-4/5 h-teria">
                {{-- filters --}}
                <div class="flex items-center justify-between pb-4">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" id="myInput" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                    </div>
                </div>
                {{-- end of filter --}}
                {{-- table --}}
                <table class="hoverable w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 text-left pl-2">
                                NAME
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                DAY
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                TIME IN
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                TIME OUT
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                SUBJETC
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                SECTION
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                ROOM #
                            </th>
                            <th scope="col" class="py-3 text-left pl-2">
                                FEEDBACK
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @foreach ($proflogs as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 text-left pl-2">
                                {{ $item->name }}
                            </td>
                            <td class="py-3 text-left pl-2">
                                {{ $item->day }}
                            </td>
                            <td class="py-3 text-left pl-2">
                                {{ \Carbon\Carbon::parse($item->start_time)->format('g:i A') }}
                                {{-- {{ $item->start_time }} --}}
                            </td>
                            <td class="py-3 text-left pl-2">
                                {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') }}
                                {{-- {{ $item->end_time }} --}}
                            </td>
                            <td class="py-3 text-left pl-2">
                                {{ $item->subject }}
                            </td>
                            <td class="py-3 text-left pl-2">
                                {{ $item->section }}
                            </td>
                            <td class="py-3 text-left pl-2">
                                LAB {{ $item->room }}
                            </td>
                            <td class="py-3 text-left pl-2">
                                {{ $item->feedback }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- table end --}}
            </div>

        </div>

        {{-- sidebar --}}
        <aside id="default-sidebar" class="fixed top-16 left-0 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
            <div class="h-screen px-3 py-4 overflow-y-auto bg-gray-100 text-black font-serif">
                <h1 class="flex items-center p-2 text-3xl font-serif text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</h1><br>
                <ul class="space-y-2">
                    <li>
                        <a href="/dashboard" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white">
                        <span class="ml-3">Student Logs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/instruc/logs" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white">
                        <span class="ml-3">Instructor Logs</span>
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

{{-- javascript --}}
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
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

    $(document).ready(function() {
        $('table.hoverable').hover(function() {
            $(this).addClass('full-content');
        }, function() {
            $(this).removeClass('full-content');
        });
    });
</script>

