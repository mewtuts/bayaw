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
        
        <h1 class="flex justify-center text-gray-500 text-4xl font-bold italic m-3 ml-96">Subjects</h1>

        <div class="flex flex-row-reverse mt-5">
            <div  class="w-full md:w-3/5 px-3 mb-6 mr-14">
                <div class="overflow-y-auto shadow-md sm:rounded-lg h-96">
                    @if(session::has('success'))
                        <div class="flex justify-center p-5 bg-red-600 text-white">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Subject name
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Subject Code
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="py-3 pl-2">
                                    {{ $subject->subject }}
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $subject->subject_code }}
                                </td>
                                <td class="py-3 pl-2">
                                    <a href="{{ '/subject/delete/'.$subject->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="container-sm bg-green-700 p-5 flex justify-end h-64 mr-8" id="addsec">
                <form id="frm" method="POST" action="{{ route('addsub') }}">
                    @csrf
                    <h1 class="flex justify-center mb-5 text-lg font-semibold text-white">Add Subject</h1>
                    <div class="mb-6">
                        <input type="text" id="" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" placeholder="subject name" name="subject" required>
                    </div>
                    <div class="mb-6">
                        <input type="text" id="" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" placeholder="subject code" name="subject_code" required>
                    </div>
                    <div class="mb-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex justify-center w-full">Add subject</button>
                    </div>
                </form>
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
        
  
    </body>
</html>