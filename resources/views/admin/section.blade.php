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
        
        <h1 class="flex justify-center text-gray-500 text-4xl font-bold italic m-3 ml-96">Sections</h1>
        {{-- table --}}

        {{-- Modal Content --}}
        <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden absolute w-full p-4 z-10 overflow-x-hidden overflow-y-auto">
            <div class="relative h-full w-96 md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Allow Section
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="py-5 space-y-2">
                        <form action="{{ '/section/status/' }}" method="POST" class="space-y-2"> @csrf
                            <div class="flex justify-center">
                                <select class="block text-center py-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 italic" name="lab" id="filter" required>
                                    <option value="none" disabled selected>Select Laboratory</option>
                                    @foreach ($rooms as $lab)
                                    <option value="{{ $lab->id }}" id="student">{{ $lab->room }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <input type="hidden" value="" name="section_id" id="section_id">
                            <div class="flex justify-center">
                                <select class="block text-center py-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 italic" name="profname" id="filter" required>
                                    <option value="none" disabled selected>Select Instructor</option>
                                    @foreach ($instructors as $prof)
                                    <option value="{{ $prof->fname }} {{ $prof->lname }}" id="student">{{ $prof->fname }} {{ $prof->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-center">
                                <select class="block text-center py-2 text-sm text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 italic" name="subject" id="filter" required>
                                    <option value="none" disabled selected>Select Subject</option>
                                    @foreach ($subjects as $sub)
                                    <option value="{{ $sub->subject }}" id="student">{{ $sub->subject }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <input type="text" value="{{ $hiddedID }}"> --}}
                            <div class="flex justify-center">
                                <input type="submit" value="ALLOW ACCESS" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            </div>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="flex flex-row-reverse mt-5">
            <div  class="w-full md:w-3/5 px-3 mb-6 mr-14">
                <div class="overflow-y-auto shadow-md sm:rounded-lg h-96">
                    @if(session::has('success'))
                        <div class="flex justify-center p-5 bg-red-600 text-white">
                            {{ session('success') }}
                        </div>
                        @elseif(session::has('allow'))
                        <div class="flex justify-center p-5 bg-green-500 text-white">
                            {{ session('allow') }}
                        </div>
                        @elseif(session::has('notallow'))
                        <div class="flex justify-center p-5 bg-red-600 text-white">
                            {{ session('notallow') }}
                        </div>
                    @endif
                    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Section name
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $section)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <td class="py-3 pl-2">
                                        {{ $section->section }}
                                    </td>
                                    <td class="py-3 pl-2">
                                        <a href="{{ '/section/delete/'.$section->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete |</a>
                                        {{-- modal button --}}
                                        <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" name="secID" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="getSectionID({{ $section->id }})">
                                            Allow |
                                        </button>
                                        
                                        
                                        {{-- <a href="{{ /section/status/.$section->id }}" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Allow |</a> --}}
                                        <a href="{{ '/status/section/'.$section->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Not Allow |</a>
                                        <a href="{{ '/section/view/'.$section->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- end table --}}
            {{-- form --}}
            <div class="container-sm bg-green-700 p-5 flex justify-end h-52 mr-8" id="addsec">
                <form id="frm" method="POST" action="{{ route('addsec') }}">
                    @csrf
                    <h1 class="flex justify-center mb-5 text-lg font-semibold text-white">Add Section</h1>
                    <div class="mb-6">
                    <input type="text" id="" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light italic" placeholder="section name" name="section" required>
                    </div>
                    <div class="mb-6">
                    <div class="flex items-start mb-6">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex justify-center w-full">Add section</button>
                </form>
            </div>
            {{-- end form --}}

            {{-- section status form
            <div>
                <form action="" method="post">
                    @csrf
                    <input type="text">
                </form>
            </div> --}}

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
        
        



        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    </body>
</html>
<script>

    function getSectionID(section_id){
        
        document.getElementById('section_id').value = section_id;

    }

</script>