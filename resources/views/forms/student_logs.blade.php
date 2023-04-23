<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

        <title>IT Center</title>

    </head>
<body>
    <div>
        <div class="flex justify-center text-4xl bg-green-700 p-5 mb-5 text-white font-semibold">
            <h1>You are now time in</h1>
        </div>

        <div class="flex justify-left mx-32 mt-5">
            <div class="mb-3 spspace-y-3">
                <!-- Modal toggle -->
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    Time Out
                </button>

                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="authentication-modal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>

                            <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                                    Leave a feedback
                                </h3>
                            </div>
                            <div class="p-6">
                                <form class="" action="{{ '/users/timeout' }}" method="post">@csrf
                                    <textarea id="message" name="feedback" rows="4" cols="50" class="pl-2 border border-gray-300 rounded-md"></textarea>
                                    <input type="hidden" value="{{ $mylogs->id }}" name="logid">
                                    
                                    <div class="flex justify-end">
                                        <input type="submit" value="Logout" name="submit" class="py-1 bg-red-700 w-20 text-white text-md rounded-md hover:bg-red-500 hover:drop-shadow-md duration-300 ease-in mr-1">
                                    </div>
                                    
                
                                </form>

                            </div>
                        </div>
                    </div>
                </div> 

                
            </div>
        </div>
        
        <div class="overflow-x-auto shadow-md sm:rounded-lg mx-32">
            <div class="flex items-center justify-center">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 text-left pl-2">Day</th>
                            <th scope="col" class="py-3 text-left pl-2">Start Time</th>
                            <th scope="col" class="py-3 text-left pl-2">Instructor</th>
                            <th scope="col" class="py-3 text-left pl-2">PC#</th>
                            <th scope="col" class="py-3 text-left pl-2">Section</th>
                            <th scope="col" class="py-3 text-left pl-2">Subject</th>
                            <th scope="col" class="py-3 text-left pl-2">Room#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 text-left pl-2">{{ $mylogs->day }}</td>
                            <td class="py-3 text-left pl-2">
                                {{ \Carbon\Carbon::parse($mylogs->start_time)->format('g:i A') }}
                            </td>
                            <td class="py-3 text-left pl-2">{{ $mylogs->instructor }}</td>
                            <td class="py-3 text-left pl-2"> PC {{ $mylogs->pcnum }}</td>
                            <td class="py-3 text-left pl-2">{{ $mylogs->section }}</td>
                            <td class="py-3 text-left pl-2">{{ $mylogs->subject }}</td>
                            <td class="py-3 text-left pl-2">{{ $mylogs->room }}</td>
                        </tr>
                    </tbody>
                        
                </table>
            </div>
        </div>
        {{-- <div class="flex justify-center w-screen mt-20">
            <div class="bg-green-800 p-5 w-96 h-22">
                <form class="p-3 bg-green-700 rounded-xl drop-shadow-lg space-y-3" action="{{ route('log') }}" method="post"> @csrf
                    <select name="pcnum" id="" class="block p-2 item-center text-xl text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="none" selected disabled>Select unit</option>
                        @if (count($unit) === 1)
                            <option value="none">None</option>
                        @else
                            @foreach ($unit as $item)
                            <option value="{{ $item->pc_number }}">{{ $item->pc_number }}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="hidden" name="rid" value="{{ $rid }}">
                    <input type="hidden" name="sid" value="{{ $sid }}">
                    <input type="submit" name="submit" class="w-full px-10 py-3 bg-blue-600 text-white text-lg rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" value="TIME IN" >
                
                </form>
            </div>
        </div> --}}
        

        {{-- <div class="flex justify-center w-screen mt-10">
            <form class="p-3 bg-green-700 rounded-xl drop-shadow-lg" action="" method="post">@csrf
                <a href="" class="w-full bg-blue-600 text-white text-lg rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in">
                    
                </a>
            </form>
        </div> --}}
        
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</body>
</html>