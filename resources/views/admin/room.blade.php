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
        {{-- end of header --}}
        
        {{-- title --}}
        <h1 class="flex justify-center text-gray-500 text-4xl font-bold italic m-3 ml-48">Laboratories</h1>
        {{-- end of title --}}

        {{-- import and export --}}
        <div class="grid grid-cols-2 mx-52 mr-5">
            <div class="container-sm bg-green-700 p-3 flex justify-center" >
                <form action="{{ '/import/save' }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <label for="upload" class="cursor-pointer underline italic uppercase w-full flex justify-center text-white">Upload File</label>
                    <input type="file" name="import_file" id="upload" class="hidden italic uppercase w-full text-white" accept=".xlsx,.xls,.csv" required>
                    <input type="submit" value="Import" class="cursor-pointer italic font-semibold underline w-full text-white hover:text-blue-300 p-1" >
                </form>
            </div>
            <div class="container-sm bg-green-700 p-3" >
                <form action="{{ '/export/file' }}" enctype="multipart/form-data">
                @csrf
                    <label for="" class="underline italic uppercase w-full flex justify-center text-white">Download File</label>
                    <input type="submit" value="Export" class="cursor-pointer italic font-semibold underline w-full text-white hover:text-blue-300 p-1" >
                </form>
            </div>
        </div>
        {{-- end of import and export --}}

        <div class="item-center flex sm:flex w-4/5 mt-2 ml-60">
            {{-- form --}}
            <div class="container-sm w-1/4 bg-green-700 p-5 flex justify-center h-1/3 mb-5 mr-20" id="addsec">
                <form id="frm" method="POST" {{-- action=" route('addpc')" --}} action="{{ route('add_lab') }}" enctype="multipart/form-data"> 
                    @csrf
                    <h1 class="flex justify-center mb-5 text-lg font-semibold text-white">Add Laboratories</h1>
                    <div class="mb-3 w-60">
                        <input class="uppercase text-center shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" type="text" id="showOne" name="lab" placeholder="Lab Number">
                    </div>
                    {{--
                    <div class="mb-3">
                        <select class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" name="lab_num" id="lab_num">
                            <option value="none" disabled selected>LAB NUMBER</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" id="">{{ $room->room}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" name="pc_num" id="">
                            <option value="none" disabled selected>PC NUMBER</option>
                            @foreach ($array as $num)
                                @if ($num != 0)
                                <option value="PC {{ $num }}" id="">PC {{ $num }}</option>
                                @endif
                            @endforeach
                        
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" name="status" id="status">
                            <option value="none" disabled selected>STATUS</option>
                            <option value="NOT-WORKING" id="student">NOT-WORKING</option>
                            <option value="WORKING" id="instructor">WORKING</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <input class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" type="text" id="showOne" name="issue" placeholder="Issue">
                    </div> --}}
                    
                    <div class="mb-3 w-full">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex justify-center w-full">Add Laboratory</button>
                    </div>
                    
                </form>
            </div>
            {{-- end of form --}}

            {{-- table for labs
            <div class="w-36 mb-6 mr-20">
                <div class="overflow-y-auto shadow-md sm:rounded-lg h-96">
                    <table class="w-full uppercase text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 text-left pl-2">
                                    LAB Number
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    
                                    <td class="py-3 pl-2">
                                        {{ $room->room }}
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div> --}}


            {{-- table for units --}}
            <div class="mb-6 w-3/5">
                <div class="overflow-y-auto shadow-md sm:rounded-lg h-96">
                    @if(session::has('success'))
                        <div class="flex justify-center p-5 bg-red-600 text-white">
                            {{ session('success') }}
                        </div>
                        @elseif(session::has('updated'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('updated') }}
                        </div>
                        @elseif (session::has('imported'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('imported') }}
                        </div>
                        @elseif (session::has('added_lab'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('added_lab') }}
                        </div>
                    @endif
                    <table class="w-full uppercase text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 text-left pl-2">
                                    LAB Number
                                </th>
                                {{-- <th scope="col" class="py-3 text-left pl-2">
                                    number of units
                                </th> --}}
                                <th scope="col" class="py-3 text-left pl-2">
                                    action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                            {{-- @if ( $room = ) --}}
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        
                                    <td class="py-3 pl-2">
                                        {{ $room->room }}
                                    </td>
                                    {{-- <td class="py-3 pl-2">
                                        {{ $room->id }}
                                    </td> --}}
                                    <td class="py-3 pl-2">
                                        <a class="underline text-blue-700 italic" href="{{ '/room/view/'.$room->id }}">view</a>
                                    </td>
                                    
                                </tr>
                            {{-- @endif --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
            {{-- end of taable --}}

            
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
        {{-- end of sidebar --}}
        
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

    // document.querySelector('input[type="file"]').addEventListener('change', function() {
    //     document.querySelector('#frm').submit();
    // });

</script>